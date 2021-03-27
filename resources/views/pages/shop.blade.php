@extends('layouts.front')

@section('content')
<div class="bg-light py-3">
  <div class="container">
    <div class="row">
      <div class="col-md-12 mb-0"><a href="{{ route('home') }}">Home</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">Store</strong></div>
    </div>
  </div>
</div>

<div class="site-section">
  <div class="container">

    <div class="row">
      <div class="col-lg-6">
        <h3 class="mb-3 h6 text-uppercase text-black d-block">Filter by Price</h3>
        <div id="slider-range" class="border-primary"></div>
        <input type="text" name="text" id="amount" class="form-control border-0 pl-0 bg-white" disabled="" />
      </div>
      <div class="col-lg-6">
        <h3 class="mb-3 h6 text-uppercase text-black d-block">Filter by Reference</h3>
        <button type="button" class="btn btn-secondary btn-md dropdown-toggle px-4" id="dropdownMenuReference"
          data-toggle="dropdown">Reference</button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuReference">
          <a class="dropdown-item" href="#">Relevance</a>
          <a class="dropdown-item" href="#">Name, A to Z</a>
          <a class="dropdown-item" href="#">Name, Z to A</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Price, low to high</a>
          <a class="dropdown-item" href="#">Price, high to low</a>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-6 col-lg-4 text-center item mb-4">
        <span class="tag">Sale</span>
        <a href="{{ route('pages.show', ['product' => 'bioderma-tablet-200mg']) }}"> <img src="{{ asset('images/product_01.png') }}" alt="Image"></a>
        <h3 class="text-dark"><a href="shop-single.php">Bioderma</a></h3>
        <p class="price"><del>95.00</del> &mdash; $55.00</p>
      </div>
      <div class="col-sm-6 col-lg-4 text-center item mb-4">
        <a href="shop-single.php"> <img src="{{ asset('images/product_02.png') }}" alt="Image"></a>
        <h3 class="text-dark"><a href="shop-single.php">Chanca Piedra</a></h3>
        <p class="price">$70.00</p>
      </div>
      <div class="col-sm-6 col-lg-4 text-center item mb-4">
        <a href="shop-single.php"> <img src="{{ asset('images/product_03.png') }}" alt="Image"></a>
        <h3 class="text-dark"><a href="shop-single.php">Umcka Cold Care</a></h3>
        <p class="price">$120.00</p>
      </div>

      <div class="col-sm-6 col-lg-4 text-center item mb-4">

        <a href="shop-single.php"> <img src="{{ asset('images/product_04.png') }}" alt="Image"></a>
        <h3 class="text-dark"><a href="shop-single.php">Cetyl Pure</a></h3>
        <p class="price"><del>45.00</del> &mdash; $20.00</p>
      </div>
      <div class="col-sm-6 col-lg-4 text-center item mb-4">
        <a href="shop-single.php"> <img src="{{ asset('images/product_05.png') }}" alt="Image"></a>
        <h3 class="text-dark"><a href="shop-single.php">CLA Core</a></h3>
        <p class="price">$38.00</p>
      </div>
      <div class="col-sm-6 col-lg-4 text-center item mb-4">
        <span class="tag">Sale</span>
        <a href="shop-single.php"> <img src="{{ asset('images/product_06.png') }}" alt="Image"></a>
        <h3 class="text-dark"><a href="shop-single.php">Poo Pourri</a></h3>
        <p class="price"><del>$89</del> &mdash; $38.00</p>
      </div>

      <div class="col-sm-6 col-lg-4 text-center item mb-4">
        <span class="tag">Sale</span>
        <a href="shop-single.php"> <img src="{{ asset('images/product_01.png') }}" alt="Image"></a>
        <h3 class="text-dark"><a href="shop-single.php">Bioderma</a></h3>
        <p class="price"><del>95.00</del> &mdash; $55.00</p>
      </div>
      <div class="col-sm-6 col-lg-4 text-center item mb-4">
        <a href="shop-single.php"> <img src="{{ asset('images/product_02.png') }}" alt="Image"></a>
        <h3 class="text-dark"><a href="shop-single.php">Chanca Piedra</a></h3>
        <p class="price">$70.00</p>
      </div>
      <div class="col-sm-6 col-lg-4 text-center item mb-4">
        <a href="shop-single.php"> <img ˀsrc="{{ asset('images/product_03.png') }}" alt="Image"></a>
        <h3 class="text-dark"><a href="shop-single.php">Umcka Cold Care</a></h3>
        <p class="price">$120.00</p>
      </div>

      <div class="col-sm-6 col-lg-4 text-center item mb-4">

        <a href="shop-single.php"> <img src="{{ asset('images/product_04.png') }}" alt="Image"></a>
        <h3 class="text-dark"><a href="shop-single.php">Cetyl Pure</a></h3>
        <p class="price"><del>45.00</del> &mdash; $20.00</p>
      </div>
      <div class="col-sm-6 col-lg-4 text-center item mb-4">
        <a href="shop-single.php"> <img src="{{ asset('images/product_05.png') }}" alt="Image"></a>
        <h3 class="text-dark"><a href="shop-single.php">CLA Core</a></h3>
        <p class="price">$38.00</p>
      </div>
      <div class="col-sm-6 col-lg-4 text-center item mb-4">
        <span class="tag">Sale</span>
        <a href="shop-single.php"> <img src="{{ asset('images/product_06.png') }}" alt="Image"></a>
        <h3 class="text-dark"><a href="shop-single.php">Poo Pourri</a></h3>
        <p class="price"><del>$89</del> &mdash; $38.00</p>
      </div>
    </div>
    <div class="row mt-5">
      <div class="col-md-12 text-center">
        <div class="site-block-27">
          <ul>
            <li><a href="#">&lt;</a></li>
            <li class="active"><span>1</span></li>
            <li><a href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li><a href="#">4</a></li>
            <li><a href="#">5</a></li>
            <li><a href="#">&gt;</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection