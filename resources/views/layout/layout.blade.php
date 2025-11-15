<!DOCTYPE html>
<html lang="en" class="darkmode" data-theme="light">

<x-head headTitle='{{ isset($headTitle) ? $headTitle : "" }}' css='{!! isset($css) ? $css : "" !!}'/>

@stack('styles')

<style>
    html {
        height: 100%;
    }
    body {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        margin: 0;
    }
    main {
        flex: 1 0 auto;
        background: #ffffff;
    }
    footer, .rts-footer {
        flex-shrink: 0;
        margin-top: 0;
    }
</style>

<body>

    <!-- ..::Preloader Section Start Here::.. -->
    <x-preloader />
    <!-- ..::Preloader End Here::.. -->

    <div class="anywere"></div>

    @include('layout.header')

    @if(session('success'))
    <div class="alert-notification" style="position: fixed; top: 80px; right: 20px; z-index: 9999; background: #d4edda; color: #155724; padding: 16px 24px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); display: flex; align-items: center; gap: 12px; max-width: 400px; animation: slideIn 0.3s ease-out;">
        <i class="fas fa-check-circle" style="font-size: 20px;"></i>
        <span style="flex: 1; font-weight: 500;">{{ session('success') }}</span>
        <button onclick="this.parentElement.remove()" style="background: none; border: none; font-size: 20px; cursor: pointer; color: #155724; padding: 0; line-height: 1;">&times;</button>
    </div>
    <script>
        setTimeout(function() {
            var alert = document.querySelector('.alert-notification');
            if (alert) {
                alert.style.animation = 'slideOut 0.3s ease-in';
                setTimeout(() => alert.remove(), 300);
            }
        }, 5000);
    </script>
    <style>
        @keyframes slideIn {
            from { transform: translateX(400px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes slideOut {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(400px); opacity: 0; }
        }
    </style>
    @endif

    <main style="flex: 1 0 auto;">
        @yield('content')
    </main>

        <?php 

            if (!isset($footer)) {
                ?>
                <x-footer/>
                <?php
            }
        ?>

    <x-scroll />

    <x-script script='{!! isset($script) ? $script : "" !!}' />

    @stack('scripts')

</body>

</html>