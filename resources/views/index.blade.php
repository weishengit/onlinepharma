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
              <h5>Delivery</h5>
              <p>
                On selected Areas
              </p>
            </a>
          </div>
        </div>
        <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
          <div class="banner-wrap h-100">
            <a href="{{ route('pages.shop', ['filter' => 'on_sale']) }}" class="h-100">
              <h5>Sale <br> on select items</h5>
              <p>
                Amazing Sale
              </p>
            </a>
          </div>
        </div>
        <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
          <div class="banner-wrap bg-warning h-100">
            <a href="{{ route('pages.contact') }}" class="h-100">
              <h5>Inquiries? <br> Talk to us</h5>
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

  {{-- SALE PRODUCTS --}}
  @if (isset($saleProducts))
  <div class="site-section">
    <div class="container">
      <div class="row">
        <div class="title-section text-center col-12">
          <h2 class="text-uppercase">On SALE!</h2>
        </div>
      </div>

      <div class="row">

            @foreach ($saleProducts as $saleProduct)
                <div class="col-sm-6 col-lg-4 text-center item mb-4">
                    <span class="tag">

                        @if ($saleProduct->sale->is_percent)
                            {{ $saleProduct->sale->rate }}
                            %
                        @else
                            &#8369;
                            {{ $saleProduct->sale->rate }}
                        @endif
                        Off

                    </span>

                    <a href="{{ route('pages.show', ['product' => $saleProduct->id]) }}"> <img src="{{ asset('images/' . $saleProduct->image) }}" alt="Image"></a>
                    <h3 class="text-dark"><a href="{{ route('pages.show', ['product' => $saleProduct->id]) }}">{{ $saleProduct->name }}</a></h3>
                    <p class="price text-dark">
                        <del class="text-danger">
                            &#8369;{{ $saleProduct->price }}
                        </del>
                        <strong class="text-dark h4">
                            &#8369;
                            @if ($saleProduct->sale->is_percent)
                            {{ round(($saleProduct->price - ($saleProduct->price * ($saleProduct->sale->rate / 100))),2 )  }}
                            @else
                                {{ $saleProduct->price - $saleProduct->sale->rate }}
                            @endif
                        </strong>
                    </p>
              </div>
            @endforeach

      </div>
      <div class="row mt-5">
        <div class="col-12 text-center">
          <a href="{{ route('pages.shop', ['filter' => 'on_sale']) }}" class="btn btn-primary px-4 py-3">View Sales</a>
        </div>
      </div>
    </div>
  </div>
  @endif
  {{-- SALE PRODUCTS END --}}

  {{-- TOP PRODUCTS --}}
  @if (isset($topProducts))
  <div class="site-section">
    <div class="container">
      <div class="row">
        <div class="title-section text-center col-12">
          <h2 class="text-uppercase">Popular Products</h2>
        </div>
      </div>

      <div class="row">

            @foreach ($topProducts as $topProduct)
                <div class="col-sm-6 col-lg-4 text-center item mb-4">
                    <span class="tag">Sale</span>
                    <a href="{{ route('pages.show', ['product' => $topProduct->id]) }}"> <img src="{{ asset('images/' . $topProduct->image) }}" alt="Image"></a>
                    <h3 class="text-dark"><a href="{{ route('pages.show', ['product' => $topProduct->id]) }}">{{ $topProduct->name }}</a></h3>
                    <p class="price">&#8369;{{ $topProduct->price }}</p>
              </div>
            @endforeach

      </div>
      <div class="row mt-5">
        <div class="col-12 text-center">
          <a href="{{ route('pages.shop') }}" class="btn btn-primary px-4 py-3">View All Products</a>
        </div>
      </div>
    </div>
  </div>
  @endif
  {{-- TOP PRODUCTS END --}}

  {{-- NEW PRODUCTS --}}
  @if (isset($newProducts))
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


                @foreach ($newProducts as $newProduct)
                    <div class="text-center item mb-4">
                        <a href="{{ route('pages.show', ['product' => $newProduct->id]) }}"> <img src="{{ asset('images/' . $newProduct->image) }}" alt="Image" height="340" width="40"></a>
                        <h3 class="text-dark"><a href="{{ route('pages.show', ['product' => $newProduct->id]) }}">{{ $newProduct->name }}</a></h3>
                        <p class="price">&#8369;{{ $newProduct->price }}</p>
                    </div>
                @endforeach

          </div>
        </div>
      </div>
    </div>
  </div>
  @endif
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
