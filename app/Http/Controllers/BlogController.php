<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function contact()
    {
        return view('blog/contact');
    }
    
    public function news()
    {
        return view('blog/news');
    }
    
    public function newsDetails()
    {
        return view('blog/newsDetails');
    }
    
    public function newsGrid()
    {
        return view('blog/newsGrid');
    }
    
}
