@extends('layouts.front')

@section('content')
<hr>
<div class="container bootstrap snippet">
    <div class="row">
  		<div class="col-sm-10">
              <h1>Profile - {{ auth()->user()->name }}</h1>
        </div>
    </div>
    <br>
    <div class="row">
  		<div class="col-sm-3"><!--left col-->

            {{-- ORDERS --}}
            <a href="{{ route('profile.orders') }}">
                <ul class="list-group">
                        <li class="list-group-item text-muted">View Order Activity <i class="fa fa-dashboard fa-1x"></i></li>
                    @if (isset($orders))
                        @foreach ($orders as $order)
                            <li class="list-group-item text-left">#{{ $order->ref_no }}</li>
                        @endforeach
                    @else
                        <li class="list-group-item text-center">No Orders Yet</li>
                    @endif
                </ul>
            </a>
        </div><!--/col-3-->
    	<div class="col-sm-9">
            @if (session()->has('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> {{ session()->get('message') }}.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif


            <div class="tab-content">

                <div class="btn-group" role="group">
                    <a href="{{ route('profile.edit') }}"><button class="btn btn-lg btn-success" type="submit"><i class="glyphicon glyphicon-ok-sign"></i>Edit</button></a>
                </div>
                <div class="btn-group" role="group">
                    <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-lg btn-danger">Logout</button>
                  </form>
                </div>
                {{-- ADMIN CHECK --}}
                @if (auth()->user()->role->role_name == 'admin' || auth()->user()->role->role_name == 'manager')
                    <div class="btn-group float-right" role="group">
                        <a href="{{ route('admin.index') }}"><button class="btn btn-lg btn-primary" type="button"><i class="glyphicon glyphicon-ok-sign"></i>Admin</button></a>
                    </div>
                @endif
                {{-- PHARMACIST CHECK --}}
                @if (auth()->user()->role->role_name == 'pharmacist' || auth()->user()->role->role_name == 'manager' || auth()->user()->role->role_name == 'admin')
                    <div class="btn-group float-right" role="group">
                        <a href="{{ route('admin.pharmacist.index') }}"><button class="btn btn-lg btn-info" type="button"><i class="glyphicon glyphicon-ok-sign"></i>Pharmacist</button></a>
                    </div>
                @endif
                {{-- CASHIER CHECK --}}
                @if (auth()->user()->role->role_name == 'cashier' || auth()->user()->role->role_name == 'manager' || auth()->user()->role->role_name == 'admin')
                    <div class="btn-group float-right" role="group">
                        <a href="{{ route('admin.cashier.index') }}"><button class="btn btn-lg btn-success" type="button"><i class="glyphicon glyphicon-ok-sign"></i>Cashier</button></a>
                    </div>
                @endif

                <div class="tab-pane active" id="home">
                    <hr>
                        <div class="form-group">

                            <div class="col-xs-6">
                                <label for="first_name"><h4>User Name:</h4></label>
                                <h5 class="border border-light">{{ auth()->user()->name ?? '' }}</h5>
                            </div>
                        </div>
                    <br>
                        <div class="form-group">

                            <div class="col-xs-6">
                                <label for="first_name"><h4>First Name:</h4></label>
                                <h5 class="border border-light">{{ auth()->user()->first_name ?? '' }}</h5>
                            </div>
                        </div>
                    <br>
                        <div class="form-group">

                            <div class="col-xs-6">
                                <label for="last_name"><h4>Last Name:</h4></label>
                                <h5 class="border border-light">{{ auth()->user()->last_name ?? '' }}</h5>
                            </div>
                        </div>
                    <br>
                        <div class="form-group">

                            <div class="col-xs-6">
                                <label for="phone"><h4>Contact Number:</h4></label>
                                <h5 class="border border-light">{{ auth()->user()->contact ?? '' }}</h5>
                            </div>
                        </div>
                    <br>
                        <div class="form-group">

                            <div class="col-xs-6">
                                <label for="email"><h4>Email:</h4></label>
                                <h5 class="border border-light">{{ auth()->user()->email ?? ''}}</h5>
                            </div>
                        </div>
                        <div class="form-group">
                    <br>
                            <div class="col-xs-6">
                                <label for="email"><h4>Address(House Number, Street, Barangay, City)</h4></label>
                                <h5 class="border border-light bg-light">{{ auth()->user()->address ?? '' }}</h5>
                            </div>
                        </div>
                    <br>
                        <div class="form-group">

                            <div class="col-xs-6">
                                <label for="scid"><h4>SCID:</h4></label>
                                <h5 class="border border-light">{{ auth()->user()->scid ?? ''}}</h5>
                            </div>
                        </div>
                    <hr>
                </div>
            </div><!--/tab-content-->
        </div><!--/col-9-->
    </div><!--/row-->
</div>

@endsection
