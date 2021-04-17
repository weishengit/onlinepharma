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

                        @foreach ($cart->items as $item)
                        <tr>
                            <td class="product-thumbnail">
                            <img src="{{ asset('images/' . $item['item']->image) }}" alt="Image" class="img-fluid">
                            </td>
                            <td class="product-name">
                            <h2 class="h5 text-black">{{ $item['item']['name'] }}</h2>
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
                        <td>&#8369;{{ number_format($cart->getSubTotal(), 2) ?? 'error' }}</td>
                    </tr>
                </table>
            </div>
            {{-- TABLE END --}}

            {{-- CHECKOUT --}}
            <div>
                <h2 class="text-primary text-center ml-4 mt-2">Checkout Method</h2>
            </div>
            {{-- PICKUP --}}
            <div class="card">
                <h5 class="card-header bg-success text-white">Pick Up</h5>
                <div class="card-body">
                    <h5 class="card-title">Get From Store</h5>
                    <ul>
                        <li>Pick up your order from the store.</li>
                        <li>Can be picked-up during bussiness hours.</li>
                        <li>You are <span class="text-danger">required</span> bring your doctor's prescription if any of your order requires prescription.</li>
                        <br>
                        <li>
                            Seniors and PWD must provide the following to avail their discounts.
                            <ul>
                                <li>Senior and PWD orders can be claimed by <span class="text-danger">legal</span> caretakers.</li>
                                <li>Seniors must bring their SCID/Government ID & Booklet.</li>
                                <li>PWD must bring their PWD ID.</li>
                            </ul>
                        </li>
                    </ul>
                    <a href="#" class="btn btn-primary">Pick Up Order In Store</a>
                </div>
            </div>
            {{-- DELIVERY --}}
            <div class="card">
                <h5 class="card-header bg-info text-white">Delivery</h5>
                <div class="card-body">
                    <h5 class="card-title">Deliver To Your Address</h5>
                    <ul>
                        <li>Deliver order to your address.</li>
                        <li>Can be delivered during bussiness hours.</li>
                        <li>You are <span class="text-danger">required</span> present your doctor's prescription if any of your order requires prescription to the courier.</li>
                        <br>
                        <li>
                            Seniors and PWD must provide the following to avail their discounts.
                            <ul>
                                <li>Senior and PWD orders can be claimed by <span class="text-danger">legal</span> guardians</li>
                                <li>Seniors must bring their SCID/Government ID & Booklet.</li>
                                <li>PWD must bring their PWD ID.</li>
                            </ul>
                        </li>
                    </ul>
                    <a href="#" class="btn btn-primary">Deliver To My Address</a>
                </div>
            </div>
        {{-- CHECKOUT --}}
    </div>
</div>

@endif
@endsection
