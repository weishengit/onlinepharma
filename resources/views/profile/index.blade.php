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
   
            <ul class="list-group">
                <li class="list-group-item text-muted">Order Activity <i class="fa fa-dashboard fa-1x"></i></li>
                <li class="list-group-item text-left">Order# 20203234</li>
                <li class="list-group-item text-left">Order# 20203234</li>
                <li class="list-group-item text-left">Order# 20203234</li>
                <li class="list-group-item text-left">Order# 20203234</li>
            </ul> 
            
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
                @if (auth()->user()->is_admin == 1)
                    <div class="btn-group float-right" role="group">
                        <a href="{{ route('admin.index') }}"><button class="btn btn-lg btn-primary" type="submit"><i class="glyphicon glyphicon-ok-sign"></i>Admin</button></a>
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