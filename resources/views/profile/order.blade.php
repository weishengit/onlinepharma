@extends('layouts.front')

@section('content')
<div class="container">
    <div class="card">
        {{-- STATUS BAR --}}
        <div class="card-header">
            Invoice
            <strong>#{{ $order->ref_no }}</strong>
            <span class="float-right"> <strong>Date: </strong>{{ $order->date }}</span>
            <br>
            <span class="float-right"> <strong>Claim Type: {{ ucwords($order->claim_type) }}</strong></span>
            <br>
            <span class="float-right"> <strong>Status: </strong>Pending</span>
        </div>
        {{-- HEADER --}}
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-sm-6">
                    <h6 class="mb-3">From:</h6>
                    <div><strong>{{ $order->cashier }}</strong></div>
                    <div>Cabanatuan City</div>
                    <div>Email: shop@onlinepharma.com</div>
                    <div>Contact: +64 444 666 3333</div>
                </div>
                <div class="col-sm-6">
                    <h6 class="mb-3">To:</h6>
                    <div><strong>{{ $order->customer }}</strong></div>
                    <div>{{ $order->address }}</div>
                    <div>Email: {{ $order->user->email }}</div>
                    <div>Phone: {{ $order->user->contact }}</div>
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
                        @foreach ($items as $item)
                        <tr>
                            <td class="center">{{ $item->id }}</td>
                            <td class="left strong">{{ $item->name }}</td>
                            <td class="left">{{ $item->description }}</td>

                            <td class="right">{{ $item->price }}</td>
                            <td class="center">{{ $item->quantity }}</td>
                            <td class="right">{{ $item->total_price }}</td>
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
                                <td class="right">&#8369;{{ $order->subtotal }}</td>
                            </tr>
                            <tr>
                                <td class="left"><strong>Vatable</strong></td>
                                <td class="right">&#8369;{{ $order->vatable_sale }}</td>
                            </tr>
                            <tr>
                                <td class="left"><strong>VAT Amount</strong></td>
                                <td class="right">&#8369;{{ $order->vat_amount }}</td>
                            </tr>
                            <tr>
                                <td class="left"><strong>VAT Exempt</strong></td>
                                <td class="right">&#8369;{{ $order->vat_exempt }}</td>
                            </tr>
                            @if ($order->is_sc == true)
                            <tr>
                                <td class="left"><strong>SC/PWD Discount(20%)</strong></td>
                                <td class="right">&#8369;{{ $order->sc_discount }}</td>
                            </tr>
                            @endif
                            @if ($order->other_discount != null)
                            <tr>
                                <td class="left"><strong>Other Discount</strong></td>
                                <td class="right">&#8369;{{ $order->other_discount }} - {{ $order->other_discount_rate }}</td>
                            </tr>
                            @endif
                            @if ($order->delivery_mode == 'delivery')
                            <tr>
                                <td class="left"><strong>Delivery Fee</strong></td>
                                <td class="right">&#8369;{{ $order->delivery_fee }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td class="left"><strong>Total</strong></td>
                                <td class="right">&#8369;{{ $order->amount_due }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <a href="{{ route('profile.orders') }}">
                <div class="text-center">
                    <br><br>
                    <button type="submit" class="btn btn-primary btn-md">Done</button>
                </div>
            </a>
            <a href="#">
                <div class="text-center">
                    <br>
                    <button class="btn btn-success btn-md">Download PDF</button>
                </div>
            </a>
        </div>
    </div>
</div>

@endsection

