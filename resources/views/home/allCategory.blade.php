@extends('layout.layout')

@php
    $css = '<link rel="stylesheet" href="' . asset('assets/css/variables/variable6.css') . '"/>';
    $title='All Catagory';
    $subTitle = 'Home';
    $subTitle2 = 'All Catagory';
@endphp

@section('content')

    <!-- ..::Newsletter Section Start Here::.. -->
    <div class="rts-best-catagory-section2 section-gap">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="catagory-card">
                        <div class="contents">
                            <h3 class="catagory-title">Cell Phones</h3>
                            <ul class="catagory-lists">
                                <li><a href="category.php">iPhone <i class="fal fa-angle-right"></i></a></li>
                                <li><a href="category.php">Phone Accessories <i class="fal fa-angle-right"></i></a>
                                </li>
                                <li><a href="category.php">Phone Cases <i class="fal fa-angle-right"></i></a></li>
                                <li><a href="category.php">Postpaid Phones <i class="fal fa-angle-right"></i></a></li>
                            </ul>
                            <a href="category.php" class="all-btn">All Cell Phones <i
                                    class="fal fa-long-arrow-right ml--5"></i></a>
                        </div>
                        <div class="category-thumb"><img src="{{ asset('assets/images/products/home4/catagory/1.png') }}"
                                alt="category-thumb"></div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="catagory-card">
                        <div class="contents">
                            <h3 class="catagory-title">Headphones</h3>
                            <ul class="catagory-lists">
                                <li><a href="category.php">Noise Canceling <i class="fal fa-angle-right"></i></a></li>
                                <li><a href="category.php">Over-EAR <i class="fal fa-angle-right"></i></a></li>
                                <li><a href="category.php">Premium Headphones <i class="fal fa-angle-right"></i></a>
                                </li>
                                <li><a href="category.php">Sports & Fitness <i class="fal fa-angle-right"></i></a></li>
                            </ul>
                            <a href="category.php" class="all-btn">Headphones <i
                                    class="fal fa-long-arrow-right ml--5"></i></a>
                        </div>
                        <div class="category-thumb"><img src="{{ asset('assets/images/products/home4/catagory/2.png') }}"
                                alt="category-thumb"></div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="catagory-card">
                        <div class="contents">
                            <h3 class="catagory-title">Watches</h3>
                            <ul class="catagory-lists">
                                <li><a href="category.php">Sport Watches <i class="fal fa-angle-right"></i></a></li>
                                <li><a href="category.php">Timex Watches <i class="fal fa-angle-right"></i></a></li>
                                <li><a href="category.php">Watch Brands <i class="fal fa-angle-right"></i></a></li>
                                <li><a href="category.php">Women Watches <i class="fal fa-angle-right"></i></a></li>
                            </ul>
                            <a href="category.php" class="all-btn">All Watches <i
                                    class="fal fa-long-arrow-right ml--5"></i></a>
                        </div>
                        <div class="category-thumb"><img src="{{ asset('assets/images/products/home4/catagory/3.png') }}"
                                alt="category-thumb"></div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="catagory-card">
                        <div class="contents">
                            <h3 class="catagory-title">Monitors</h3>
                            <ul class="catagory-lists">
                                <li><a href="category.php">Gaming <i class="fal fa-angle-right"></i></a></li>
                                <li><a href="category.php">Ultra Wide <i class="fal fa-angle-right"></i></a></li>
                                <li><a href="category.php">Office <i class="fal fa-angle-right"></i></a></li>
                                <li><a href="category.php">TV <i class="fal fa-angle-right"></i></a></li>
                            </ul>
                            <a href="category.php" class="all-btn">All Monitors <i
                                    class="fal fa-long-arrow-right ml--5"></i></a>
                        </div>
                        <div class="category-thumb"><img src="{{ asset('assets/images/products/home4/catagory/4.png') }}"
                                alt="category-thumb"></div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="catagory-card">
                        <div class="contents">
                            <h3 class="catagory-title">Monitors</h3>
                            <ul class="catagory-lists">
                                <li><a href="category.php">Gaming <i class="fal fa-angle-right"></i></a></li>
                                <li><a href="category.php">Ultra Wide <i class="fal fa-angle-right"></i></a></li>
                                <li><a href="category.php">Office <i class="fal fa-angle-right"></i></a></li>
                                <li><a href="category.php">TV <i class="fal fa-angle-right"></i></a></li>
                            </ul>
                            <a href="category.php" class="all-btn">All Monitors <i
                                    class="fal fa-long-arrow-right ml--5"></i></a>
                        </div>
                        <div class="category-thumb"><img src="{{ asset('assets/images/products/home4/catagory/4.png') }}"
                                alt="category-thumb"></div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="catagory-card">
                        <div class="contents">
                            <h3 class="catagory-title">Watches</h3>
                            <ul class="catagory-lists">
                                <li><a href="category.php">Sport Watches <i class="fal fa-angle-right"></i></a></li>
                                <li><a href="category.php">Timex Watches <i class="fal fa-angle-right"></i></a></li>
                                <li><a href="category.php">Watch Brands <i class="fal fa-angle-right"></i></a></li>
                                <li><a href="category.php">Women Watches <i class="fal fa-angle-right"></i></a></li>
                            </ul>
                            <a href="category.php" class="all-btn">All Watches <i
                                    class="fal fa-long-arrow-right ml--5"></i></a>
                        </div>
                        <div class="category-thumb"><img src="{{ asset('assets/images/products/home4/catagory/3.png') }}"
                                alt="category-thumb"></div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="catagory-card">
                        <div class="contents">
                            <h3 class="catagory-title">Headphones</h3>
                            <ul class="catagory-lists">
                                <li><a href="category.php">Noise Canceling <i class="fal fa-angle-right"></i></a></li>
                                <li><a href="category.php">Over-EAR <i class="fal fa-angle-right"></i></a></li>
                                <li><a href="category.php">Premium Headphones <i class="fal fa-angle-right"></i></a>
                                </li>
                                <li><a href="category.php">Sports & Fitness <i class="fal fa-angle-right"></i></a></li>
                            </ul>
                            <a href="category.php" class="all-btn">Headphones <i
                                    class="fal fa-long-arrow-right ml--5"></i></a>
                        </div>
                        <div class="category-thumb"><img src="{{ asset('assets/images/products/home4/catagory/2.png') }}"
                                alt="category-thumb"></div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="catagory-card">
                        <div class="contents">
                            <h3 class="catagory-title">Cell Phones</h3>
                            <ul class="catagory-lists">
                                <li><a href="category.php">iPhone <i class="fal fa-angle-right"></i></a></li>
                                <li><a href="category.php">Phone Accessories <i class="fal fa-angle-right"></i></a>
                                </li>
                                <li><a href="category.php">Phone Cases <i class="fal fa-angle-right"></i></a></li>
                                <li><a href="category.php">Postpaid Phones <i class="fal fa-angle-right"></i></a></li>
                            </ul>
                            <a href="category.php" class="all-btn">All Cell Phones <i
                                    class="fal fa-long-arrow-right ml--5"></i></a>
                        </div>
                        <div class="category-thumb"><img src="{{ asset('assets/images/products/home4/catagory/1.png') }}"
                                alt="category-thumb"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ..::Newsletter Section End Here::.. -->

@endsection