@extends('layouts.front')

@section('content')
<div class="container">
    <div class="card">
        {{-- STATUS BAR --}}
        <div class="card-header">
            Invoice
            <strong>#{{ session()->get('cart')->getRef_no() }}</strong>
            <span class="float-right"> <strong>Date: </strong>{{ session()->get('cart')->getDate() }}</span>
            <br>
            <span class="float-right"> <strong>Claim Type: {{ ucwords(session()->get('cart')->getClaim_type()) }}</strong></span>
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
                        @foreach (session()->get('cart')->getItems() as $item)
                        <tr>
                            <td class="center">{{ $item['item']['id'] }}</td>
                            <td class="left strong">{{ $item['item']['name'] }}</td>
                            <td class="left">{{ $item['item']['description'] }}</td>

                            <td class="right">{{ $item['price'] }}</td>
                            <td class="center">{{ $item['qty'] }}</td>
                            <td class="right">{{ $item['price'] * $item['qty']}}</td>
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
                                <td class="right">&#8369;{{ $cart->getTotal_vat_able() }}</td>
                            </tr>
                            <tr>
                                <td class="left"><strong>VAT Amount</strong></td>
                                <td class="right">&#8369;{{ $cart->getTotal_vat_amount() }}</td>
                            </tr>
                            <tr>
                                <td class="left"><strong>VAT Exempt</strong></td>
                                <td class="right">&#8369;{{ $cart->getTotal_vat_exempt() }}</td>
                            </tr>
                            @if ($cart->getIs_SC() == true)
                            <tr>
                                <td class="left"><strong>SC/PWD Discount</strong></td>
                                <td class="right">&#8369;{{ $cart->getSeniorDiscount() }}</td>
                            </tr>
                            @endif
                            @if ($cart->getOtherDiscount() != null)
                            <tr>
                                <td class="left"><strong>Other Discount</strong></td>
                                <td class="right">&#8369;{{ $cart->getOtherDiscount() }}</td>
                            </tr>
                            @endif
                            @if ($cart->getClaim_type() == 'delivery')
                            <tr>
                                <td class="left"><strong>Delivery Fee</strong></td>
                                <td class="right">&#8369;{{ $cart->getDeliveryFee() }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td class="left"><strong>Total</strong></td>
                                <td class="right">&#8369;{{ $cart->final_price() }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <form
                action="{{ route('cart.confirm') }}"
                method="post">
                @csrf
                <div class="text-center">
                    <br><br>
                    <button type="submit" class="btn btn-success btn-md">Submit Order</button>
                </div>
            </form>
            <a href="{{ route('cart.clear') }}">
                <div class="text-center">
                    <br><br>
                    <button type="submit" class="btn btn-danger btn-md">Start Over</button>
                </div>
            </a>
        </div>
    </div>
</div>

@endsection

