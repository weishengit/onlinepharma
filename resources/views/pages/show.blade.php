@extends('layouts.front')

@section('content')
<div class="bg-light py-3">
  <div class="container">
    <div class="row">
      <div class="col-md-12 mb-0"><a href="{{ route('home') }}">Home</a> <span class="mx-2 mb-0">/</span> <a
          href="{{ route('pages.shop') }}">Store</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">{{ $product->name ?? 'Item' }}</strong></div>
    </div>
  </div>
</div>

<div class="site-section">
  <div class="container">
    <div class="row">

      {{-- Product --}}
      <div class="col-md-5 mr-auto">
        {{-- Image --}}
        <div class="border text-center">
          <img src="{{ asset('images/' . $product->image) }}" alt="Image" class="img-fluid p-5">
        </div>
      </div>
      {{-- Info --}}
      <div class="col-md-6">
        {{-- Name --}}
        <h2 class="text-black">
          {{ $product->name }}
        </h2>
        {{-- Description --}}
        <p>
          {{ $product->description }}
        </p>
        {{-- Price --}}
        <p>
          {{-- Old Price --}}
          <del>
            &#8369;{{ $product->price }}
          </del>  
          {{-- New Price --}}
          <strong class="text-primary h4">
            &#8369;{{ $product->price }}
          </strong>
        </p>

        {{-- Quantity --}}
        <div class="mb-5">
          <div class="input-group mb-3" style="max-width: 220px;">
            <div class="input-group-prepend">
              <button class="btn btn-outline-primary js-btn-minus" type="button">&minus;</button>
            </div>
            <input type="text" class="form-control text-center" value="1" placeholder=""
              aria-label="Example text with button addon" aria-describedby="button-addon1">
            <div class="input-group-append">
              <button class="btn btn-outline-primary js-btn-plus" type="button">&plus;</button>
            </div>
          </div>
        </div>
        {{-- Additional Info --}}
        <div class="row">
          <ul>
            @if ($product->category_id != null) <li>Category: {{ $product->category->name }}</li> @endif
            @if ($product->is_prescription == 1) <li>Prescription: Yes</li> @endif
            @if ($product->generic_name != null) <li>Generic Name: {{ $product->generic_name }}</li> @endif
            @if ($product->drug_class != null) <li>Drug Class: {{ $product->drug_class }}</li> @endif
            @if ($product->measurement != null) <li>Measurement: {{ $product->measurement }}</li> @endif
          </ul>
        </div>

        {{-- ADD TO CART --}}
        <p>
          <a 
            href="cart.php" 
            class="buy-now btn btn-sm height-auto px-4 py-3 btn-primary">
            Add To Cart
          </a>
        </p>

        



      </div>
    </div>
  </div>
</div>
@endsection
