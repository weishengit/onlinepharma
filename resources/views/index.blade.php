@extends('layouts.front')

@section('content')
@if (session()->has('message'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session()->get('message') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
<div class="site-blocks-cover" style="background-image: url('images/bg_1.jpg');">
    <div class="container">
      <div class="row">
        <div class="col-lg-7 mx-auto order-lg-2 align-self-center">
          <div class="site-block-cover-content text-center">
            <h2 class="sub-title">Effective Medicine, New Medicine Everyday</h2>
            <h1>Welcome To Online Pharma</h1>
            <p>
                @guest
                    <a href="{{ route('login') }}" class="btn btn-primary px-5 py-3">LOGIN NOW</a>
                @endguest
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- BOXES --}}
  <div class="site-section">
    <div class="container">
      <div class="row align-items-stretch section-overlap">
        <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
          <div class="banner-wrap bg-primary h-100">
            <a href="{{ route('pages.shop') }}" class="h-100">
              <h5>Free <br> Delivery</h5>
              <p>
                On fol Areas

              </p>
            </a>
          </div>
        </div>
        <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
          <div class="banner-wrap h-100">
            <a href="{{ route('pages.shop') }}" class="h-100">
              <h5>Season <br> Sale 50% Off</h5>
              <p>
                Amazing Sale

              </p>
            </a>
          </div>
        </div>
        <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
          <div class="banner-wrap bg-warning h-100">
            <a href="{{ route('pages.contact') }}" class="h-100">
              <h5>Buy <br> A Gift Card</h5>
              <p>
                Contact Us

              </p>
            </a>
          </div>
        </div>

      </div>
    </div>
  </div>
  {{-- BOXES END --}}

  {{-- TOP PRODUCTS --}}
  <div class="site-section">
    <div class="container">
      <div class="row">
        <div class="title-section text-center col-12">
          <h2 class="text-uppercase">Popular Products</h2>
        </div>
      </div>

      <div class="row">
        @if (isset($topProducts))
            @foreach ($topProducts as $topProduct)
                <div class="col-sm-6 col-lg-4 text-center item mb-4">
                    <span class="tag">Sale</span>
                    <a href="{{ route('pages.show', ['product' => $topProduct->id]) }}"> <img src="{{ asset('images/' . $topProduct->image) }}" alt="Image"></a>
                    <h3 class="text-dark"><a href="{{ route('pages.show', ['product' => $topProduct->id]) }}">{{ $topProduct->name }}</a></h3>
                    <p class="price">&#8369;{{ $topProduct->price }}</p>
              </div>
            @endforeach
        @else
            <p>Unable to load top products</p>
        @endif


        {{-- <div class="col-sm-6 col-lg-4 text-center item mb-4">
            <span class="tag">Sale</span>
            <a href="shop-single.php"> <img src="images/product_02.png" alt="Image"></a>
            <h3 class="text-dark"><a href="shop-single.php">Chanca Piedra</a></h3>
            <p class="price"><del>95.00</del> &mdash; $55.00</p>
        </div> --}}

      </div>
      <div class="row mt-5">
        <div class="col-12 text-center">
          <a href="{{ route('pages.shop') }}" class="btn btn-primary px-4 py-3">View All Products</a>
        </div>
      </div>
    </div>
  </div>
  {{-- TOP PRODUCTS END --}}

  {{-- NEW PRODUCTS --}}
  <div class="site-section bg-light">
    <div class="container">
      <div class="row">
        <div class="title-section text-center col-12">
          <h2 class="text-uppercase">New Products</h2>
        </div>
      </div>

      <div class="row">

        <div class="col-md-12 block-3 products-wrap">
          <div class="nonloop-block-3 owl-carousel">

            @if (isset($newProducts))
                @foreach ($newProducts as $newProduct)
                    <div class="text-center item mb-4">
                        <a href="{{ route('pages.show', ['product' => $newProduct->id]) }}"> <img src="{{ asset('images/' . $newProduct->image) }}" alt="Image" height="340" width="40"></a>
                        <h3 class="text-dark"><a href="{{ route('pages.show', ['product' => $newProduct->id]) }}">{{ $newProduct->name }}</a></h3>
                        <p class="price">&#8369;{{ $newProduct->price }}</p>
                    </div>
                @endforeach
            @else
                <p>Unable to load new products</p>
            @endif

            {{-- <div class="text-center item mb-4">
              <a href="shop-single.php"> <img src="images/product_01.png" alt="Image"></a>
              <h3 class="text-dark"><a href="shop-single.php">Umcka Cold Care</a></h3>
              <p class="price">$120.00</p>
            </div> --}}

          </div>
        </div>
      </div>
    </div>
  </div>
  {{-- NEW PRODUCTS END --}}

  <div class="site-section">
    <div class="container">
      <div class="row">
        <div class="title-section text-center col-12">
          <h2 class="text-uppercase">Testimonials</h2>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 block-3 products-wrap">
          <div class="nonloop-block-3 no-direction owl-carousel">

            <div class="testimony">
              <blockquote>
                <img src="images/person_1.jpg" alt="Image" class="img-fluid w-25 mb-4 rounded-circle">
                <p>&ldquo;Buying your pharmaceutical needs online is the best thing in the world right now,
                  you can do anything without worrying what to buy because of the vast library of online drugstores.&rdquo;</p>
              </blockquote>

              <p>&mdash; Kelly Holmes</p>
            </div>

            <div class="testimony">
              <blockquote>
                <img src="images/person_2.jpg" alt="Image" class="img-fluid w-25 mb-4 rounded-circle">
                <p>&ldquo;Buying your pharmaceutical needs online is the best thing in the world right now,
                  you can do anything without worrying what to buy because of the vast library of online drugstores.&rdquo;</p>
              </blockquote>

              <p>&mdash; Rebecca Morando</p>
            </div>

            <div class="testimony">
              <blockquote>
                <img src="images/person_3.jpg" alt="Image" class="img-fluid w-25 mb-4 rounded-circle">
                <p>&ldquo;Buying your pharmaceutical needs online is the best thing in the world right now,
                  you can do anything without worrying what to buy because of the vast library of online drugstores.&rdquo;</p>
              </blockquote>

              <p>&mdash; Lucas Gallone</p>
            </div>

            <div class="testimony">
              <blockquote>
                <img src="images/person_4.jpg" alt="Image" class="img-fluid w-25 mb-4 rounded-circle">
                <p>&ldquo;Buying your pharmaceutical needs online is the best thing in the world right now,
                  you can do anything without worrying what to buy because of the vast library of online drugstores.&rdquo;</p>
              </blockquote>

              <p>&mdash; Andrew Neel</p>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
@endsection()
