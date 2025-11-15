@extends('layout.layout')

@php
    $css = '<link rel="stylesheet" href="' . asset('assets/css/variables/variable6.css') . '"/>';
    $title='Cart';
    $subTitle = 'Shop';
    $subTitle2 = 'Cart';
    $script = '<script src="' . asset('assets/js/vendors/zoom.js') . '"></script>';
@endphp

@section('content')

    <!-- ..::Cart Section Start Here::.. -->
    <div class="rts-cart-section">
        <div class="container">
            <h4 class="section-title">Product List</h4>
            <div class="row justify-content-between">
                <div class="col-xl-7">
                    <div class="cart-table-area">
                        @if(empty($items))
                            <div class="py-5 text-center">Keranjang kosong. <a href="{{ route('shop') }}">Belanja sekarang</a>.</div>
                        @else
                        <form action="{{ route('cart.update') }}" method="POST">
                            @csrf
                            <table class="table table-bordered table-hover">
                                <thead class="thead-dark">
                                </thead>
                                <tbody>
                                @foreach($items as $key => $item)
                                    <tr>
                                        <td><div class="product-thumb"><img src="{{ $item['image'] }}" alt="product-thumb" style="width:70px;height:70px;object-fit:cover"></div></td>
                                        <td>
                                            <div class="product-title-area">
                                                <h4 class="product-title">{{ $item['name'] }}</h4>
                                                @if(isset($item['type']) && $item['type'] === 'service')
                                                    <span class="badge bg-info text-white" style="font-size: 11px; padding: 3px 8px;">Service/Jasa</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td><span class="product-price">Rp{{ number_format($item['price'],0,',','.') }}</span></td>
                                        <td>
                                            @if(isset($item['type']) && $item['type'] === 'service')
                                                {{-- Service quantity is always 1 and cannot be changed --}}
                                                <div class="cart-edit">
                                                    <div class="quantity-edit" style="justify-content: center;">
                                                        <input name="quantities[{{ $key }}]" type="hidden" value="1" />
                                                        <span class="badge bg-secondary" style="padding: 8px 16px; font-size: 14px;">Qty: 1</span>
                                                    </div>
                                                </div>
                                            @else
                                                {{-- Regular product with editable quantity --}}
                                                <div class="cart-edit">
                                                    <div class="quantity-edit">
                                                        <button type="button" class="button" onclick="this.nextElementSibling.stepDown()"><i class="fal fa-minus minus"></i></button>
                                                        <input name="quantities[{{ $key }}]" type="number" min="1" class="input" value="{{ $item['qty'] }}" />
                                                        <button type="button" class="button plus" onclick="this.previousElementSibling.stepUp()">+<i class="fal fa-plus plus"></i></button>
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="last-td">
                                            <button formaction="{{ route('cart.remove', ['id'=>$key]) }}" formmethod="POST" class="remove-btn">@csrf Remove</button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('home') }}" class="continue-shopping"><i class="fal fa-long-arrow-left"></i> Continue Shopping</a>
                                <button type="submit" class="apply-btn">Update Cart</button>
                            </div>
                        </form>
                        @endif
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="checkout-box">
                        <div class="checkout-box-inner">
                            <div class="subtotal-area">
                                <span class="title">Daftar Item</span>
                            </div>
                            <div class="cart-items-list" style="max-height: 300px; overflow-y: auto; margin-bottom: 20px;">
                                @if(!empty($items))
                                    @foreach($items as $item)
                                        <div class="cart-item-summary" style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #eee;">
                                            <div style="flex: 1;">
                                                <div style="font-weight: 600; font-size: 14px; margin-bottom: 3px;">{{ $item['name'] }}</div>
                                                <div style="font-size: 12px; color: #666;">
                                                    Qty: {{ $item['qty'] }} × Rp{{ number_format($item['price'], 0, ',', '.') }}
                                                </div>
                                            </div>
                                            <div style="font-weight: 700; color: #d51243; white-space: nowrap; padding-left: 15px;">
                                                Rp{{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="subtotal-area" style="">
                                <span class="title">Subtotal</span>
                                <span class="subtotal-price">Rp{{ number_format($subtotal ?? 0,0,',','.') }}</span>
                            </div>
                        </div>
                        <form action="{{ route('checkout.place') }}" method="POST" style="margin-top:12px;">
                            @csrf
                            <button type="submit" class="procced-btn">Place Order</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection