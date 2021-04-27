@extends('layouts.front')

@section('content')
<div class="container text-center"><!--left col-->
    {{-- NEW --}}
    <h2 class="tex-center">Pending Orders</h2>
    <ul class="list-group">
        @foreach ($new_orders as $new_order)
        <a href="{{ route('profile.order', ['order' => $new_order->id]) }}">
            <li class="list-group-item text-center text-success">ID: {{ $new_order->id }} - {{ $new_order->created_at }}</li>
        </a>
        @endforeach
    </ul>

    <br>
    {{-- OLD --}}
    <h2 class="tex-center">Old Orders</h2>
    <ul class="list-group">
        @foreach ($old_orders as $old_order)
        <a href="{{ route('profile.order', ['order' => $old_order->id]) }}">
            <li class="list-group-item text-center">ID: {{ $old_order->id }} - {{ $old_order->created_at }}</li>
        </a>
        @endforeach
    </ul>
</div><!--/col-3-->
@endsection
