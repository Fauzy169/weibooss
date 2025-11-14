<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    public function account()
    {
        return view('shop/account');
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

    public function removeFromCart(Request $request, int $id)
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
