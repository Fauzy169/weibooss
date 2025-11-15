@extends('layout.layout')

@php
    $title='Thank You';
    $subTitle = 'Home';
    $subTitle2 = 'Thank You';
    $script = '<script src="' . asset('assets/js/vendors/zoom.js') . '"></script>';
@endphp

@push('styles')
<style>
    /* Override background color for thank you page only */
    .thanks-area {
        background-color: #f8f9fa !important;
        background-image: none !important;
    }
    .thanks-area .section-inner {
        background-color: #ffffff;
        padding: 60px 40px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }
    .thanks-area .section-icon {
        background-color: #f0f9ff;
        border-color: #99cc33 !important;
    }
    @media (max-width: 576px) {
        .thanks-area .section-inner {
            padding: 40px 20px;
        }
    }
</style>
@endpush

@section('content')

    <!--thanks-area start-->
    <div class="thanks-area">
        <div class="container">
            <div class="section-inner">
                <div class="section-icon">
                    <i class="fal fa-check"></i>
                </div>
                <div class="section-title">
                    <h2 class="sub-title">Thanks For your Order</h2>
                    <h3 class="sect-title">Sorry, we couldn't find the page you where looking for. We suggest that <br> you return to homepage.</h3>
                </div>
                <div class="section-button">
                    <a class="btn-1" href="{{ route('home') }}"><i class="fal fa-long-arrow-left"></i> Go To Homepage</a>
                    <h3>
                        Let's track your order or
                        <a class="btn-2" href="contact.php"> Contact Us</a>
                    </h3>
                </div>
            </div>
        </div>
    </div>
    <!--thanks-area end-->

@endsection