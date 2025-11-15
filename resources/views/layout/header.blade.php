<header id="rtsHeader">
    <div class="navbar-sticky">
        <div class="container">
            <div class="navbar-part navbar-part1">
                <div class="navbar-inner">
                    <div class="left-side">
                        <a href="{{ route('index') }}" class="logo"><img src="{{ asset('assets/images/logossstandfasha.PNG') }}" alt="standfasha-logo"></a>
                        <a href="{{ route('index') }}" class="logo"><img src="{{ asset('assets/images/terakhir.PNG') }}" alt="standfasha-logo"></a>
                    </div>
                    <div class="rts-menu">
                        <nav class="menus menu-toggle">
                            <ul class="nav__menu">
                                <li class="has-dropdown"><a class="menu-item" href="#">Category <i class="rt-plus"></i></a>
                                    <ul class="dropdown-ul">
                                        <li class="dropdown-li"><a class="dropdown-link" href="{{ route('category') }}">All Categories</a></li>
                                        @php
                                            $headerCategories = \App\Models\Category::orderBy('name')->get();
                                        @endphp
                                        @foreach($headerCategories as $cat)
                                        <li class="dropdown-li">
                                            <a class="dropdown-link" href="{{ route('index') }}#{{ $cat->slug }}">{{ $cat->name }}</a>
                                        </li>
                                        @endforeach
                                    </ul>
                                </li>
                                <li><a class="menu-item" href="{{ route('index') }}#baju-pengantin">Baju Pengantin</a></li>
                                <li><a class="menu-item" href="{{ route('index') }}#promo">Promo</a></li>
                                <li><a class="menu-item" href="{{ route('index') }}#aksesoris">Aksesoris</a></li>
                                <li><a class="menu-item" href="{{ route('index') }}#service">Service</a></li>
                            </ul>
                        </nav>
                    </div>
                    <div class="responsive-hamburger">
                        <div class="hamburger-1">
                            <a href="#" class="nav-menu-link">
                                <span class="dot1"></span>
                                <span class="dot2"></span>
                                <span class="dot3"></span>
                                <span class="dot4"></span>
                                <span class="dot5"></span>
                                <span class="dot6"></span>
                                <span class="dot7"></span>
                                <span class="dot8"></span>
                                <span class="dot9"></span>
                            </a>
                        </div>
                    </div>
                    <div class="header-action-items header-action-items1">
                        <div class="search-part">
                            <div class="search-icon action-item icon"><i class="rt-search"></i></div>
                            <div class="search-input-area">
                                <div class="container">
                                    <div class="search-input-inner">
                                        <div class="input-div">
                                            <input id="searchInput1" class="search-input" type="text" placeholder="Search by keyword or #">
                                        </div>
                                        <div class="search-close-icon"><i class="rt-xmark"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        @auth
                        <div class="user-dropdown action-item">
                            <div class="user-nav">
                                <div class="user-icon icon" style="cursor: pointer;">
                                    <i class="rt-user-2"></i>
                                </div>
                                <div class="user-dropdown-menu" style="display: none; position: absolute; top: 100%; right: 0; background: white; box-shadow: 0 4px 12px rgba(0,0,0,0.15); border-radius: 8px; min-width: 200px; z-index: 999; margin-top: 10px;">
                                    <div style="padding: 16px; border-bottom: 1px solid #eee;">
                                        <div style="font-weight: 600; color: #333; margin-bottom: 4px;">{{ Auth::user()->name }}</div>
                                        <div style="font-size: 12px; color: #666; margin-bottom: 2px;">{{ Auth::user()->role_name }}</div>
                                        <div style="font-size: 12px; color: #999;">{{ Auth::user()->email }}</div>
                                    </div>
                                    <div style="padding: 8px 0;">
                                        <a href="{{ route('account') }}" style="display: block; padding: 10px 16px; color: #666; text-decoration: none; transition: background 0.2s;">
                                            <i class="rt-user-2" style="margin-right: 8px;"></i> My Account
                                        </a>
                                        @if(Auth::user()->hasAnyRole(['super_admin', 'administrator', 'owner', 'keuangan', 'gudang', 'sales', 'kasir']))
                                        <a href="/admin" style="display: block; padding: 10px 16px; color: #666; text-decoration: none; transition: background 0.2s;">
                                            <i class="fas fa-cog" style="margin-right: 8px;"></i> Admin Panel
                                        </a>
                                        @endif
                                    </div>
                                    <div style="border-top: 1px solid #eee; padding: 8px 0;">
                                        <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                                            @csrf
                                            <button type="submit" style="display: block; width: 100%; text-align: left; padding: 10px 16px; background: none; border: none; color: #d51243; cursor: pointer; transition: background 0.2s; font-size: 14px;">
                                                <i class="fas fa-sign-out-alt" style="margin-right: 8px;"></i> Logout
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                        <a href="{{ route('login') }}" class="account"><i class="rt-user-2"></i></a>
                        @endauth
                        
                        @php($__cart = session('cart', []))
                        @php($__cartQty = collect($__cart)->sum('qty'))
                        @php($__cartSubtotal = collect($__cart)->sum(fn($i) => $i['price'] * $i['qty']))
                        <div class="cart action-item">
                            <div class="cart-nav">
                                <div class="cart-icon icon"><a href="#0"><i aria-hidden="true" class="fas fa-shopping-basket"></i></a><span class="wishlist-dot icon-dot js-cart-qty">{{ $__cartQty }}</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="cart-bar" data-cart-update-url="{{ route('cart.update') }}" data-cart-remove-url-base="{{ url('/shop/cart/remove') }}">
        <div class="cart-header">
            <h3 class="cart-heading">MY CART ({{ $__cartQty }} ITEMS)</h3>
            <div class="close-cart"><i class="fal fa-times"></i></div>
        </div>
        <div class="product-area">
            @forelse($__cart as $c)
            <div class="product-item" data-id="{{ $c['id'] }}">
                <div class="product-detail">
                    <div class="product-thumb"><img src="{{ $c['image'] }}" alt="product-thumb"></div>
                    <div class="item-wrapper">
                        <span class="product-name">{{ $c['name'] }}</span>
                        <div class="item-wrapper">
                            <span class="product-qnty" data-qty>{{ $c['qty'] }} ×</span>
                            <span class="product-price">Rp{{ number_format($c['price'],0,',','.') }}</span>
                        </div>
                    </div>
                </div>
                <div class="cart-edit">
                    <div class="quantity-edit">
                        <button class="button js-cart-delta" data-id="{{ $c['id'] }}" data-cart-delta="-1" title="Kurangi"><i class="fal fa-minus minus"></i></button>
                        <input type="text" class="input" value="{{ $c['qty'] }}" readonly />
                        <button class="button plus js-cart-delta" data-id="{{ $c['id'] }}" data-cart-delta="1" title="Tambah">+<i class="fal fa-plus plus"></i></button>
                    </div>
                    <div class="item-wrapper d-flex mr--5 align-items-center">
                        <button class="delete-cart js-cart-remove" data-id="{{ $c['id'] }}" title="Hapus"><i class="fal fa-times"></i></button>
                    </div>
                </div>
            </div>
            @empty
            <div class="py-3 text-center">Keranjang kosong.</div>
            @endforelse
        </div>
        <div class="cart-bottom-area">
            <span class="total-price">TOTAL: <span class="price js-cart-total">Rp{{ number_format($__cartSubtotal,0,',','.') }}</span></span>
                <form action="{{ route('checkout.place') }}" method="POST" style="display:block;margin-top:10px;">
                    @csrf
                    <button type="submit" class="checkout-btn cart-btn">PLACE ORDER</button>
                </form>
                <a href="{{ route('cart') }}" class="view-btn cart-btn">VIEW CART</a>
        </div>
    </div>
    <!-- slide-bar start -->
    <aside class="slide-bar">
        <div class="offset-sidebar">
            <a class="hamburger-1 mobile-hamburger-1 ml--30" href="#"><span><i class="rt-xmark"></i></span></a>
        </div>
        <!-- offset-sidebar start -->
        <div class="offset-sidebar-main">
            <div class="offset-widget mb-40">
                <div class="info-widget">
                    <img src="{{ asset('assets/images/logo1.svg') }}" alt="">
                    <p class="mb-30">
                        We must explain to you how all seds this mistakens idea denouncing pleasures and praising account.
                    </p>
                </div>
                <div class="info-widget info-widget2">
                    <h4 class="offset-title mb-20">Get In Touch </h4>
                    <ul>
                        <li class="info phone"><a href="tel:78090790890208806803">780 907 908 90, 208 806 803</a></li>
                        <li class="info email"><a href="email:info@webmail.com">info@webmail.com</a></li>
                        <li class="info web"><a href="www.webexample.com">www.webexample.com</a></li>
                        <li class="info location">13/A, New Pro State, NYC</li>
                    </ul>
                    <div class="offset-social-link">
                        <h4 class="offset-title mb-20">Follow Us </h4>
                        <ul class="social-icon">
                            <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                            <li><a href="#"><i class="fab fa-linkedin"></i></a></li>
                            <li><a href="#"><i class="fab fa-behance"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- offset-sidebar end -->
        <!-- side-mobile-menu start -->
        <nav class="side-mobile-menu side-mobile-menu1">
            <ul id="mobile-menu-active">
                <li class="has-dropdown firstlvl">
                    <a class="mm-link" href="{{ route('index') }}">Home <i class="rt-angle-down"></i></a>
                    <ul class="sub-menu">
                        <li><a href="{{ route('index') }}">Main Home</a></li>
                        <li><a href="{{ route('indexTwo') }}">Fashion Home</a></li>
                        <li><a href="{{ route('indexNine') }}">Fashion Home Two</a></li>
                        <li><a href="{{ route('indexThree') }}">Furniture Home</a></li>
                        <li><a href="{{ route('indexFour') }}">Decor Home</a></li>
                        <li><a href="{{ route('indexFive') }}">Electronics Home</a></li>
                        <li><a href="{{ route('indexSix') }}">Grocery Home</a></li>
                        <li><a href="{{ route('indexSeven') }}">Footwear Home</a></li>
                        <li><a href="{{ route('indexEight') }}">Gaming Home</a></li>
                        <li><a href="{{ route('indexTen') }}">Sunglass Home</a></li>
                    </ul>
                </li>
                <li class="has-dropdown firstlvl">
                    <a class="mm-link" href="{{ route('shop') }}">Shop <i class="rt-angle-down"></i></a>
                    <ul class="sub-menu mega-dropdown-mobile">
                        <li class="mega-dropdown-li">
                            <ul class="mega-dropdown-ul mm-show">
                                <li class="dropdown-li"><a class="dropdown-link" href="{{ route('shop') }}">Shop</a>
                                </li>
                                <li class="dropdown-li"><a class="dropdown-link" href="{{ route('sidebarLeft') }}">Left Sidebar
                                        Shop</a>
                                </li>
                                <li class="dropdown-li"><a class="dropdown-link" href="{{ route('sidebarRight') }}">Right Sidebar
                                        Shop</a>
                                </li>
                                <li class="dropdown-li"><a class="dropdown-link" href="{{ route('fullWidthShop') }}">Full
                                        Width Shop</a>
                                </li>
                            </ul>
                        </li>
                        <li class="mega-dropdown-li">
                            <ul class="mega-dropdown-ul mm-show">
                                <li class="dropdown-li"><a class="dropdown-link" href="{{ route('shop') }}">Single Product
                                        Layout
                                        One</a>
                                </li>
                                <li class="dropdown-li"><a class="dropdown-link" href="{{ route('productDetails2') }}">Single Product Layout
                                        Two</a>
                                </li>
                                <li class="dropdown-li"><a class="dropdown-link" href="{{ route('variableProducts') }}">Variable Product</a>
                                </li>
                                <li class="dropdown-li"><a class="dropdown-link" href="{{ route('groupedProducts') }}">Grouped Product</a>
                                </li>
                            </ul>
                        </li>
                        <li class="mega-dropdown-li">
                            <ul class="mega-dropdown-ul mm-show">
                                <li class="dropdown-li"><a class="dropdown-link" href="{{ route('cart') }}">Cart
                                    </a>
                                </li>
                                <li class="dropdown-li"><a class="dropdown-link" href="{{ route('checkOut') }}">Checkout</a>
                                </li>
                                <li class="dropdown-li"><a class="dropdown-link" href="{{ route('account') }}">My
                                        Account</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="has-dropdown firstlvl">
                    <a class="mm-link" href="{{ route('index') }}">Pages <i class="rt-angle-down"></i></a>
                    <ul class="sub-menu">
                        <li><a href="{{ route('about') }}">About</a></li>
                        <li><a href="{{ route('faq') }}">FAQ's</a></li>
                        <li><a href="{{ route('errorPage') }}">Error 404</a></li>
                    </ul>
                </li>
                <li class="has-dropdown firstlvl">
                    <a class="mm-link" href="{{ route('news') }}">Blog <i class="rt-angle-down"></i></a>
                    <ul class="sub-menu">
                        <li><a href="{{ route('news') }}">Blog</a></li>
                        <li><a href="{{ route('newsGrid') }}">Blog Grid</a></li>
                        <li><a href="{{ route('newsDetails') }}">Blog Details</a></li>
                    </ul>
                </li>
                <li><a class="mm-link" href="{{ route('contact') }}">Contact</a></li>
            </ul>
        </nav>
        <div class="header-action-items header-action-items1 header-action-items-side">
            <div class="search-part">
                <div class="search-icon action-item icon"><i class="rt-search"></i></div>
                <div class="search-input-area">
                    <div class="container">
                        <div class="search-input-inner">
                            <select id="custom-select">
                                <option value="hide">All Catagory</option>
                                <option value="all">All</option>
                                <option value="men">Men</option>
                                <option value="women">Women</option>
                                <option value="shoes">Shoes</option>
                                <option value="shoes">Glasses</option>
                                <option value="shoes">Bags</option>
                                <option value="shoes">Assesories</option>
                            </select>
                            <div class="input-div">
                                <div class="search-input-icon"><i class="rt-search mr--10"></i></div>
                                <input class="search-input" type="text" placeholder="Search by keyword or #">
                            </div>
                            <div class="search-close-icon"><i class="rt-xmark"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="cart action-item">
                <div class="cart-nav">
                    <div class="cart-icon icon"><i class="rt-cart"></i><span class="wishlist-dot icon-dot js-cart-qty">{{ $__cartQty }}</span>
                    </div>
                </div>
            </div>
            <div class="wishlist action-item">
                <div class="favourite-icon icon"><i class="rt-heart"></i><span class="cart-dot icon-dot">0</span>
                </div>
            </div>
            
            @auth
            <div class="user-dropdown action-item">
                <div class="user-nav">
                    <div class="user-icon icon" style="cursor: pointer;">
                        <i class="rt-user-2"></i>
                    </div>
                    <div class="user-dropdown-menu" style="display: none; position: absolute; top: 100%; right: 0; background: white; box-shadow: 0 4px 12px rgba(0,0,0,0.15); border-radius: 8px; min-width: 200px; z-index: 999; margin-top: 10px;">
                        <div style="padding: 16px; border-bottom: 1px solid #eee;">
                            <div style="font-weight: 600; color: #333; margin-bottom: 4px;">{{ Auth::user()->name }}</div>
                            <div style="font-size: 12px; color: #666; margin-bottom: 2px;">{{ Auth::user()->role_name }}</div>
                            <div style="font-size: 12px; color: #999;">{{ Auth::user()->email }}</div>
                        </div>
                        <div style="padding: 8px 0;">
                            <a href="{{ route('account') }}" style="display: block; padding: 10px 16px; color: #666; text-decoration: none; transition: background 0.2s;">
                                <i class="rt-user-2" style="margin-right: 8px;"></i> My Account
                            </a>
                            @if(Auth::user()->hasAnyRole(['super_admin', 'administrator', 'owner', 'keuangan', 'gudang', 'sales', 'kasir']))
                            <a href="/admin" style="display: block; padding: 10px 16px; color: #666; text-decoration: none; transition: background 0.2s;">
                                <i class="fas fa-cog" style="margin-right: 8px;"></i> Admin Panel
                            </a>
                            @endif
                        </div>
                        <div style="border-top: 1px solid #eee; padding: 8px 0;">
                            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                                @csrf
                                <button type="submit" style="display: block; width: 100%; text-align: left; padding: 10px 16px; background: none; border: none; color: #d51243; cursor: pointer; transition: background 0.2s; font-size: 14px;">
                                    <i class="fas fa-sign-out-alt" style="margin-right: 8px;"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <a href="{{ route('login') }}" class="account"><i class="rt-user-2"></i></a>
            @endauth
        </div>
        <!-- side-mobile-menu end -->
    </aside>
