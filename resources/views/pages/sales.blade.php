@extends('layouts.front')

@section('content')
<div class="bg-light py-3">
  <div class="container">
    <div class="row">
      <div class="col-md-12 mb-0">
        <a href="{{ route('home') }}">Home</a> <span class="mx-2 mb-0">/</span>
        <strong class="text-black">Sales</strong>
      </div>
    </div>
  </div>
</div>

<div class="site-section">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h2 class="h3 mb-5 text-black">Sales</h2>
      </div>
      <div class="col-md-12">

        <form action="#" method="post">

          <div class="p-3 p-lg-5 border">
            <div class="form-group row">
              <form class="col-md-12" method="post">
                <div class="site-blocks-table">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th class="product-thumbnail">Image</th>
                        <th class="product-name">Product</th>
                        <th class="product-price">Price</th>
                        <th class="product-quantity">Quantity</th>
                        <th class="product-total">Total</th>
                        <th class="product-remove">Remove</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td class="product-thumbnail">
                          <img src="{{ asset('images/product_02.png') }}" alt="Image" class="img-fluid">
                        </td>
                        <td class="product-name">
                          <h2 class="h5 text-black">Ibuprofen</h2>
                        </td>
                        <td>$55.00</td>
                        <td>
                          <div class="input-group mb-3" style="max-width: 120px;">
                            <div class="input-group-prepend">
                              <button class="btn btn-outline-primary js-btn-minus" type="button">&minus;</button>
                            </div>
                            <input type="text" class="form-control text-center" value="1" placeholder=""
                              aria-label="Example text with button addon" aria-describedby="button-addon1">
                            <div class="input-group-append">
                              <button class="btn btn-outline-primary js-btn-plus" type="button">&plus;</button>
                            </div>
                          </div>

                        </td>
                        <td>$49.00</td>
                        <td><a href="#" class="btn btn-primary height-auto btn-sm">X</a></td>
                      </tr>

                      <tr>
                        <td class="product-thumbnail">
                          <img src="{{ asset('images/product_01.png') }}" alt="Image" class="img-fluid">
                        </td>
                        <td class="product-name">
                          <h2 class="h5 text-black">Bioderma</h2>
                        </td>
                        <td>$49.00</td>
                        <td>
                          <div class="input-group mb-3" style="max-width: 120px;">
                            <div class="input-group-prepend">
                              <button class="btn btn-outline-primary js-btn-minus" type="button">&minus;</button>
                            </div>
                            <input type="text" class="form-control text-center" value="1" placeholder=""
                              aria-label="Example text with button addon" aria-describedby="button-addon1">
                            <div class="input-group-append">
                              <button class="btn btn-outline-primary js-btn-plus" type="button">&plus;</button>
                            </div>
                          </div>

                        </td>
                        <td>$49.00</td>
                        <td><a href="#" class="btn btn-primary height-auto btn-sm">X</a></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </form>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="row mb-5">
                  <div class="col-md-6 mb-3 mb-md-0">
                    <button class="btn btn-primary btn-md btn-block">Update Panel</button>
                  </div>
                  <div class="col-md-6">
                    <button class="btn btn-outline-primary btn-md btn-block">Continue Shopping</button>
                  </div>
                </div>
              </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="site-section bg-primary">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <h2 class="text-white mb-4">Offices</h2>
      </div>
      <div class="col-lg-4">
        <div class="p-4 bg-white mb-3 rounded">
          <span class="d-block text-black h6 text-uppercase">CABANATUAN</span>
          <p class="mb-0">CABANATUAN CITY, NUEVA ECIJA, PHILIPPINES</p>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="p-4 bg-white mb-3 rounded">
          <span class="d-block text-black h6 text-uppercase">CABANATUAN</span>
          <p class="mb-0">CABANATUAN CITY, NUEVA ECIJA, PHILIPPINES</p>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="p-4 bg-white mb-3 rounded">
          <span class="d-block text-black h6 text-uppercase">CABANATUAN</span>
          <p class="mb-0">CABANATUAN CITY, NUEVA ECIJA, PHILIPPINES</p>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection