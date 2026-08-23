<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>@yield('title', 'BGPortal Admin & Dashboard')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta content="BGPortal Central System" name="description" />
    <meta content="BGPortal" name="author" />

    <!-- layout setup -->
    <script type="module" src="{{ asset('assets/js/layout-setup.js') }}"></script>

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/k_favicon_32x.png') }}">

    @yield('css')
    @include('partials.head-css')
</head>

<body>

    @include('partials.header')
    @include('partials.sidebar')
    @include('partials.horizontal')

    <main class="app-wrapper">
        <div class="container-fluid">

            @unless (request()->is('apps/finance*'))
                @include('partials.page-title')
            @endunless

            @yield('content')
            @include('partials.switcher')
            @include('partials.scroll-to-top')
            @include('partials.footer')

            @include('partials.vendor-scripts')

            @yield('js')
        </div>
    </main>

</body>

</html>
