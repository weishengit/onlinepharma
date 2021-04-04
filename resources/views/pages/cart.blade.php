@extends('layouts.front')

@section('content')
<div class="bg-light py-3">
  <div class="container">
    <div class="row">
      <div class="col-md-12 mb-0"><a href="{{ route('home') }}">Home</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">Cart</strong></div>
    </div>
  </div>
</div>
@if ($cart == null)
    <div class="container text-center">
      <h2>You Cart is Empty</h2>
      <div class="text-center">
        <a href="{{ route('pages.shop') }}">
          <button class="btn btn-success btn-md">Go Shopping</button>
        </a>
      </div>
    <div> 
@else
{{-- TABLE START --}}
<div class="site-section">
  <div class="container">
    <div class="row mb-5">
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

              @foreach ($cart->items as $item)
              <tr>
                <td class="product-thumbnail">
                  <img src="{{ asset('images/' . $item['item']->image) }}" alt="Image" class="img-fluid">
                </td>
                <td class="product-name">
                  <h2 class="h5 text-black">{{ $item['item']['name'] }}</h2>
                </td>
                <td>&#8369;{{ $item['item']->price }}</td>
                <td>
                  {{-- QUANTITY --}}
                  <div class="input-group mb-3" style="max-width: 120px;">
                    {{-- DECREASE --}}
                    <div class="input-group-prepend">
                      <a href="{{ route('cart.decrease', ['id' => $item['item']->id]) }}">
                        <button class="btn btn-outline-primary" type="button">&minus;</button>
                      </a>
                    </div>
                    {{-- COUNT --}}
                    <input type="text" disabled class="form-control text-center" value="{{ $item['qty'] }}" placeholder="">
                    {{-- INCREASE --}}
                    <div class="input-group-append">
                      <a href="{{ route('cart.increase', ['id' => $item['item']->id]) }}">
                        <button class="btn btn-outline-primary" type="button">&plus;</button>
                      </a>
                    </div>

                  </div>
                  {{-- QUANTITY END --}}
                </td>
                <td>&#8369;{{ $item['qty'] * $item['item']->price }}</td>
                <td>
                  <a href="{{ route('cart.remove', ['id' => $item['item']->id, 'quantity' => $item['qty']]) }}" class="btn btn-primary height-auto btn-sm">X</a>
                </td>
              </tr>
              @endforeach
      
            </tbody>
          </table>
        </div>
      </form>
    </div>
{{-- TABLE END --}}
    
    <div class="row">
      <div class="col-md-6">
        {{-- BUTTONS --}}
        <div class="row mb-5">
          {{-- CLEAR CART --}}
          <div class="col-md-6 mb-3 mb-md-0">
            <a href="{{ route('cart.clear') }}">
              <button class="btn btn-danger btn-md btn-block">Clear Cart</button>
            </a>
          </div>
          {{-- CONTINUE SHOPPING --}}
          <div class="col-md-6">
            <a href="{{ route('pages.shop') }}">
              <button class="btn btn-outline-primary btn-md btn-block">Continue Shopping</button>
            </a>
          </div>
        </div>
        {{-- BUTTONS END --}}
        {{-- COUPON --}}
        <div class="row">
          <div class="col-md-12">
            <label class="text-black h4" for="coupon">Coupon</label>
            <p>Enter your coupon code if you have one.</p>
          </div>
          <div class="col-md-8 mb-3 mb-md-0">
            <input type="text" class="form-control py-3" id="coupon" placeholder="Coupon Code">
          </div>
          <div class="col-md-4">
            <button class="btn btn-primary btn-md px-4">Apply Coupon</button>
          </div>
        </div>
        {{-- COUPON END --}}
      </div>

      {{-- TOTALS --}}
      <div class="col-md-6 pl-5">
        <div class="row justify-content-end">
          <div class="col-md-7">
            {{-- TOTAL --}}
            <div class="row">
              <div class="col-md-12 text-right border-bottom mb-5">
                <h3 class="text-black h4 text-uppercase">Cart Totals</h3>
              </div>
            </div>
            {{-- TOTAL ITEMS --}}
            <div class="row mb-3">
              <div class="col-md-6">
                <span class="text-black">Total Items</span>
              </div>
              <div class="col-md-6 text-right">
                <strong class="text-black">{{ $cart->getTotalCartQty() ?? 'error' }}</strong>
              </div>
            </div>
            {{-- SUBTOTAL --}}
            <div class="row mb-3">
              <div class="col-md-6">
                <span class="text-black">Subtotal</span>
              </div>
              <div class="col-md-6 text-right">
                <strong class="text-black">&#8369;{{ number_format($cart->getSubTotal(), 2) ?? 'error' }}</strong>
              </div>
            </div>
            {{-- COUPON --}}
            <div class="row mb-5">
              <div class="col-md-6">
                <span class="text-black">Coupon</span>
              </div>
              <div class="col-md-6 text-right">
                <strong class="text-black">-&#8369;{{ number_format($cart->getDiscount(), 2) ?? 'error' }}</strong>
              </div>
            </div>
            {{-- TOTAL WITH OUT SC --}}
            <div class="row mb-3">
              <div class="col-md-6">
                <span class="text-black">Total</span>
              </div>
              <div class="col-md-6 text-right">
                <strong class="text-black">&#8369;{{ number_format($cart->getTotal(), 2) }}</strong>
              </div>
            </div>

            {{-- CHECKOUT --}}
            <div class="row border border-info">
              <h2 class="text-primary text-center ml-4 mt-2">Checkout Method</h2>
            

            <div class="card">
              <h5 class="card-header">Pick Up</h5>
              <div class="card-body">
                <h5 class="card-title">Get From Store</h5>
                <p class="card-text">You are required to bring your prescription and/or senior citizen id and booklet.</p>
                <a href="#" class="btn btn-primary">Pick Up</a>
              </div>
            </div>
            <div class="card">
              <h5 class="card-header">Delivery</h5>
              <div class="card-body">
                <h5 class="card-title">Deliver To Your Address</h5>
                <p class="card-text">The customer who ordered must be present to claim the order. Present your prescription or sc/pwd id if required</p>
                <a href="#" class="btn btn-primary">Delivery</a>
              </div>
            </div>

          </div>
            {{-- CHECKOUT --}}
     

          </div>
        </div>
      </div>
      {{-- TOTALS END --}}

    </div>
  </div>
</div>
@endif
@endsection