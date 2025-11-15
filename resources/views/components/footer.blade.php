<div class="footer footer-1">
        <div class="container">
            <div class="footer-inner">
                <div class="row">
                    <div class="col-xl-3 col-md-6 col-sm-6 box-widget-col">
                        <div class="footer-widget footer-box-widget">
                            <div class="footer-logo">
                        <a href="{{ route('index') }}" class="logo"><img src="{{ asset('assets/images/logossstandfasha.PNG') }}" alt="standfasha-logo"><img src="{{ asset('assets/images/terakhir.PNG') }}" alt="footer-logo"></a></div>
                            <p>Menyediakan berbagai pilihan baju pengantin dan aksesoris berkualitas untuk hari istimewa Anda.</p>
                            <ul class="social-links-footer2">
                                <li><a class="platform fb" target="_blank" href="http://facebook.com"><i
                                            class="fab fa-facebook"></i></a>
                                </li>
                                <li><a class="platform yt" target="_blank" href="http://youtube.com"><i
                                            class="fab fa-youtube"></i></a>
                                </li>
                                <li><a class="platform ttr" target="_blank" href="http://twitter.com"><i
                                            class="fab fa-twitter"></i></a>
                                </li>
                                <li><a class="platform lkd" target="_blank" href="http://linkedin.com"><i
                                            class="fab fa-linkedin"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 col-sm-6 box-widget-col2">
                        <div class="footer-widget">
                            <h3 class="footer-widget-title">Tentang Kami</h3>
                            <p class="widget-text">StandFasha adalah toko terpercaya untuk kebutuhan pernikahan Anda. 
                                Kami menyediakan baju pengantin, aksesoris, dan layanan terbaik 
                                untuk mewujudkan momen spesial Anda.</p>
                            <a href="{{ route('index') }}#contact" class="getin-touch">Hubungi Kami <i class="fal fa-long-arrow-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-13 col-md-6 col-sm-6 no-gutters">
                        <div class="footer-widget">
                            <h3 class="footer-widget-title">Informasi</h3>
                            <ul class="widget-items cata-widget">
                                <li class="widget-list-item"><a href="{{ route('index') }}">Beranda</a></li>
                                <li class="widget-list-item"><a href="{{ route('index') }}#baju-pengantin">Baju Pengantin</a></li>
                                <li class="widget-list-item"><a href="{{ route('index') }}#aksesoris">Aksesoris</a></li>
                                <li class="widget-list-item"><a href="{{ route('index') }}#service">Layanan</a></li>
                                <li class="widget-list-item"><a href="{{ route('index') }}#promo">Promo</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-13 col-md-6 col-sm-6 no-gutters">
                        <h3 class="footer-widget-title">Akun Saya</h3>
                        <ul class="footer-widget">
                            <li class="widget-list-item"><a href="{{ route('account') }}">Akun Saya</a></li>
                            <li class="widget-list-item"><a href="{{ route('cart') }}">Keranjang</a></li>
                            <li class="widget-list-item"><a href="{{ route('checkOut') }}">Checkout</a></li>
                            <li class="widget-list-item"><a href="{{ route('category') }}">Semua Kategori</a></li>
                            @auth
                            <li class="widget-list-item">
                                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" style="background: none; border: none; color: inherit; padding: 0; cursor: pointer; font-size: inherit;">Keluar</button>
                                </form>
                            </li>
                            @else
                            <li class="widget-list-item"><a href="{{ route('login') }}">Masuk</a></li>
                            @endauth
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>