@extends('layouts.front')

@section('content')
{{-- CHECKOUT --}}
<div>
    <h2 class="text-primary text-center ml-4 mt-2">Checkout Method</h2>
</div>
<div class="container">
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
            <div class="text-center">
                <a href="{{ route('cart.pickup') }}" class="btn btn-primary">Pick Up Order In Store</a>
            </div>
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
            <div class="text-center">
                <a href="{{ route('cart.delivery') }}" class="btn btn-primary">Deliver To My Address</a>
            </div>
        </div>
    </div>
</div>
{{-- CHECKOUT --}}
@endsection
