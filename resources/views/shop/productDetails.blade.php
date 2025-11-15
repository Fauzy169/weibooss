@extends('layout.layout')

@php
    $title='Product';
    $subTitle = 'Shop';
    $subTitle2 = 'Product';
    $script= '<script src="' . asset('assets/js/vendors/zoom.js') . '"></script>';
    
    
@endphp

@section('content')

    <style>
        /* Uniform sizes for product detail gallery */
        .rts-product-details-section .product-thumb-area { max-width: 560px; width: 100%; }
        .rts-product-details-section .product-thumb { 
            width: 100%;
            aspect-ratio: 4 / 5; /* keep same look as product cards */
            overflow: hidden;
            border-radius: 10px;
            background-size: cover !important;
            background-position: center center !important;
            display: block;
        }
        .rts-product-details-section .product-thumb img {
            width: 100%; height: 100%; object-fit: cover; display: block;
        }
        .rts-product-details-section .product-thumb-filter-group { display: flex; gap: 10px; margin-top: 12px; flex-wrap: wrap; }
        .rts-product-details-section .product-thumb-filter-group .thumb-filter img {
            width: 90px; aspect-ratio: 1 / 1; object-fit: cover; border-radius: 8px; display: block;
        }
        @media (max-width: 768px) {
            .rts-product-details-section .product-thumb-area { max-width: 100%; }
            .rts-product-details-section .product-thumb-filter-group .thumb-filter img { width: 64px; }
        }

        /* Category badges */
        .cat-badges { display:flex; flex-wrap: wrap; gap: 8px; }
        .cat-badge { display:inline-flex; align-items:center; padding: 4px 10px; font-size: 12px; border-radius: 999px; background:#f3f4f6; color:#111; text-decoration:none; border:1px solid #e5e7eb; }
        .cat-badge.primary { background:#d51243; color:#fff; border-color:#d51243; }
        .cat-label { font-weight:600; margin-right:8px; font-size:12px; text-transform:uppercase; color:#6b7280; }
    </style>

    <!-- ..::Product-details Section Start Here::.. -->
    <div class="rts-product-details-section section-gap">
        <div class="container">
            <div class="details-product-area mb--70">
                <div class="product-thumb-area">
                    <div class="cursor"></div>
                    @php $gallery = $product->gallery_urls; @endphp
                    @if(count($gallery))
                        @foreach($gallery as $i => $img)
                            @php $class = $i===0 ? 'one' : 'wr-'.$i; @endphp
                            <div class="thumb-wrapper {{ $class }} filterd-items figure {{ $i>0 ? 'hide' : '' }}">
                                <div class="product-thumb zoom" onmousemove="zoom(event)" style="background-image: url('{{ $img }}')">
                                    <img src="{{ $img }}" alt="{{ $product->name }} image {{ $i+1 }}">
                                </div>
                            </div>
                        @endforeach
                        <div class="product-thumb-filter-group">
                            @foreach($gallery as $i => $img)
                                @php $class = $i===0 ? 'one' : 'wr-'.$i; @endphp
                                <div class="thumb-filter filter-btn {{ $i===0 ? 'active' : '' }}" data-show=".{{ $class }}">
                                    <img src="{{ $img }}" alt="thumb {{ $i+1 }}">
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="thumb-wrapper one filterd-items figure">
                            <div class="product-thumb zoom" onmousemove="zoom(event)" style="background-image: url('{{ $product->image_url }}')">
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                            </div>
                        </div>
                    @endif
                </div>
                <div class="contents">
                    <div class="product-status" style="margin-bottom:10px;">
                        @if(isset($primaryCategory) && $primaryCategory)
                            <div class="cat-badges" style="margin-bottom:6px;">
                                <a class="cat-badge primary" href="{{ route('category', ['slug' => $primaryCategory->slug]) }}">{{ $primaryCategory->name }}</a>
                            </div>
                        @endif
                    </div>
                    <h2 class="product-title">{{ $product->name }}</h2>
                    <span class="product-price">Rp{{ number_format($product->price,0,',','.') }}</span>
                    
                    <div class="product-uniques">
                        
                        <span class="catagorys product-unipue"><span>Categories: </span> {{ $product->categories->pluck('name')->join(', ') }}</span>
                    <span class="catagorys product-unipue"><span>Deskripsi: </span></span>
                    <p>{{ $product->description }}</p>
                    <div class="product-bottom-action">
                        <form action="{{ route('cart.add', ['slug' => $product->slug]) }}" method="POST" class="d-flex align-items-center gap-2">
                            @csrf
                            <div class="cart-edit">
                                <div class="quantity-edit action-item">
                                    <button type="button" class="button" onclick="this.nextElementSibling.stepDown()"><i class="fal fa-minus minus"></i></button>
                                    <input name="quantity" type="number" min="1" value="1" class="input" />
                                    <button type="button" class="button plus" onclick="this.previousElementSibling.stepUp()">+<i class="fal fa-plus plus"></i></button>
                                </div>
                            </div>
                            <button type="submit" class="addto-cart-btn action-item"><i class="rt-basket-shopping"></i> Add To Cart</button>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ..::Related Product Section End Here::.. -->

    <div class="rts-account-section"></div>

@endsection