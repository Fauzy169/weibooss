<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Service;
use App\Models\Promotion;
use App\Models\Brand;
use App\Models\Banner;

class HomeController extends Controller
{
    public function index()
    {
        // Load categories and a small set of featured products for the homepage
        $categories = Category::withCount('products')->orderBy('name')->get();
        $featuredProducts = Product::latest()->take(8)->get();
    $photoServices = Service::where('type', 'photo')->where('active', true)->get();
    $featuredServices = Service::where('is_featured', true)->where('active', true)->get();
    $promotion = Promotion::where('active', true)->latest('deadline_at')->first();
        $brands = Brand::where('active', true)->orderBy('name')->get();
        // Fetch all active banners for the home hero position so the slider reflects the exact count
        $banners = Banner::where('active', true)
            ->where(function($q){ $q->whereNull('position')->orWhere('position','home-hero'); })
            ->latest('updated_at')
            ->get();

        return view('home/index', compact('categories', 'featuredProducts', 'photoServices', 'featuredServices', 'promotion', 'brands', 'banners'));
    }
    
    public function indexTwo()
    {
        return view('home/indexTwo');
    }
    
    public function indexThree()
    {
        return view('home/indexThree');
    }
    
    public function indexFour()
    {
        return view('home/indexFour');
    }
    
    public function indexFive()
    {
        return view('home/indexFive');
    }
    
    public function indexSix()
    {
        return view('home/indexSix');
    }
    
    public function indexSeven()
    {
        return view('home/indexSeven');
    }
    
    public function indexEight()
    {
        return view('home/indexEight');
    }
    
    public function indexNine()
    {
        return view('home/indexNine');
    }
    
    public function indexTen()
    {
        return view('home/indexTen');
    }
    
    
    public function allCategory()
    {
        return view('home/allCategory');
    }
    
    
    public function category()
    {
        return view('home/category');
    }
    
    
    public function externalProducts()
    {
        return view('home/externalProducts');
    }
    
    
    public function outOfStockProducts()
    {
        return view('home/outOfStockProducts');
    }
    
    
    public function shopFiveColumn()
    {
        return view('home/shopFiveColumn');
    }
    
    
    public function simpleProducts()
    {
        return view('home/simpleProducts');
    }
    
    
    public function thankYou()
    {
        return view('home/thankYou');
    }
    
    
    public function wishlist()
    {
        return view('home/wishlist');
    }
    
    
    public function login()
    {
        return view('home/login');
    }
    
}
