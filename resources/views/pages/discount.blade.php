@extends('layouts.front')

@section('content')
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
{{-- CHECKOUT --}}
<div>
    <h2 class="text-primary text-center ml-4 mt-2">Select Status</h2>
</div>
<div class="container">
    {{-- PICKUP --}}
    <div class="card">
        <h5 class="card-header bg-success text-white">Regular</h5>
        <div class="card-body text-center">
            <h5 class="card-title">Regular Customer</h5>
            <a href="{{ route('cart.checkout.regular') }}" class="btn btn-primary">Select</a>
        </div>
    </div>
    {{-- DELIVERY --}}
    <div class="card">
        <h5 class="card-header bg-info text-white">Senior/PWD</h5>
        <div class="card-body text-center">
            <h5 class="card-title">Senior/PWD Customer</h5>
            <ul>
                <li>VAT-exemption on applicable items.</li>
                <li>20% Discount</li>
                <br>
                <li>
                    Seniors and PWD must provide the following to avail their discounts.
                    <br>
                <li>Senior and PWD orders can be claimed by <span class="text-danger">legal</span> guardians</li>
                <li>Seniors must show their SCID/Government ID & Booklet.</li>
                <li>PWD must show their PWD ID.</li>
                </li>
            </ul>
            <form
                action="{{ route('cart.senior') }}"
                method="post"
                enctype="multipart/form-data">
                @csrf
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">You need to upload a picture of your government issued SCID/PWD ID</h5>
                        <div class="text-center"><span>Upload a file</span>
                            <input id="id_image" name="image" type="file" required>
                        </div>
                        <div class="text-center">
                            <br><br>
                            <button type="submit" class="btn btn-success btn-md">Select</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
