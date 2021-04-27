@extends('layouts.front')

@section('content')
<div class="bg-light py-3">
  <div class="container">
    <div class="row">
      <div class="col-md-12 mb-0"><a href="{{ route('home') }}">Home</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">Cart</strong></div>
    </div>
  </div>
</div>
@if (session()->has('message'))
      <div class="alert alert-warning alert-dismissible fade show" role="alert">
            {{ session()->get('message') }}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
      </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Holy guacamole!</strong> You should check in on some of those fields below.
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
@if ($cart == null)
    <div class="container text-center">
      <br><br><br>
      <h2>You Cart is Empty</h2>
      <br>
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


            {{-- CART ITEMS --}}
            <div class="site-blocks-table">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="product-thumbnail">Image</th>
                            <th class="product-name">Product</th>
                            <th class="product-quantity">Quantity</th>
                            <th class="product-price">Price</th>
                            <th class="product-total">Total</th>
                            <th class="product-remove">Remove</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($cart->getItems() as $item)
                        <tr>
                            <td class="product-thumbnail">
                            <img src="{{ asset('images/' . $item['item']->image) }}" alt="Image" class="img-fluid">
                            </td>
                            <td class="product-name">
                                <h2 class="h5 text-black">
                                    {{ $item['item']['name'] }}
                                    @if ($item['rx'] == 1)
                                        <span class="text-danger">*</span>
                                    @endif
                                </h2>
                            </td>
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
                            <td>&#8369;{{ $item['item']->price }}</td>
                            <td>&#8369;{{ $item['qty'] * $item['item']->price }}</td>
                            <td>
                            <a href="{{ route('cart.remove', ['id' => $item['item']->id, 'quantity' => $item['qty']]) }}" class="btn btn-primary height-auto btn-sm">X</a>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>

                {{-- BUTTONS --}}
                <div class="row mb-5">
                    {{-- CLEAR CART --}}
                    <div class="col-md-6 mb-3 mb-md-0">
                        <a href="{{ route('cart.clear') }}">
                            <button type="button" class="btn btn-danger btn-md btn-block">Clear Cart</button>
                        </a>
                    </div>
                    {{-- CONTINUE SHOPPING --}}
                    <div class="col-md-6">
                        <a href="{{ route('pages.shop') }}">
                            <button type="button" class="btn btn-outline-primary btn-md btn-block">Continue Shopping</button>
                        </a>
                    </div>
                </div>
                {{-- BUTTONS END --}}

                {{-- OVERVIEW --}}
                <table class="table table-bordered text-secondary">
                    <tr>
                        <th colspan="2" class="text-center">Overview</th>
                    </tr>
                    <tr>
                        <th>Total Items</th>
                        <td>{{ $cart->getTotalCartQty() ?? 'error' }}</td>
                    </tr>
                    <tr>
                        <th>Subtotal</th>
                        <td>&#8369;{{ $cart->getSubTotal() ?? 'error' }}</td>
                    </tr>
                    <tr>
                        <th>Requires Prescription<span class="text-danger">*</span></th>
                        <td>@if($cart->check_RX())<span class="text-danger">Yes</span> @else No @endif </td>
                    </tr>
                </table>
            </div>
            {{-- TABLE END --}}
            @if ($cart->check_RX())
                <form
                    action="{{ route('cart.prescription') }}"
                    method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card text-center">
                        <h5 class="card-header bg-success text-white">Prescription</h5>
                        <div class="card-body">
                            <h5 class="card-title">One or more of your order requires a prescription. Attach a picture of your doctor's prescription to continue</h5>
                            <div class="text-center"><span>Upload a file</span>
                                <input id="prescription_image" name="image" type="file" required>
                            </div>
                            <div class="text-center">
                                <br><br>
                                <button type="submit" class="btn btn-success btn-md">Continue Checkout</button>
                            </div>
                        </div>
                    </div>
                </form>

            @else
            <a href="{{ route('cart.discount') }}">
                <div class="text-center">
                    <br><br>
                    <button class="btn btn-success btn-md">Continue Checkout</button>
                </div>
            </a>
            @endif

    </div>
</div>

@endif
@endsection
