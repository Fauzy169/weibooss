@extends('layout.layout')

@php
    $title='Service';
    $subTitle = 'Shop';
    $subTitle2 = 'Service';
@endphp

@section('content')

    <style>
        /* Uniform sizes for service detail */
        .rts-service-details-section .service-thumb-area { max-width: 560px; width: 100%; }
        .rts-service-details-section .service-thumb { 
            width: 100%;
            aspect-ratio: 4 / 3;
            overflow: hidden;
            border-radius: 10px;
            display: block;
        }
        .rts-service-details-section .service-thumb img {
            width: 100%; height: 100%; object-fit: cover; display: block;
        }
        @media (max-width: 768px) {
            .rts-service-details-section .service-thumb-area { max-width: 100%; }
        }

        /* Service type badge */
        .service-type-badge { 
            display:inline-flex; 
            align-items:center; 
            padding: 6px 14px; 
            font-size: 13px; 
            border-radius: 999px; 
            background:#d51243; 
            color:#fff; 
            text-decoration:none; 
            border:1px solid #d51243;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
    </style>

    <!-- ..::Service-details Section Start Here::.. -->
    <div class="rts-service-details-section section-gap">
        <div class="container">
            <div class="details-product-area mb--70">
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="service-thumb-area">
                            <div class="service-thumb">
                                <img src="{{ $service->image_url }}" alt="{{ $service->name }}" onerror="this.onerror=null;this.src='{{ asset('assets/images/featured/img-2.jpg') }}';">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="contents">
                            <div class="product-status" style="margin-bottom:15px;">
                                <span class="service-type-badge">{{ strtoupper($service->type) }}</span>
                            </div>
                            <h2 class="product-title">{{ $service->name }}</h2>
                            
                            @if(!is_null($service->price))
                                <div class="price-section mb-3">
                                    <span class="product-price" style="font-size: 28px; font-weight: 600; color: #d51243;">
                                        Rp{{ number_format($service->price, 0, ',', '.') }}
                                    </span>
                                </div>
                            @endif

                            @if($service->description)
                                <div class="service-description mb-4">
                                    <h4 style="font-size: 18px; margin-bottom: 10px; font-weight: 600;">Deskripsi</h4>
                                    <p style="line-height: 1.7; color: #555;">{{ $service->description }}</p>
                                </div>
                            @endif

                            <div class="service-info mt-4">
                                <div class="info-item mb-3">
                                    <strong style="display: inline-block; width: 120px;">Tipe Layanan:</strong>
                                    <span>{{ ucfirst($service->type) }}</span>
                                </div>
                                <div class="info-item mb-3">
                                    <strong style="display: inline-block; width: 120px;">Status:</strong>
                                    <span class="badge {{ $service->active ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $service->active ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                </div>
                                @if($service->is_featured)
                                    <div class="info-item mb-3">
                                        <strong style="display: inline-block; width: 120px;">Featured:</strong>
                                        <span class="badge bg-warning text-dark">Layanan Unggulan</span>
                                    </div>
                                @endif
                            </div>

                            <div class="product-bottom-action mt-4">
                                @auth
                                <form action="{{ route('cart.service.add', ['slug' => $service->slug]) }}" method="POST" class="d-flex align-items-center gap-3 flex-wrap">
                                    @csrf
                                    <input name="quantity" type="hidden" value="1" />
                                    <button type="submit" class="slider-btn2" style="background: #d51243; color: #fff; padding: 14px 32px; border-radius: 6px; border: none; display: inline-flex; align-items: center; gap: 10px; font-weight: 600; transition: all 0.3s; cursor: pointer; font-size: 15px;">
                                        <i class="rt-basket-shopping"></i>
                                        Tambahkan ke Keranjang
                                    </button>
                                    <a href="{{ route('home') }}" class="slider-btn2" style="background: #333; color: #fff; padding: 14px 32px; border-radius: 6px; text-decoration: none; display: inline-flex; align-items: center; gap: 10px; font-weight: 600; transition: all 0.3s; font-size: 15px;">
                                        <i class="fa-regular fa-arrow-left"></i>
                                        Kembali ke Home
                                    </a>
                                </form>
                                @else
                                <div class="d-flex align-items-center gap-3 flex-wrap">
                                    <div class="alert alert-info mb-0" style="flex: 1; font-size: 14px;">
                                        <i class="fas fa-info-circle"></i> Silakan login terlebih dahulu untuk menambahkan layanan ke keranjang
                                    </div>
                                    <a href="{{ route('login') }}" class="slider-btn2" style="background: #d51243; color: #fff; padding: 14px 32px; border-radius: 6px; text-decoration: none; display: inline-flex; align-items: center; gap: 10px; font-weight: 600; transition: all 0.3s; font-size: 15px;">
                                        <i class="fas fa-sign-in-alt"></i>
                                        Login untuk Pesan
                                    </a>
                                    <a href="{{ route('home') }}" class="slider-btn2" style="background: #333; color: #fff; padding: 14px 32px; border-radius: 6px; text-decoration: none; display: inline-flex; align-items: center; gap: 10px; font-weight: 600; transition: all 0.3s; font-size: 15px;">
                                        <i class="fa-regular fa-arrow-left"></i>
                                        Kembali ke Home
                                    </a>
                                </div>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
