@extends('layouts.front')

@section('content')
<div class="container">
    <div class="card">
        {{-- STATUS BAR --}}
        <div class="card-header">
            Invoice
            <strong>#</strong>
            <span class="float-right"> <strong>Date: </strong>{{ session()->get('cart')->date }}</span>
            <br>
            <span class="float-right"> <strong>Status: </strong>Pending</span>
        </div>
        {{-- HEADER --}}
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-sm-6">
                    <h6 class="mb-3">From:</h6>
                    <div><strong>{{ env('APP_NAME') ?? Store }}</strong></div>
                    <div>Cabanatuan City</div>
                    <div>Email: shop@onlinepharma.com</div>
                    <div>Contact: +64 444 666 3333</div>
                </div>
                <div class="col-sm-6">
                    <h6 class="mb-3">To:</h6>
                    <div><strong>{{ auth()->user()->first_name . ' ' . auth()->user()->last_name }}</strong></div>
                    <div>{{ auth()->user()->address }}</div>
                    <div>Email: {{ auth()->user()->email }}</div>
                    <div>Phone: {{ auth()->user()->contact }}</div>
                </div>
            </div>
            {{-- TABLE --}}
            <div class="table-responsive-sm">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="center">#</th>
                            <th>Item</th>
                            <th>Description</th>

                            <th class="right">Unit Cost</th>
                            <th class="center">Qty</th>
                            <th class="right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (session()->get('cart')->items as $item)
                        <tr>
                            <td class="center">{{ $item['item']['id'] }}</td>
                            <td class="left strong">{{ $item['item']['name'] }}</td>
                            <td class="left">{{ $item['item']['description'] }}</td>

                            <td class="right">{{ $item['item']['price'] }}</td>
                            <td class="center">{{ $item['qty'] }}</td>
                            <td class="right">{{ $item['item']['price'] * $item['qty']}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-lg-4 col-sm-5"></div>
                {{-- DETAIL --}}
                <div class="col-lg-4 col-sm-5 ml-auto">
                    <table class="table table-clear">
                        <tbody>
                            <tr>
                                <td class="left"><strong>Subtotal</strong></td>
                                <td class="right">&#8369;{{ $cart->getSubtotal() }}</td>
                            </tr>
                            <tr>
                                <td class="left"><strong>Vatable</strong></td>
                                <td class="right">&#8369;{{ $cart->total_vat_able }}</td>
                            </tr>
                            <tr>
                                <td class="left"><strong>VAT Amount</strong></td>
                                <td class="right">&#8369;{{ $cart->total_vat_amount}}</td>
                            </tr>
                            <tr>
                                <td class="left"><strong>VAT Exempt</strong></td>
                                <td class="right">&#8369;{{ $cart->total_vat_exempt }}</td>
                            </tr>
                            <tr>
                                <td class="left"><strong>SC/PWD Discount</strong></td>
                                <td class="right">&#8369;{{ $cart->seniorDiscount }}</td>
                            </tr>
                            <tr>
                                <td class="left"><strong>Other Discount</strong></td>
                                <td class="right">&#8369;{{ $cart->otherDiscount }}</td>
                            </tr>
                            @if ($cart->is_delivery == true)
                            <tr>
                                <td class="left"><strong>Other Discount</strong></td>
                                <td class="right">&#8369;{{ $cart->deliveryFee }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td class="left"><strong>Total</strong></td>
                                <td class="right">&#8369;{{ $cart->getTotal() }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <a href="{{ route('cart.discount') }}">
                <div class="text-center">
                    <br><br>
                    <button class="btn btn-success btn-md">Complete Order</button>
                </div>
            </a>
        </div>
    </div>
</div>

@endsection

