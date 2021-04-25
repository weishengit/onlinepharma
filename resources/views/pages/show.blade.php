@extends('layouts.front')

@section('content')
<div class="bg-light py-3">
  <div class="container">
    <div class="row">

      <div class="col-md-12 mb-0">
        <a href="{{ route('home') }}">Home</a>
          <span class="mx-2 mb-0">/</span>
        <a href="{{ route('pages.shop') }}">Store</a>
          <span class="mx-2 mb-0">/</span> <strong class="text-black">{{ $product->name ?? 'Item' }}</strong>
      </div>

    </div>

    @if (isset($message))
      <div class="alert alert-warning alert-dismissible fade show" role="alert">
          {{ $message }}
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
  </div>
</div>
<form
      method="post"
      action="{{ route('cart.add', ['id' => $product->id, 'rx' => $product->is_prescription]) }}">
      @csrf
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
            <input name="quantity" type="text" min="1" class="form-control text-center" value="1" placeholder=""
              aria-label="Example text with button addon" aria-describedby="button-addon1">
            <div class="input-group-append">
              <button class="btn btn-outline-primary js-btn-plus" type="button">&plus;</button>
            </div>
          </div>
        </div>
        {{-- Additional Info --}}
        <div class="row">
          <ul class="text-secondary">
            {{-- CATEGORY --}}
            @if ($product->category_id != null)
                <li>Category: {{ $product->category->name }}</li>
            @else
                <li>Category: None</li>
            @endif
            {{-- PRESCRIPTIONJ --}}
            @if ($product->is_prescription == 1)
                <li>Prescription: <span class="text-danger">Yes</span> </li>
            @else
                <li>Prescription: No</li>
            @endif
            {{-- GENERIC NAME --}}
            @if ($product->generic_name != null)
                <li>Generic Name: {{ $product->generic_name }}</li>
            @endif
            {{-- DRUG CLASS --}}
            @if ($product->drug_class != null)
                <li>Drug Class: {{ $product->drug_class }}</li>
            @endif
            {{-- MEASUREMENT --}}
            @if ($product->measurement != null)
                <li>Measurement: {{ $product->measurement }}</li>
            @endif
          </ul>
        </div>

        {{-- ADD TO CART --}}
        <span>
          <button
            type="submit"
            class="buy-now btn btn-sm height-auto px-4 py-3 btn-primary">
            Add To Cart
          </button>
        </span>
        <span>
            <a
                href="{{ route('pages.shop') }}">
                <button
                    type="button"
                    class="buy-now btn btn-sm height-auto px-4 py-3 btn-info">
                    Continue Shopping
                </button>
            </a>
          </span>

      </div>
    </div>
  </div>
</form>
</div>
@endsection
