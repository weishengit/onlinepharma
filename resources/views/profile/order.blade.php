@extends('layouts.front')

@section('style')
<style>
    .card {
    position: relative;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 1px solid rgba(0, 0, 0, 0.1);
    border-radius: 0.10rem
}

.card-header:first-child {
    border-radius: calc(0.37rem - 1px) calc(0.37rem - 1px) 0 0
}

.card-header {
    padding: 0.75rem 1.25rem;
    margin-bottom: 0;
    background-color: #fff;
    border-bottom: 1px solid rgba(0, 0, 0, 0.1)
}

.track {
    position: relative;
    background-color: #ddd;
    height: 7px;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    margin-bottom: 60px;
    margin-top: 50px
}

.track .step {
    -webkit-box-flex: 1;
    -ms-flex-positive: 1;
    flex-grow: 1;
    width: 25%;
    margin-top: -18px;
    text-align: center;
    position: relative
}

.track .step.active:before {
    background: #FF5722
}

.track .step::before {
    height: 7px;
    position: absolute;
    content: "";
    width: 100%;
    left: 0;
    top: 18px
}

.track .step.active .icon {
    background: #ee5435;
    color: #fff
}

.track .icon {
    display: inline-block;
    width: 40px;
    height: 40px;
    line-height: 40px;
    position: relative;
    border-radius: 100%;
    background: #ddd
}

.track .step.active .text {
    font-weight: 400;
    color: #000
}

.track .text {
    display: block;
    margin-top: 7px
}
</style>
@endsection

@section('content')
<div class="container">
    @if ($order->is_void != 1)
        <?php
            $status = 0;
            switch ($order->status) {
                case 'void':
                    $status = 0;
                    break;
                case 'new':
                    $status = 1;
                    break;
                case 'pending':
                    $status = 2;
                    break;
                case 'dispatched':
                    $status = 3;
                    break;
                case 'completed':
                    $status = 4;
                    break;
                default:
                    $status = 0;
                    break;
            }
        ?>
        {{-- TRACKING --}}
        <div class="card">
            <div class="card-body row">
                <div class="col"> <strong>Estimated Delivery time:</strong> <br> {{ $order->estimated_dispatch_date ?? 'None' }} </div>
                <div class="col"> <strong>Status:</strong> <br> {{ $order->message }} </div>
            </div>
        </div>
        @if ($order->delivery_mode == 'delivery')
        <div class="track">
            <div class="step @if ($status >= 1) active @endif">
                <span class="icon icon-shopping-bag"></span>
                <span class="text">Order Placed</span>
            </div>
            <div class="step @if ($status >= 2) active @endif">
                <span class="icon icon-check"></span>
                <span class="text">Order confirmed</span>
            </div>
            <div class="step @if ($status >= 3) active @endif">
                <span class="icon icon-truck"></span>
                <span class="text"> On the way </span>
            </div>
            <div class="step @if ($status == 4) active @endif">
                <span class="icon icon-star"> </span>
                <span class="text">Completed</span>
            </div>
        </div>
        @endif
        @if ($order->delivery_mode == 'pickup')
        <div class="track">
            <div class="step @if ($status >= 1) active @endif">
                <span class="icon icon-shopping-bag"></span>
                <span class="text">Order Placed</span>
            </div>
            <div class="step @if ($status >= 2) active @endif">
                <span class="icon icon-check"></span>
                <span class="text">Order confirmed</span>
            </div>
            <div class="step @if ($status >= 3) active @endif">
                <span class="icon icon-shopping-basket"></span>
                <span class="text">Ready for pickup</span>
            </div>
            <div class="step @if ($status == 4) active @endif">
                <span class="icon icon-star"></span>
                <span class="text">Completed</span>
            </div>
        </div>
        @endif
    @else
    <div class="card">
        <div class="card-body row">
            <div class="col"> <strong>Estimated Delivery time:</strong> <br> None </div>
            <div class="col"> <strong>Status:</strong> <br> {{ ucwords($order->message) }}</div>
        </div>
    </div>
    <div class="track">
        <div class="step active">
            <span class="icon icon-close"></span>
            <span class="text">Order {{ ucwords($order->status) }}</span>
        </div>
    </div>
    @endif

    <br class="mb-10">
    <div class="card">
        {{-- STATUS BAR --}}
        <div class="card-header">
            Invoice
            <strong>#{{ $order->ref_no }}</strong>
            <span class="float-right"> <strong>Date: </strong>{{ $order->created_at }}</span>
            <br>
            <span class="float-right"> <strong>Claim Type: {{ ucwords($order->delivery_mode) }}</strong></span>
            <br>
            <span class="float-right"> <strong>Status: </strong>{{ ucwords($order->status) }}</span>
        </div>
        {{-- HEADER --}}
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-sm-6">
                    <h6 class="mb-3">From:</h6>
                    <div><strong>{{ $settings->name }}</strong></div>
                    <div>{{ $settings->address }}</div>
                    <div>Email: {{ $settings->email }}</div>
                    <div>Contact: {{ $settings->contact }}</div>
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
                    <br>
                    <button type="submit" class="btn btn-primary btn-md">Back</button>
                </div>
            </a>
            @if ($order->is_void != 1 && $order->status != 'completed')
            <form action="{{ route('profile.cancel', ['order' => $order->id]) }}" method="post">
                @csrf
                @method('delete')
                <div class="text-center">
                    <br>
                    <button type="submit" class="btn btn-danger btn-md">Cancel Order</button>
                </div>
            </form>
            @endif
            {{-- <a href="#">
                <div class="text-center">
                    <br>
                    <button class="btn btn-success btn-md">Download PDF</button>
                </div>
            </a> --}}
        </div>
    </div>
</div>

@endsection

