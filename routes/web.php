<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\BlogController;

Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('index');
});

    // demos
Route::prefix('home')->group(function () {
    Route::controller(HomeController::class)->group(function () {
        Route::get('/index', 'index')->name('index');
        Route::get('/index-two','indexTwo')->name('indexTwo');
        Route::get('/index-three','indexThree')->name('indexThree');
        Route::get('/index-four','indexFour')->name('indexFour');
        Route::get('/index-five','indexFive')->name('indexFive');
        Route::get('/index-six','indexSix')->name('indexSix');
        Route::get('/index-seven','indexSeven')->name('indexSeven');
        Route::get('/index-eight','indexEight')->name('indexEight');
        Route::get('/index-nine','indexNine')->name('indexNine');
        Route::get('/index-ten','indexTen')->name('indexTen');
        Route::get('/all-category','allCategory')->name('allCategory');
        Route::get('/category','category')->name('category');
        Route::get('/external-products','externalProducts')->name('externalProducts');
        Route::get('/out-of-stock-products','outOfStockProducts')->name('outOfStockProducts');
        Route::get('/shop-five-column','shopFiveColumn')->name('shopFiveColumn');
        Route::get('/simple-products','simpleProducts')->name('simpleProducts');
        Route::get('/thank-you','thankYou')->name('thankYou');
        Route::get('/wishlist','wishlist')->name('wishlist');
        Route::get('/login','login')->name('login');
    });
});

    // pages
Route::prefix('pages')->group(function () {
    Route::controller(PagesController::class)->group(function () {
        Route::get('/about', 'about')->name('about');
        Route::get('/error-page','errorPage')->name('errorPage');
        Route::get('/faq','faq')->name('faq');
    });
});

    // shop
    Route::prefix('shop')->group(function () {
        Route::controller(ShopController::class)->group(function () {
            Route::get('/account', 'account')->name('account');
            Route::get('/cart','cart')->name('cart');
            Route::get('/check-out','checkOut')->name('checkOut');
            Route::get('/full-width-Shop','fullWidthShop')->name('fullWidthShop');
            Route::get('/grouped-products','groupedProducts')->name('groupedProducts');
            Route::get('/product-details','productDetails')->name('productDetails');
            Route::get('/product-details2','productDetails2')->name('productDetails2');
            Route::get('/shop','shop')->name('shop');
            Route::get('/sidebar-left','sidebarLeft')->name('sidebarLeft');
            Route::get('/sidebar-right','sidebarRight')->name('sidebarRight');
            Route::get('/variable-products','variableProducts')->name('variableProducts');
            Route::get('/grouped-products','groupedProducts')->name('groupedProducts');
        });
    });

        // blog
    Route::prefix('blog')->group(function () {
        Route::controller(BlogController::class)->group(function () {
            Route::get('/contact', 'contact')->name('contact');
            Route::get('/news','news')->name('news');
            Route::get('/newsDetails','newsDetails')->name('newsDetails');
            Route::get('/newsGrid','newsGrid')->name('newsGrid');
    });
});