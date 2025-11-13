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
        // Load categories and counts for the homepage
        // Count products via many-to-many pivot so badges reflect all assignments
        $categories = Category::withCount(['productsMany as products_count'])->orderBy('name')->get();

        // Section: Baju Pengantin → products under category "Baju Pengantin"
        $bajuPengantinCategory = Category::where('slug', 'baju-pengantin')
            ->orWhere('name', 'Baju Pengantin')
            ->first();
        $weddingProducts = $bajuPengantinCategory
            ? Product::whereHas('categories', fn($q) => $q->where('categories.id', $bajuPengantinCategory->id))->latest()->get()
            : collect();

        // Section: Aksesoris → products under category "Aksesoris"
        $aksesorisCategory = Category::where('slug', 'aksesoris')
            ->orWhere('name', 'Aksesoris')
            ->first();
        $accessoryProducts = $aksesorisCategory
            ? Product::whereHas('categories', fn($q) => $q->where('categories.id', $aksesorisCategory->id))->latest()->get()
            : collect();

        // Services area: show active services (no featured flag needed)
        $featuredServices = Service::where('active', true)->latest()->get();
        $promotion = Promotion::where('active', true)->latest('deadline_at')->first();
        $brands = Brand::where('active', true)->orderBy('name')->get();
        // Fetch all active banners for the home hero position so the slider reflects the exact count
        $banners = Banner::where('active', true)
            ->where(function($q){ $q->whereNull('position')->orWhere('position','home-hero'); })
            ->latest('updated_at')
            ->get();

        return view('home/index', compact(
            'categories',
            'weddingProducts',
            'accessoryProducts',
            'featuredServices',
            'promotion',
            'brands',
            'banners'
        ));
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
