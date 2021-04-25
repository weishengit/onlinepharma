<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $metaTitle ?? config('app.name') }} - {{ config('app.name') }}</title>

  <link href="https://fonts.googleapis.com/css?family=Rubik:400,700|Crimson+Text:400,400i" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('fonts/icomoon/style.css') }}">

  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/magnific-popup.css') }}">
  <link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}">
  <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/owl.theme.default.min.css') }}">

  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
  <link rel="manifest" href="{{ asset('site.webmanifest') }}">

  <link rel="stylesheet" href="{{ asset('css/aos.css') }}">

  <link rel="stylesheet" href="{{ asset('css/style.css') }}">

  @yield('style')

</head>

<body>

<div class="site-wrap">
    <div class="site-navbar py-2">

        <div class="container">
            <div class="d-flex align-items-center justify-content-between">
              <div class="logo">
                  <div class="site-logo">
                    <a class="navbar-brand" href="#">
                      <img src="{{ asset('favicon-32x32.png') }}" width="30" height="30" alt="">
                    </a>
                  <a href="{{ route('home') }}" class="js-logo-clone">{{ config('app.name') ?? Store }}</a>
                  </div>
              </div>
            <div class="main-nav d-none d-lg-block">
                <nav class="site-navigation text-right text-md-center" role="navigation">
                <ul class="site-menu js-clone-nav d-none d-lg-block">
                    <li class="{{ isset($metaTitle) && $metaTitle == 'Home' ? 'active' : '' }}"><a href="{{ route('home') }}">Home</a></li>
                    <li class="{{ isset($metaTitle) && $metaTitle == 'Shop' ? 'active' : '' }}"><a href="{{ route('pages.shop') }}">Shop</a></li>

                    <li class="has-children">
                    <a href="#">Popular</a>
                    <ul class="dropdown">
                        <li><a href="#">Supplements</a></li>
                        <li class="has-children">
                        <a href="#">Vitamins</a>
                        <ul class="dropdown">
                            <li><a href="#">Supplements</a></li>
                            <li><a href="#">Vitamins</a></li>
                            <li><a href="#">Diet &amp; Nutrition</a></li>
                            <li><a href="#">Tea &amp; Coffee</a></li>
                        </ul>
                        </li>
                        <li><a href="#">Diet &amp; Nutrition</a></li>
                        <li><a href="#">Tea &amp; Coffee</a></li>

                    </ul>
                    </li>

                    <li class="{{ isset($metaTitle) && $metaTitle == 'About' ? 'active' : '' }}"><a href="{{ route('pages.about') }}">About</a></li>
                    <li class="{{ isset($metaTitle) && $metaTitle == 'Contact' ? 'active' : '' }}"><a href="{{ route('pages.contact') }}">Contact</a></li>
                </ul>
                </nav>
            </div>
            <div class="icons">
                <a href="{{ route('cart') }}" class="icons-btn d-inline-block bag">
                <span class="icon-shopping-bag"></span>
                @if (Session::has('cart'))
                  <span class="number">{{ Session::get('cart')->getTotalCartQty() ?? '' }}</span>
                @endif

                </a>
                <a href="#" class="site-menu-toggle js-menu-toggle ml-3 d-inline-block d-lg-none"><span
                    class="icon-menu"></span></a>
            </div>

            @if (Route::has('login'))
                <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                    @auth
                        <a href="{{ route('profile.index') }}" class="text-sm text-gray-700 underline">
                          <span class="icon-user icons-btn d-inline-block"></span>
                          My Account
                        </a>
                    @else
                        {{-- <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Log in</a> --}}

                        @if (Route::has('register'))
                            <a href="{{ route('login') }}" class="ml-4 text-sm text-gray-700 underline">Login</a>
                        @endif
                    @endauth
                </div>
            @endif
            </div>
        </div>
    </div>

    {{-- CONTENT  --}}
    @yield('content')

    <footer class="site-footer">
        <div class="container">
          <div class="row">
            <div class="col-md-6 col-lg-3 mb-4 mb-lg-0">

              <div class="block-7">
                <h3 class="footer-heading mb-4">About Us</h3>
                <p>This Website is a Template Website of a Pharmaceutical Online Store that is purposely created
                to be a capstone project and at the same time, a fully functioning online drugstore.</p>
              </div>

            </div>
            <div class="col-lg-3 mx-auto mb-5 mb-lg-0">
              <h3 class="footer-heading mb-4">Quick Links</h3>
              <ul class="list-unstyled">
                <li><a href="{{ route('pages.shop') }}">Store</a></li>
                <li><a href="{{ route('pages.about') }}">About</a></li>
                <li>
                    @guest
                        <a href="{{ route('login') }}">Login</a>
                    @endguest
                    @auth
                        <a href="{{ route('logout') }}">Logout</a>
                    @endauth
                </li>
                <li><a href="{{ route('pages.contact') }}">Contact </a></li>
              </ul>
            </div>

            <div class="col-md-6 col-lg-3">
              <div class="block-5 mb-5">
                <h3 class="footer-heading mb-4">Contact Info</h3>
                <ul class="list-unstyled">
                  <li class="address">129 Gabaldon Street, Barangay San Isidro Cabanatuan City, Nueva Ecija, Philippines</li>
                  <li class="phone"><a href="tel://0927-449-6838">0927-449-6838</a></li>
                  <li class="email">emailaddress@domain.com</li>
                </ul>
              </div>
            </div>
          </div>
          <div class="row pt-5 mt-5 text-center">
            <div class="col-md-12">
              <p>
                <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                Copyright &copy;
                <script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made
                with <i class="icon-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank"
                  class="text-primary">Colorlib</a>
                <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
              </p>
            </div>

          </div>
        </div>
    </footer>
</div>


    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('js/aos.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>

    @yield('script')

</body>

</html>
