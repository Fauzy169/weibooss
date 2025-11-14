@extends('layout.layout')

@php
$css= '<link rel="stylesheet" href="' . asset('assets/css/variables/variable1.css') . '" />';
$header='flase';
$script='<script src="' . asset('assets/js/vendors/zoom.js') . '"></script>';   
@endphp

@section('content')

    <style>
        /* Uniform image sizing across sections */
        .img-fit-square { width: 100%; aspect-ratio: 1 / 1; object-fit: cover; display: block; }
        .img-fit-product { width: 100%; aspect-ratio: 388 / 450; object-fit: cover; display: block; }
        .img-fit-service { width: 100%; aspect-ratio: 4 / 3; object-fit: cover; display: block; }
        /* Hero banner should always be fully covered by the image */
        .banner .banner-single.dynamic-cover {
            min-height: 570px; /* matches design 1140x570 */
            background-size: cover !important;
            background-position: center center !important;
            background-repeat: no-repeat !important;
            border-radius: 12px;
            overflow: hidden;
            position: relative; /* needed for overlay */
        }
        /* Dark gradient overlay to keep text readable on any image */
        .banner .banner-single.dynamic-cover::before {
            content: "";
            position: absolute;
            inset: 0;
            z-index: 1;
            background: linear-gradient(90deg,
                        rgba(0,0,0,0.55) 0%,
                        rgba(0,0,0,0.40) 35%,
                        rgba(0,0,0,0.20) 60%,
                        rgba(0,0,0,0.05) 100%);
        }
        /* Ensure hero text stays above overlay and readable */
        .banner .banner-single.dynamic-cover .single-inner,
        .banner .banner-single.dynamic-cover .content-box { position: relative; z-index: 2; }
        .banner .banner-single.dynamic-cover .content-box .slider-subtitle,
        .banner .banner-single.dynamic-cover .content-box .slider-title,
        .banner .banner-single.dynamic-cover .content-box .slider-description,
        .banner .banner-single.dynamic-cover .content-box .slider-description p { color: #fff !important; text-shadow: 0 2px 8px rgba(0,0,0,0.4); }
        .banner .banner-single.dynamic-cover .content-box .slider-subtitle { display: inline-flex; align-items: center; gap: 8px; background: rgba(0,0,0,0.35); padding: 6px 12px; border-radius: 999px; }
        .banner .banner-single.dynamic-cover .slider-btn2 { background: #111; color: #fff !important; border-color: transparent; }
        .banner .banner-single.dynamic-cover .slider-btn2:hover { background: #000; color: #fff !important; }
        /* Brand logos: keep consistent height, do not stretch, center */
        .rts-brands-section1 .brand-front { display:flex; align-items:center; justify-content:center; height: 64px; }
        .rts-brands-section1 .brand-front img { max-height: 48px; width: auto; max-width: 100%; object-fit: contain; display: block; }
        /* Override theme filter that inverts brand logos making them invisible on light bg */
        .rts-brands-section1.brand-bg3 .brand-front img { filter: none !important; opacity: 1 !important; }
    /* Make promo image fill the full column height */
    .rts-deal-section1 .section-inner .row { align-items: stretch; }
    .col-promo-img { display: flex; }
    .promo-image-wrapper { width:100%; height:100%; min-height:420px; border-radius:12px; overflow:hidden; background:#eee; flex: 1 1 auto; }
    .promo-image-wrapper img { width:100%; height:100%; object-fit:cover; display:block; }
    /* Product card base */
    .product-item.element-item1 { position: relative; }
    </style>

    <!--================= Banner Section Start Here =================-->
    <div class="banner banner-1 bg-image">
        <div class="container">
            <div class="banner-inner">
                <div class="row">
                    <div class="col-xl-2 col-md-4 col-sm-12 gutter-1">
                        <div class="catagory-sidebar">
                            <div class="widget-bg">
                                <h2 class="widget-title">All Categories <i class="rt-angle-down"></i></h2>
                                <nav>
                                    <ul>
                                        @forelse(($categories ?? []) as $cat)
                                            <li>
                                                <a href="{{ route('category', ['slug' => $cat->slug]) }}">{{ $cat->name }} <i class="rt rt-arrow-right-long"></i></a>
                                            </li>
                                        @empty
                                            <li><a href="#">No categories <i class="rt rt-arrow-right-long"></i></a></li>
                                        @endforelse
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-10 col-md-8 col-sm-12 gutter-2">
                        <div class="swiper bannerSlide2">
                            <div class="swiper-wrapper">
                                @if(isset($banners) && $banners->count())
                                    @foreach($banners as $banner)
                                        <div class="swiper-slide">
                                            <div class="banner-single dynamic-cover" style="background-image:url('{{ $banner->image_url ?? asset('assets/images/featured/img-1.jpg') }}');">
                                                <div class="container">
                                                    <div class="single-inner">
                                                        <div class="content-box">
                                                            @if(!empty($banner->subtitle))
                                                                <p class="slider-subtitle"> {{ $banner->subtitle }}</p>
                                                            @endif
                                                            <h2 class="slider-title">{{ $banner->title ?? ' ' }}</h2>
                                                            @if(!empty($banner->description))
                                                                <div class="slider-description"><p>{{ $banner->description }}</p></div>
                                                            @endif
                                                            @if(!empty($banner->button_text) && !empty($banner->button_url))
                                                                <a href="{{ $banner->button_url }}" class="slider-btn2">{{ $banner->button_text }}</a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="swiper-slide">
                                        <div class="banner-single dynamic-cover" style="background-image:url('{{ asset('assets/images/featured/img-1.jpg') }}');">
                                            <div class="container">
                                                <div class="single-inner">
                                                    <div class="content-box">
                                                        <p class="slider-subtitle"><img src="{{ asset('assets/images/banner/wvbo-icon.png') }}" alt=""> Welcome</p>
                                                        <h2 class="slider-title">HOT COLLECTION<br>FOR WOMEN</h2>
                                                        <div class="slider-description"><p>Easy & safe payment with PayPal. Sequins & embroidered for all.</p></div>
                                                        <a href="{{ route('shop') }}" class="slider-btn2">View Collections</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="slider-navigation">
                                <div class="swiper-button-prev slider-btn prev"><i class="rt rt-arrow-left-long"></i></div>
                                <div class="swiper-button-next slider-btn next"><i class="rt rt-arrow-right-long"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--================= Banner Section End Here =================-->

<!-- ..::New Collection Section Start Here::.. -->
<div id="category" class="rts-new-collection-section section-gap">
    <div class="container">
        <div class="section-header section-header3 text-center">
            <div class="wrapper">
                <div class="sub-content">
                    <img class="line-1" src="{{ asset('assets/images/banner/wvbo-icon.png') }}" alt="">
                    <span class="sub-text">Featured</span>
                    <img class="line-2" src="{{ asset('assets/images/banner/wvbo-icon.png') }}" alt="">
                </div>
                <h2 class="title">Category</h2>
            </div>
        </div>
        <div class="row">
            @foreach($categories as $category)
                <div class="col-xl-3 col-md-4 col-sm-6 col-12">
                    <div class="collection-item">
                        @php
                            $count = isset($category->products_count) ? $category->products_count : (method_exists($category, 'products') ? $category->products()->count() : 0);
                        @endphp
                        <a href="{{ route('category', ['slug' => $category->slug]) }}"><img class="img-fit-square" src="{{ $category->image_url }}" alt="collection-image" loading="lazy" onerror="this.onerror=null;this.src='{{ asset('assets/images/featured/img-1.jpg') }}';"></a>
                        <p class="item-quantity">{{ $count }} <span>items</span></p>
                        <a href="{{ route('category', ['slug' => $category->slug]) }}" class="item-catagory-box">
                            <h3 class="title">{{ strtoupper($category->name) }}</h3>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
<!-- ..::New Collection Section End Here::.. -->

<!-- ..::Hand Picked Section Start Here::.. -->
<div id="produk-rekomendasi" class="rts-hand-picked-products-section">
    <div class="container">
        <div class="section-header section-header3 text-center">
            <div class="wrapper">
                <div class="sub-content">
                    <img class="line-1" src="{{ asset('assets/images/banner/wvbo-icon.png') }}" alt="">
                    <span class="sub-text">Featured</span>
                    <img class="line-2" src="{{ asset('assets/images/banner/wvbo-icon.png') }}" alt="">
                </div>
                <h2 class="title">Baju Pengantin</h2>
            </div>
        </div>
        <div class="row">
            @forelse(($weddingProducts ?? collect()) as $product)
                <div class="col-xl-3 col-md-4 col-sm-6 col-12">
                    <div class="product-item element-item1">
                        <a href="{{ route('productDetails', ['slug' => $product->slug]) }}" class="product-image image-hover-variations">
                            <div class="image-vari1 image-vari"><img class="img-fit-product" src="{{ $product->image_url }}" alt="product-image" loading="lazy" onerror="this.onerror=null;this.src='{{ asset('assets/images/products/product-details.jpg') }}';"></div>
                            <div class="image-vari2 image-vari"><img class="img-fit-product" src="{{ $product->image_url }}" alt="product-image" loading="lazy" onerror="this.onerror=null;this.src='{{ asset('assets/images/products/product-details.jpg') }}';"></div>
                        </a>
                        <div class="bottom-content">
                            <a href="{{ route('productDetails', ['slug' => $product->slug]) }}" class="product-name">{{ $product->name }}</a>
                            <div class="action-wrap">
                                <span class="price">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        
                    </div>
                </div>
            @empty
                <div class="col-12"><div class="text-center p-5 w-100">Belum ada produk baju pengantin.</div></div>
            @endforelse
        </div>
    </div>
</div>
<!-- ..::Hand Picked Section End Here::.. -->

<!-- ..::Deal Section Start Here::.. -->
<div id="promo" class="rts-deal-section1">
    <div class="container">
        <div class="section-inner">
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 col-promo-img text-white">
                    @php $promoImg = isset($promotion) ? $promotion->image_url : asset('assets/images/featured/img-1.jpg'); @endphp
                    <div class="promo-image-wrapper">
                        <img src="{{ $promoImg }}" alt="Gambar Promo" onerror="this.onerror=null;this.src='{{ asset('assets/images/featured/img-1.jpg') }}';">
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                    <div class="single-inner">
                        <div class="content-box">
                            <div class="sub-content">
                                <span class="sub-text">{{ $promotion->subtitle ?? 'Promo' }}</span>
                            </div>
                            <h2 class="slider-title text-white">{{ $promotion->title ?? 'Promo Spesial' }}</h2>
                            <div class="slider-description text-black">
                                <p>{{ $promotion->description ?? 'Penawaran terbatas untuk periode ini.' }}</p>
                            </div>
                            <div class="countdown" id="promo-countdown" @if(isset($promotion) && $promotion?->deadline_at) data-deadline="{{ $promotion->deadline_at->toIso8601String() }}" @endif>
                                <ul>
                                    <li><span id="promo-days"></span>D</li>
                                    <li><span id="promo-hours"></span>H</li>
                                    <li><span id="promo-minutes"></span>M</li>
                                    <li><span id="promo-seconds"></span>S</li>
                                </ul>
                            </div>
                            <div class="content-bottom">
                                <div class="img-box">
                                    @php $smallIcon = isset($promotion) ? $promotion->small_icon_url : asset('assets/images/hand-picked/deal-icon.png'); @endphp
                                    <img src="{{ $smallIcon }}" alt="Ikon Promo" style="width:48px;height:48px;object-fit:cover;border-radius:50%;" onerror="this.onerror=null;this.src='{{ asset('assets/images/hand-picked/deal-icon.png') }}';">
                                </div>
                                <p class="content text-white">Penawaran terbatas. Promo berakhir<br>
                                    @if(isset($promotion) && $promotion?->deadline_at)
                                        pada {{ $promotion->deadline_at->format('d F Y H:i') }}
                                    @endif
                                </p>
                                @if(isset($promotion) && $promotion?->button_text && $promotion?->button_url)
                                    <div class="mt-3"><a href="{{ $promotion->button_url }}" class="slider-btn2">{{ $promotion->button_text }}</a></div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ..::Deal Section End Here::.. -->

<!-- ..::Accessories Section (Products) Start Here::.. -->
<div id="aksesoris" class="rts-featured-product-section1">
    <div class="container">
        <div class="rts-featured-product-section-inner">
            <div class="section-header section-header3 text-center">
                <div class="wrapper">
                    <div class="sub-content">
                        <img class="line-1" src="{{ asset('assets/images/banner/wvbo-icon.png') }}" alt="">
                        <span class="sub-text">Featured</span>
                        <img class="line-2" src="{{ asset('assets/images/banner/wvbo-icon.png') }}" alt="">
                    </div>
                    <h2 class="title">Aksesoris</h2>
                </div>
            </div>
            <div class="row">
                @forelse(($accessoryProducts ?? collect()) as $product)
                    <div class="col-xl-3 col-md-4 col-sm-6 col-12">
                        <div class="product-item element-item1">
                            <a href="{{ route('productDetails', ['slug' => $product->slug]) }}" class="product-image image-hover-variations">
                                <div class="image-vari1 image-vari"><img class="img-fit-product" src="{{ $product->image_url }}" alt="product-image" loading="lazy" onerror="this.onerror=null;this.src='{{ asset('assets/images/products/product-details.jpg') }}';"></div>
                                <div class="image-vari2 image-vari"><img class="img-fit-product" src="{{ $product->image_url }}" alt="product-image" loading="lazy" onerror="this.onerror=null;this.src='{{ asset('assets/images/products/product-details.jpg') }}';"></div>
                            </a>
                            <div class="bottom-content">
                                <a href="{{ route('productDetails', ['slug' => $product->slug]) }}" class="product-name">{{ $product->name }}</a>
                                <div class="action-wrap">
                                    <span class="price">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                                </div>
                            </div>
                                
                        </div>
                    </div>
                @empty
                    <div class="col-12"><div class="text-center p-5 w-100">Belum ada produk aksesoris.</div></div>
                @endforelse
            </div>
        </div>
    </div>
</div>
<!-- ..::Accessories Section End Here::.. -->

<!-- ..::Featured Product Section Start Here::.. -->
<div class="rts-featured-product-section3">
    <div class="container">
        <div class="rts-featured-product-section-inner">
            <div class="section-header section-header3 text-center">
                <div class="wrapper">
                    <div class="sub-content">
                        <img class="line-1" src="{{ asset('assets/images/banner/wvbo-icon.png') }}" alt="">
                        <span class="sub-text">Featured</span>
                        <img class="line-2" src="{{ asset('assets/images/banner/wvbo-icon.png') }}" alt="">
                    </div>
                    <h2 class="title">Salon atau Service</h2>
                </div>
            </div>
            <div class="row">
                @forelse($featuredServices->take(3) as $service)
                    <div class="col-xl-4 col-md-6 col-sm-12">
                        <div class="full-wrapper wrapper-1">
                            <div class="image-part">
                                <a href="#" class="image"><img src="{{ $service->image_url }}" alt="{{ $service->name }}" loading="lazy" onerror="this.onerror=null;this.src='{{ asset('assets/images/featured/img-3.jpg') }}';"></a>
                            </div>
                            <div class="blog-content">
                                <ul class="blog-meta">
                                    <li><a href="#">{{ strtoupper($service->type) }}</a></li>
                                </ul>
                                <div class="title">
                                    <a href="#">{{ $service->name }}</a>
                                </div>
                                @if(!is_null($service->price))
                                    <div class="author-info d-flex align-items-center">
                                        <div class="info">
                                            <p class="author-name">Harga</p>
                                            <p class="author-dsg">Rp{{ number_format($service->price, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12"><p class="text-center">Belum ada layanan unggulan.</p></div>
                @endforelse
            </div>
        </div>
    </div>
</div>
<!-- ..::Featured Product Section End Here::.. -->

<!-- ..::Brand Section Start Here::.. -->
<div class="rts-brands-section1 brand-bg3">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-12">
                <div class="slider-div">
                    <div class="swiper rts-brandSlide1">
                            <div class="swiper-wrapper">
                                @forelse(($brands ?? []) as $brand)
                                    <div class="swiper-slide">
                                        <a class="brand-front" href="#"><img src="{{ $brand->image_url }}" alt="{{ $brand->name }}" loading="lazy" style="filter:none !important;opacity:1 !important;" onerror="this.onerror=null;this.src='{{ asset('assets/images/brands/client-01.png') }}';"></a>
                                    </div>
                                @empty
                                    <div class="swiper-slide">
                                        <a class="brand-front" href="#"><img src="{{ asset('assets/images/brands/client-01.png') }}" alt="Brand Logo"></a>
                                    </div>
                                    <div class="swiper-slide">
                                        <a class="brand-front" href="#"><img src="{{ asset('assets/images/brands/client-02.png') }}" alt="Brand Logo"></a>
                                    </div>
                                    <div class="swiper-slide">
                                        <a class="brand-front" href="#"><img src="{{ asset('assets/images/brands/client-03.png') }}" alt="Brand Logo"></a>
                                    </div>
                                    <div class="swiper-slide">
                                        <a class="brand-front" href="#"><img src="{{ asset('assets/images/brands/client-04.png') }}" alt="Brand Logo"></a>
                                    </div>
                                    <div class="swiper-slide">
                                        <a class="brand-front" href="#"><img src="{{ asset('assets/images/brands/client-05.png') }}" alt="Brand Logo"></a>
                                    </div>
                                    <div class="swiper-slide">
                                        <a class="brand-front" href="#"><img src="{{ asset('assets/images/brands/client-06.png') }}" alt="Brand Logo"></a>
                                    </div>
                                @endforelse
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ..::Brand Section End Here::.. -->

<!-- ..::Product-details Section Start Here::.. -->
<div class="product-details-popup-wrapper">
    <div class="rts-product-details-section rts-product-details-section2 product-details-popup-section">
        <div class="product-details-popup">
            <button class="product-details-close-btn"><i class="fal fa-times"></i></button>
            <div class="details-product-area">
                <div class="product-thumb-area">
                    <div class="cursor"></div>
                    <div class="thumb-wrapper one filterd-items figure">
                        <div class="product-thumb zoom" onmousemove="zoom(event)" style="background-image: url('{{ asset('assets/images/products/product-details.jpg') }}')"><img src="{{ asset('assets/images/products/product-details.jpg') }}" alt="product-thumb">
                        </div>
                    </div>
                    <div class="thumb-wrapper two filterd-items hide">
                        <div class="product-thumb zoom" onmousemove="zoom(event)" style="background-image: url('{{ asset('assets/images/products/product-filt2.jpg') }}')"><img src="{{ asset('assets/images/products/product-filt2.jpg') }}" alt="product-thumb">
                        </div>
                    </div>
                    <div class="thumb-wrapper three filterd-items hide">
                        <div class="product-thumb zoom" onmousemove="zoom(event)" style="background-image: url('{{ asset('assets/images/products/product-filt3.jpg') }}')"><img src="{{ asset('assets/images/products/product-filt3.jpg') }}" alt="product-thumb">
                        </div>
                    </div>
                    <div class="product-thumb-filter-group">
                        <div class="thumb-filter filter-btn active" data-show=".one"><img src="{{ asset('assets/images/products/product-filt1.jpg') }}" alt="product-thumb-filter"></div>
                        <div class="thumb-filter filter-btn" data-show=".two"><img src="{{ asset('assets/images/products/product-filt2.jpg') }}" alt="product-thumb-filter"></div>
                        <div class="thumb-filter filter-btn" data-show=".three"><img src="{{ asset('assets/images/products/product-filt3.jpg') }}" alt="product-thumb-filter"></div>
                    </div>
                </div>
                <div class="contents">
                    <div class="product-status">
                        <span class="product-catagory">Dress</span>
                        <div class="rating-stars-group">
                            <div class="rating-star"><i class="fas fa-star"></i></div>
                            <div class="rating-star"><i class="fas fa-star"></i></div>
                            <div class="rating-star"><i class="fas fa-star-half-alt"></i></div>
                            <span>10 Reviews</span>
                        </div>
                    </div>
                    <h2 class="product-title">Wide Cotton Tunic Dress <span class="stock">In Stock</span></h2>
                    <span class="product-price"><span class="old-price">$9.35</span> $7.25</span>
                    <p>
                        Priyoshop has brought to you the Hijab 3 Pieces Combo Pack PS23. It is a
                        completely modern design and you feel comfortable to put on this hijab.
                        Buy it at the best price.
                    </p>
                    <div class="product-bottom-action">
                        <div class="cart-edit">
                            <div class="quantity-edit action-item">
                                <button class="button"><i class="fal fa-minus minus"></i></button>
                                <input type="text" class="input" value="01" />
                                <button class="button plus">+<i class="fal fa-plus plus"></i></button>
                            </div>
                        </div>
                        <a href="{{ route('cart') }}" class="addto-cart-btn action-item"><i class="rt-basket-shopping"></i>
                            Add To
                            Cart</a>
                        <a href="{{ route('wishlist') }}" class="wishlist-btn action-item"><i class="rt-heart"></i></a>
                    </div>
                    <div class="product-uniques">
                        <span class="sku product-unipue"><span>SKU: </span> BO1D0MX8SJ</span>
                        <span class="catagorys product-unipue"><span>Categories: </span> T-Shirts, Tops, Mens</span>
                        <span class="tags product-unipue"><span>Tags: </span> fashion, t-shirts, Men</span>
                    </div>
                    <div class="share-social">
                        <span>Share:</span>
                        <a class="platform" href="http://facebook.com" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        <a class="platform" href="http://twitter.com" target="_blank"><i class="fab fa-twitter"></i></a>
                        <a class="platform" href="http://behance.com" target="_blank"><i class="fab fa-behance"></i></a>
                        <a class="platform" href="http://youtube.com" target="_blank"><i class="fab fa-youtube"></i></a>
                        <a class="platform" href="http://linkedin.com" target="_blank"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ..::Product-details Section End Here::.. -->

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var el = document.getElementById('promo-countdown');
        if(!el) return;
        var attr = el.getAttribute('data-deadline');
        if(!attr) return;
        var deadline = Date.parse(attr);
        if(isNaN(deadline)) return;

        var daysEl = document.getElementById('promo-days');
        var hoursEl = document.getElementById('promo-hours');
        var minutesEl = document.getElementById('promo-minutes');
        var secondsEl = document.getElementById('promo-seconds');

        function update(){
            var now = (new Date()).getTime();
            var diff = Math.max(0, deadline - now);
            var days = Math.floor(diff / 86400000);
            diff -= days * 86400000;
            var hours = Math.floor(diff / 3600000);
            diff -= hours * 3600000;
            var minutes = Math.floor(diff / 60000);
            diff -= minutes * 60000;
            var seconds = Math.floor(diff / 1000);
            if(daysEl) daysEl.textContent = String(days).padStart(2,'0');
            if(hoursEl) hoursEl.textContent = String(hours).padStart(2,'0');
            if(minutesEl) minutesEl.textContent = String(minutes).padStart(2,'0');
            if(secondsEl) secondsEl.textContent = String(seconds).padStart(2,'0');
            if(deadline - now <= 0){
                clearInterval(timer);
            }
        }
        update();
        var timer = setInterval(update, 1000);
    });
</script>
@endpush