</header>

@push('scripts')
<script>
(() => {
    if (window.__cartScriptLoaded) return; window.__cartScriptLoaded = true;
    const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    const formatIDR = (n) => 'Rp' + (Math.round(n).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.'));

    const postJson = async (url, data) => {
        const res = await fetch(url, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrf,
                'Accept': 'application/json'
            },
            body: data instanceof FormData ? data : new URLSearchParams(data)
        });
        return res.json();
    };

    const renderAllMiniCarts = (payload) => {
        document.querySelectorAll('.js-cart-qty').forEach(el => el.textContent = payload.qty);
        document.querySelectorAll('.js-cart-total').forEach(el => el.textContent = payload.subtotal_formatted);
        document.querySelectorAll('.cart-heading').forEach(el => el.textContent = `MY CART (${payload.qty} ITEMS)`);

        document.querySelectorAll('.cart-bar').forEach(bar => {
            const list = bar.querySelector('.product-area');
            if (!list) return;
            if (!payload.cart.length) {
                list.innerHTML = '<div class="py-3 text-center">Keranjang kosong.</div>';
                return;
            }
            const itemsHtml = payload.cart.map(i => `
                <div class="product-item" data-id="${i.id}">
                    <div class="product-detail">
                        <div class="product-thumb"><img src="${i.image}" alt="product-thumb"></div>
                        <div class="item-wrapper">
                            <span class="product-name">${i.name}</span>
                            <div class="item-wrapper">
                                <span class="product-qnty" data-qty>${i.qty} ×</span>
                                <span class="product-price">${formatIDR(i.price)}</span>
                            </div>
                        </div>
                    </div>
                    <div class="cart-edit">
                        <div class="quantity-edit">
                            <button class="button js-cart-delta" data-id="${i.id}" data-cart-delta="-1" title="Kurangi"><i class="fal fa-minus minus"></i></button>
                            <input type="text" class="input" value="${i.qty}" readonly />
                            <button class="button plus js-cart-delta" data-id="${i.id}" data-cart-delta="1" title="Tambah">+<i class="fal fa-plus plus"></i></button>
                        </div>
                        <div class="item-wrapper d-flex mr--5 align-items-center">
                            <button class="delete-cart js-cart-remove" data-id="${i.id}" title="Hapus"><i class="fal fa-times"></i></button>
                        </div>
                    </div>
                </div>`).join('');
            list.innerHTML = itemsHtml;
        });
    };

    const getCurrentQty = (btn) => {
        const item = btn.closest('.product-item');
        const qtySpan = item?.querySelector('[data-qty]');
        if (!qtySpan) return 1;
        const m = qtySpan.textContent.match(/\d+/);
        return m ? parseInt(m[0], 10) : 1;
    };

    document.addEventListener('click', async (e) => {
        const deltaBtn = e.target.closest('.js-cart-delta');
        if (deltaBtn) {
            e.preventDefault();
            const bar = deltaBtn.closest('.cart-bar');
            const updateUrl = bar?.dataset.cartUpdateUrl;
            const id = deltaBtn.dataset.id;
            const current = getCurrentQty(deltaBtn);
            const delta = parseInt(deltaBtn.dataset.cartDelta || '0', 10);
            const next = Math.max(1, current + delta);
            if (!updateUrl || !id) return;
            const data = new URLSearchParams();
            data.append(`quantities[${id}]`, String(next));
            try {
                const json = await postJson(updateUrl, data);
                if (json && json.ok) renderAllMiniCarts(json);
            } catch (_) {}
            return;
        }

        const removeBtn = e.target.closest('.js-cart-remove');
        if (removeBtn) {
            e.preventDefault();
            const bar = removeBtn.closest('.cart-bar');
            const base = bar?.dataset.cartRemoveUrlBase;
            const id = removeBtn.dataset.id;
            if (!base || !id) return;
            try {
                const json = await postJson(`${base}/${id}`, new URLSearchParams());
                if (json && json.ok) renderAllMiniCarts(json);
            } catch (_) {}
            return;
        }
    });
})();
</script>

<style>
.user-dropdown {
    position: relative;
}

.user-dropdown .user-nav {
    position: relative;
}

.user-dropdown-menu a:hover,
.user-dropdown-menu button:hover {
    background-color: #f8f9fa !important;
}
</style>

<script>
// User dropdown toggle
document.addEventListener('DOMContentLoaded', function() {
    const userDropdowns = document.querySelectorAll('.user-dropdown');
    
    userDropdowns.forEach(function(dropdown) {
        const userIcon = dropdown.querySelector('.user-icon');
        const userMenu = dropdown.querySelector('.user-dropdown-menu');
        
        if (userIcon && userMenu) {
            userIcon.addEventListener('click', function(e) {
                e.stopPropagation();
                // Close all other dropdowns first
                document.querySelectorAll('.user-dropdown-menu').forEach(function(menu) {
                    if (menu !== userMenu) {
                        menu.style.display = 'none';
                    }
                });
                // Toggle current dropdown
                userMenu.style.display = userMenu.style.display === 'none' ? 'block' : 'none';
            });
        }
    });
    
    // Close all dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.user-dropdown')) {
            document.querySelectorAll('.user-dropdown-menu').forEach(function(menu) {
                menu.style.display = 'none';
            });
        }
    });
});
</script>
@endpush