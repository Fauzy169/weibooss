<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home/index');
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
