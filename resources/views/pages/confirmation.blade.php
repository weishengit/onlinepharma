@extends('layouts.front')

@section('content')
<div class="container">
    {{-- PICKUP --}}
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Success!</h5>
            <h6>Your order has been placed.</h6>
            <div class="text-center">
                <a href="{{ route('home') }}" class="btn btn-primary">OK</a>
            </div>
        </div>
    </div>
</div>
@endsection
