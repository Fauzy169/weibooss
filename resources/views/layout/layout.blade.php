<!DOCTYPE html>
<html lang="en" class="darkmode" data-theme="light">

<x-head headTitle='{{ isset($headTitle) ? $headTitle : "" }}' css='{!! isset($css) ? $css : "" !!}'/>

<body>

    <!-- ..::Preloader Section Start Here::.. -->
    <x-preloader />
    <!-- ..::Preloader End Here::.. -->

    <div class="anywere"></div>

    @include('layout.header')

    @yield('content')

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