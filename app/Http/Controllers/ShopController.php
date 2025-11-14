<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ShopController extends Controller
{
    public function account()
    {
        return view('shop/account');
    }
    
    public function cart()
    {
        return view('shop/cart');
    }
    
    public function checkOut()
    {
        return view('shop/checkOut');
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
    
}
