@extends('layout.layout')

@php
    $css='<link rel="stylesheet" href="' . asset('assets/css/jquery.nstSlider.min.css') . '"/>
        <link rel="stylesheet" href="' . asset('assets/css/variables/variable6.css') . '"/>';     
    $title = isset($category) ? $category->name : 'Category';
    $subTitle = 'Home';
    $subTitle2 = isset($category) ? $category->name : 'Category';
    $script = '<script src="' . asset('assets/js/vendors/jquery.nstSlider.min.js') . '"></script>
           <script src="' . asset('assets/js/vendors/zoom.js') . '"></script>'; 
@endphp

@section('content')

    <!-- ..::Shop Section Start Here::.. -->
    <div class="rts-shop-section section-gap">
        <div class="container">
            <div class="row">
                <div class="col-xl-9 col-lg-8">
                    @isset($category)
                        <div class="mb-3">
                            <h2 class="section-title mb-0">Category: {{ $category->name }}</h2>
                        </div>
                    @endisset
                    <div class="shop-product-topbar d-flex align-items-center justify-content-between flex-wrap gap-2">
                        @isset($products)
                            <span class="items-onlist">Showing {{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }} of {{ $products->total() ?? 0 }} results</span>
                        @else
                            <span class="items-onlist">Showing 0 results</span>
                        @endisset
                        <div class="filter-area">
                            <form method="GET" id="sortForm">
                                <input type="hidden" name="slug" value="{{ $category->slug ?? '' }}" />
                                @if(request('with'))
                                    <input type="hidden" name="with" value="{{ request('with') }}" />
                                @endif
                                <p class="select-area mb-0">
                                    <select class="select" name="sort" onchange="this.form.submit()">
                                        @php($currentSort = request('sort', $sort ?? 'latest'))
                                        <option value="latest" {{ $currentSort==='latest' ? 'selected' : '' }}>Sort by latest</option>
                                        <option value="price_asc" {{ $currentSort==='price_asc' ? 'selected' : '' }}>Sort by price: low to high</option>
                                        <option value="price_desc" {{ $currentSort==='price_desc' ? 'selected' : '' }}>Sort by price: high to low</option>
                                        <option value="name_asc" {{ $currentSort==='name_asc' ? 'selected' : '' }}>Sort by name: A-Z</option>
                                        <option value="name_desc" {{ $currentSort==='name_desc' ? 'selected' : '' }}>Sort by name: Z-A</option>
                                    </select>
                                </p>
                            </form>
                        </div>
                    </div>
                    <div class="products-area products-area3">
                        <div class="row g-3 g-md-4">
                            @isset($products)
                                @forelse($products as $product)
                                    <div class="col-6 col-md-4 col-lg-3">
                                        <div class="product-item product-item2 element-item1">
                                            <a href="{{ route('productDetails', ['slug' => $product->slug]) }}" class="product-image">
                                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" onerror="this.onerror=null;this.src='{{ asset('assets/images/products/product-details.jpg') }}';">
                                            </a>
                                            <div class="bottom-content">
                                                <span class="product-category">{{ $category->name ?? 'Produk' }}</span>
                                                <div>
                                                    <a href="{{ route('productDetails', ['slug' => $product->slug]) }}" class="product-name">{{ $product->name }}</a>
                                                </div>
                                                <div class="action-wrap">
                                                    <span class="product-price">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                                                    @auth
                                                    <form action="{{ route('cart.add', ['slug' => $product->slug]) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        <input type="hidden" name="quantity" value="1" />
                                                        <button type="submit" class="addto-cart" style="background: none; border: none; cursor: pointer; padding: 0;">
                                                            <i class="fal fa-shopping-cart"></i> Add To Cart
                                                        </button>
                                                    </form>
                                                    @else
                                                    <a href="{{ route('login') }}" class="addto-cart" title="Login untuk menambahkan ke keranjang">
                                                        <i class="fas fa-sign-in-alt"></i> Login
                                                    </a>
                                                    @endauth
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12"><div class="text-center p-5">Belum ada produk pada kategori ini.</div></div>
                                @endforelse
                            @endisset
                        </div>
                    </div>
                    @isset($products)
                        <div class="product-pagination-area mt--20">
                            {!! $products->withQueryString()->links() !!}
                        </div>
                    @endisset
                </div>
                <div class="col-xl-3 col-lg-4">
                    <div class="side-sticky">
                        <div class="shop-side-action">
                            <div class="action-item">
                                <div class="action-top">
                                    <span class="action-title">category</span>
                                </div>
                                <ul class="sub-categorys">
                                    <div class="sub-categorys-inner">
                                        @isset($category)
                                            <li>
                                                <span class="point"></span>
                                                <a href="{{ route('category', ['slug' => $category->slug, 'sort' => request('sort')]) }}" class="{{ request('with') ? '' : 'active' }}">Semua</a>
                                            </li>
                                            @isset($otherCategories)
                                                @foreach($otherCategories as $oc)
                                                    <li>
                                                        <span class="point"></span>
                                                        <a href="{{ route('category', ['slug' => $category->slug, 'with' => $oc->slug, 'sort' => request('sort')]) }}" class="{{ (isset($withCategory) && $withCategory && $withCategory->id === $oc->id) ? 'active' : '' }}">{{ $oc->name }} ({{ $oc->products_count }})</a>
                                                    </li>
                                                @endforeach
                                            @endisset
                                        @endisset
                                    </div>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ..::Shop Section Section End Here::.. -->
     
@endsection