<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ShopController extends Controller
{
    public function account()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to access your account.');
        }
        
        // Get user's orders
        $orders = Order::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('shop/account', compact('orders'));
    }
    
    public function updateAccount(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Validate input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|confirmed',
        ], [
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
            'email.email' => 'Invalid email format',
            'email.unique' => 'Email already taken',
            'current_password.required_with' => 'Current password is required to set new password',
            'new_password.min' => 'New password must be at least 8 characters',
            'new_password.confirmed' => 'Password confirmation does not match',
        ]);

        // Update basic info
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'];
        $user->address = $validated['address'];

        // Handle password change
        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                throw ValidationException::withMessages([
                    'current_password' => 'Current password is incorrect',
                ]);
            }
            
            if ($request->filled('new_password')) {
                $user->password = Hash::make($request->new_password);
            }
        }

        $user->save();

        return redirect()->route('account')->with('success', 'Account updated successfully!');
    }
    
    public function getOrderDetails($id)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $order = Order::with(['items.product'])->where('id', $id)->where('user_id', Auth::id())->first();

        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order not found'], 404);
        }

        $orderData = [
            'id' => $order->id,
            'date' => $order->created_at->format('F d, Y H:i'),
            'status' => $order->status,
            'total' => $order->total,
            'notes' => $order->notes,
            'items' => $order->items->map(function($item) {
                // Get product image from relationship or use stored name
                $productImage = null;
                if ($item->product) {
                    $productImage = $item->product->image_url;
                }
                
                return [
                    'product_name' => $item->name,
                    'product_image' => $productImage,
                    'product_type' => strpos($item->name, 'Service') !== false ? 'service' : 'product',
                    'price' => $item->price,
                    'quantity' => $item->qty,
                    'subtotal' => $item->subtotal,
                ];
            })
        ];

        return response()->json(['success' => true, 'order' => $orderData]);
    }
    
    public function cart()
    {
        $items = session('cart', []);
        $subtotal = collect($items)->sum(fn($i) => $i['price'] * $i['qty']);
        $total = $subtotal; // no shipping calculation for now
        return view('shop/cart', compact('items', 'subtotal', 'total'));
    }
    
    public function checkOut()
    {
        $items = session('cart', []);
        if (empty($items)) {
            return redirect()->route('shop');
        }
        $subtotal = collect($items)->sum(fn($i) => $i['price'] * $i['qty']);
        $total = $subtotal;
        return view('shop/checkOut', compact('items', 'subtotal', 'total'));
    }
    
    public function fullWidthShop()
    {
        return view('shop/fullWidthShop');
    }
    
    public function productDetails(?string $slug = null)
    {
        if (!$slug) {
            return redirect()->route('shop');
        }
        $product = Product::with(['categories','category'])->where('slug', $slug)->firstOrFail();
        // Related products: other products sharing at least one category (exclude current), limit 4
        $related = Product::where('id', '!=', $product->id)
            ->whereHas('categories', function ($q) use ($product) {
                $q->whereIn('categories.id', $product->categories->pluck('id'));
            })
            ->latest()
            ->take(4)
            ->get();
        $primaryCategory = $product->category; // can be null
        $otherCategories = $product->categories->when($primaryCategory, function ($col) use ($primaryCategory) {
            return $col->where('id', '!=', $primaryCategory->id);
        });

        return view('shop/productDetails', [
            'product' => $product,
            'relatedProducts' => $related,
            'primaryCategory' => $primaryCategory,
            'otherCategories' => $otherCategories,
        ]);
    }
    
    public function productDetails2()
    {
        return view('shop/productDetails2');
    }
    
    public function shop()
    {
        return view('shop/shop');
    }
    
    public function sidebarLeft()
    {
        return view('shop/sidebarLeft');
    }
    
    public function sidebarRight()
    {
        return view('shop/sidebarRight');
    }
    
    public function variableProducts()
    {
        return view('shop/variableProducts');
    }
    public function groupedProducts()
    {
        return view('shop/groupedProducts');
    }

    public function serviceDetails(string $slug)
    {
        $service = \App\Models\Service::where('slug', $slug)->firstOrFail();
        return view('shop/serviceDetails', compact('service'));
    }

    public function addServiceToCart(Request $request, string $slug)
    {
        $service = \App\Models\Service::where('slug', $slug)->firstOrFail();
        $qty = max(1, (int) $request->input('quantity', 1));
        $cart = session('cart', []);
        
        // Use 'service_' prefix to differentiate from products
        $cartKey = 'service_' . $service->id;
        
        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['qty'] += $qty;
        } else {
            $cart[$cartKey] = [
                'id' => $service->id,
                'slug' => $service->slug,
                'name' => $service->name,
                'price' => $service->price,
                'image' => $service->image_url,
                'qty' => $qty,
                'type' => 'service', // Mark as service
            ];
        }
        session(['cart' => $cart]);

        if ($request->expectsJson()) {
            return $this->cartJson();
        }
        return redirect()->route('cart')->with('success', 'Layanan ditambahkan ke keranjang');
    }

    // Cart handlers
    public function addToCart(Request $request, string $slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        $qty = max(1, (int) $request->input('quantity', 1));
        $cart = session('cart', []);
        if (isset($cart[$product->id])) {
            $cart[$product->id]['qty'] += $qty;
        } else {
            $cart[$product->id] = [
                'id' => $product->id,
                'slug' => $product->slug,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image_url,
                'qty' => $qty,
            ];
        }
        session(['cart' => $cart]);

        if ($request->expectsJson()) {
            return $this->cartJson();
        }
        return redirect()->route('cart')->with('success', 'Produk ditambahkan ke keranjang');
    }

    public function updateCart(Request $request)
    {
        $quantities = (array) $request->input('quantities', []);
        $cart = session('cart', []);
        foreach ($quantities as $id => $qty) {
            $qty = (int) $qty;
            if ($qty <= 0) {
                unset($cart[$id]);
            } elseif (isset($cart[$id])) {
                $cart[$id]['qty'] = $qty;
            }
        }
        session(['cart' => $cart]);
        if ($request->expectsJson()) {
            return $this->cartJson();
        }
        return back()->with('success', 'Keranjang diperbarui');
    }

    public function removeFromCart(Request $request, string $id)
    {
        $cart = session('cart', []);
        unset($cart[$id]);
        session(['cart' => $cart]);
        if ($request->expectsJson()) {
            return $this->cartJson();
        }
        return back()->with('success', 'Item dihapus dari keranjang');
    }

    public function placeOrder(Request $request)
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('shop');
        }

        $subtotal = collect($cart)->sum(fn($i) => $i['price'] * $i['qty']);
        $total = $subtotal; // extend later if needed

        DB::transaction(function () use ($cart, $subtotal, $total) {
            $order = Order::create([
                'user_id' => Auth::id(),
                'subtotal' => $subtotal,
                'total' => $total,
                'status' => 'placed',
                'placed_at' => now(),
            ]);

            foreach ($cart as $i) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $i['id'] ?? null,
                    'name' => $i['name'],
                    'price' => $i['price'],
                    'qty' => $i['qty'],
                    'subtotal' => $i['price'] * $i['qty'],
                ]);
            }
        });

        session()->forget('cart');
        return redirect()->route('thankYou');
    }

    protected function cartJson()
    {
        $cart = session('cart', []);
        $qty = collect($cart)->sum('qty');
        $subtotal = collect($cart)->sum(fn($i) => $i['price'] * $i['qty']);
        return response()->json([
            'ok' => true,
            'qty' => $qty,
            'subtotal' => $subtotal,
            'subtotal_formatted' => 'Rp' . number_format($subtotal, 0, ',', '.'),
            'total' => $subtotal,
            'total_formatted' => 'Rp' . number_format($subtotal, 0, ',', '.'),
            'cart' => array_values($cart),
        ]);
    }
    
}
