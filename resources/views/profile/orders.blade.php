@extends('layouts.front')

@section('content')
    {{-- NEW --}}
    <div class="card ml-5 mr-5">
        <div class="card-header">
            Active Orders
        </div>
        <ul class="list-group list-group-flush">
            @foreach ($new_orders as $new_order)
                <a href="{{ route('profile.order', ['order' => $new_order->id]) }}">
                @if ($new_order->status == 'void')
                    <li class="list-group-item border text-danger">
                @elseif ($new_order->status == 'pending')
                    <li class="list-group-item border text-success">
                @elseif ($new_order->status == 'completed')
                    <li class="list-group-item border text-info">
                @else
                    <li class="list-group-item border text-dark">
                @endif
                    Ref: {{ $new_order->ref_no }}
                        <br>
                        <strong>Date: {{ $new_order->created_at }}</strong>
                        <span class="float-right">
                            {{ $new_order->status }}
                        </span>
                    </li>
                </a>
            @endforeach
        </ul>
      </div>

    <br>
    {{-- OLD --}}
    <div class="card ml-5 mr-5">
        <div class="card-header">
            Archived Orders
        </div>
        <ul class="list-group list-group-flush">

            @foreach ($old_orders as $old_order)
            <a href="{{ route('profile.order', ['order' => $old_order->id]) }}">
                @if ($old_order->status == 'void' || $old_order->status == 'returned')
                    <li class="list-group-item border text-danger">
                @elseif ($old_order->status == 'pending')
                    <li class="list-group-item border text-success">
                @elseif ($old_order->status == 'completed')
                    <li class="list-group-item border text-info">
                @else
                    <li class="list-group-item border text-dark">
                @endif
                    Ref: {{ $old_order->ref_no }}
                    <br>
                    <strong>Date: {{ $old_order->created_at }}</strong>
                    <span class="float-right">
                        Status: {{ $old_order->status }}
                    </span>
                </li>
            </a>
            @endforeach
        </ul>
      </div>


</div><!--/col-3-->
@endsection
