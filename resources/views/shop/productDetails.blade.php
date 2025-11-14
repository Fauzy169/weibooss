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
                    <p>{{ $product->description }}</p>
                    <div class="product-bottom-action">
                        <div class="cart-edit">
                            <div class="quantity-edit action-item">
                                <button class="button"><i class="fal fa-minus minus"></i></button>
                                <input type="text" class="input" value="01" />
                                <button class="button plus">+<i class="fal fa-plus plus"></i></button>
                            </div>
                        </div>
                        <a href="{{ route('cart') }}" class="addto-cart-btn action-item"><i class="rt-basket-shopping"></i> Add To
                            Cart</a>
                        <a href="{{ route('wishlist') }}" class="wishlist-btn action-item"><i class="rt-heart"></i></a>
                    </div>
                    <div class="product-uniques">
                        <span class="catagorys product-unipue"><span>Categories: </span> {{ $product->categories->pluck('name')->join(', ') }}</span>
                    </div>
                </div>
            </div>
            <div class="product-full-details-area">
                <div class="details-filter-bar2">
                    <button class="details-filter filter-btn active" data-show=".dls-one">Description</button>
                </div>
                <div class="full-details dls-one filterd-items">
                    <div class="full-details-inner">
                        <p class="mb--30">{{ $product->description }}</p>
                    </div>
                </div>
                <div class="full-details dls-two filterd-items hide">
                    <div class="full-details-inner">
                        <p class="mb--30">In marketing a product is an object or system made available for consumer use
                            it is anything that can be offered to a market to satisfy the desire or need of a customer.
                            In retailing, products are
                            merchandise, and in manufacturing, products are bought as raw materials and then sold as
                            finished goods. A service is also regarded to as a type of product. Commodities are usually
                            raw material
                            and agricultural products, but a commodity can also be anything widely available in the open
                            market. In project management, products are the formal definition of the project
                            deliverables that
                            to delivering the objectives of the project.</p>
                        <p>A product can be classified as tangible or intangible. A tangible product is a physical
                            object that can be perceived by touch such as a building, vehicle, gadget, or clothing. An
                            intangible product is
                            can only be perceived indirectly such as an insurance policy. Services can be broadly
                            classified under intangible products which can be durable or non durable. A product line is
                            "a group of
                            closely related, either because they function in a similar manner.</p>
                    </div>
                </div>
                <div class="full-details dls-three filterd-items hide">
                    <div class="full-details-inner">
                        <p>Belum ada ulasan.</p>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 mr-10">
                                <div class="reveiw-form">
                                    <h2 class="section-title">
                                        Jadilah yang pertama mereview <strong>"{{ $product->name }}"</strong></h2>
                                        <h4 class="sect-title">Your email address will not be published. Required fields are marked* </h4>
                                        <div class="reveiw-form-main mb-10">
                                            <div class="contact-form">
                                                <div class="row">
                                                    <div class="col-lg-6 col-sm-12">
                                                        <div class="input-box text-input mb-20">
                                                            <textarea name="Message" id="validationDefault01"  cols="30" rows="10"
                                                                placeholder="Your Review*" required></textarea>
                                                        <div class="row">
                                                            @foreach($relatedProducts as $rel)
                                                                <div class="col-xl-3 col-md-4 col-sm-6 col-12">
                                                                    <div class="product-item element-item1">
                                                                        <a href="{{ route('productDetails', ['slug' => $rel->slug]) }}" class="product-image image-hover-variations">
                                                                            <div class="image-vari1 image-vari"><img src="{{ $rel->image_url }}" alt="{{ $rel->name }}"></div>
                                                                        </a>
                                                                        <div class="bottom-content">
                                                                            <div class="star-rating">
                                                                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                                                            </div>
                                                                            <a href="{{ route('productDetails', ['slug' => $rel->slug]) }}" class="product-name">{{ $rel->name }}</a>
                                                                            <div class="action-wrap">
                                                                                <span class="price">Rp{{ number_format($rel->price,0,',','.') }}</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                            @if($relatedProducts->isEmpty())
                                                                <div class="col-12"><div class="text-center py-4">Tidak ada produk terkait.</div></div>
                                                            @endif
                                                        </div>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                                <a href="{{ route('productDetails', ['slug' => $product->slug]) }}" class="product-name">Maidenform Bra</a>
                                <div class="action-wrap">
                                    <span class="price">$31.00</span>
                                </div>
                            </div>
                            <div class="quick-action-button">
                                <div class="cta-single cta-plus">
                                    <a href="#"><i class="rt-plus"></i></a>
                                </div>
                                <div class="cta-single cta-quickview">
                                    <a href="#"><i class="far fa-eye"></i></a>
                                </div>
                                <div class="cta-single cta-wishlist">
                                    <a href="#"><i class="far fa-heart"></i></a>
                                </div>
                                <div class="cta-single cta-addtocart">
                                    <a href="#"><i class="rt-basket-shopping"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-4 col-sm-6 col-12">
                        <div class="product-item element-item1">
                            <a href="{{ route('productDetails', ['slug' => $product->slug]) }}" class="product-image image-hover-variations">
                                <div class="image-vari1 image-vari"><img
                                        src="{{ asset('assets/images/hand-picked/slider-img12.webp') }}" alt="product-image">
                                </div>
                                <div class="image-vari2 image-vari"><img
                                        src="{{ asset('assets/images/hand-picked/slider-img12-3.webp') }}" alt="product-image">
                                </div>
                            </a>
                            <div class="bottom-content">
                                <div class="star-rating">
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                                <a href="{{ route('productDetails', ['slug' => $product->slug]) }}" class="product-name">Hanes Women's Bra</a>
                                <div class="action-wrap">
                                    <span class="price">$31.00</span>
                                </div>
                            </div>
                            <div class="quick-action-button">
                                <div class="cta-single cta-plus">
                                    <a href="#"><i class="rt-plus"></i></a>
                                </div>
                                <div class="cta-single cta-quickview">
                                    <a href="#"><i class="far fa-eye"></i></a>
                                </div>
                                <div class="cta-single cta-wishlist">
                                    <a href="#"><i class="far fa-heart"></i></a>
                                </div>
                                <div class="cta-single cta-addtocart">
                                    <a href="#"><i class="rt-basket-shopping"></i></a>
                                </div>
                            </div>
                            <div class="product-features">
                                <div class="discount-tag product-tag">-38%</div>
                                <div class="new-tag product-tag">HOT</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ..::Related Product Section End Here::.. -->

    <div class="rts-account-section"></div>

@endsection