@extends('layouts.front')

@section('content')
<hr>
<div class="container bootstrap snippet">
    <div class="row">
  		<div class="col-sm-10"><h1>Edit Profile - {{ auth()->user()->name }}</h1></div>
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
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    {{ session()->get('message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Holy guacamole!</strong> You should check in on some of those fields below.
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

              
            <div class="tab-content">
                <div class="btn-group" role="group">
                    <a href="{{ route('profile.password.edit') }}"><button class="btn btn-lg btn-success" type="submit"><i class="glyphicon glyphicon-ok-sign"></i>Change Password</button></a>
                </div>
                <div class="tab-pane active" id="home">
                    <hr>
                    <form class="form" action="{{ route('profile.update') }}" method="post" id="registrationForm">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                          
                            <div class="col-xs-6">
                                <label for="first_name"><h4>First name</h4></label>
                                <input type="text" class="form-control" name="first_name" id="first_name" placeholder="enter first name..." value="{{ auth()->user()->first_name ?? '' }}">
                            </div>
                        </div>
                        <div class="form-group">
                            
                            <div class="col-xs-6">
                                <label for="last_name"><h4>Last name</h4></label>
                                <input type="text" class="form-control" name="last_name" id="last_name" placeholder="enter last name..." value="{{ auth()->user()->last_name ?? '' }}">
                            </div>
                        </div>
          
                        <div class="form-group">
                            
                            <div class="col-xs-6">
                                <label for="phone"><h4>Contact Number</h4></label>
                                <input type="text" class="form-control" name="contact" id="phone" placeholder="09XXXXXXXXX" value="{{ auth()->user()->contact ?? '' }}">
                            </div>
                        </div>
                        <div class="form-group">
                            
                            <div class="col-xs-6">
                                <label for="location"><h4>Address(House Number, Street, Barangay, City)</h4></label>
                                <input type="text" class="form-control" name="address" id="location" placeholder="enter address..." value="{{ auth()->user()->address ?? '' }}">
                            </div>
                        </div>

                        <div class="form-group">
                            
                            <div class="col-xs-6">
                                <label for="scid"><h4>SCID(Senior Citizen ID)</h4></label>
                                <input type="text" class="form-control" name="scid" id="scid" placeholder="enter scid..." value="{{ auth()->user()->scid ?? '' }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                    <br>
                                    <button class="btn btn-lg btn-success" type="submit"><i class="glyphicon glyphicon-ok-sign"></i> Save</button>
                                    <a href="{{ route('profile.index') }}"><button class="btn btn-lg btn-danger" type="button"><i class="glyphicon glyphicon-repeat"></i> Cancel</button></a>
                                </div>
                        </div>
              	    </form>
                    <hr>
                </div>

                @if (auth()->user()->id != 1)
                <div class="alert alert-danger" role="alert">
                    <h4 class="alert-heading">Deactivate Account</h4>
                    <p><strong>Warning!</strong>  This button will deactivate your account</p>
                    <hr>
                    <p class="mb-0">
                        <a href="{{ route('profile.delete.show') }}"><button class="btn btn-lg btn-danger" type="button"><i class="glyphicon glyphicon-ok-sign"></i>Permanently Delete</button></a>
                    </p>
                </div>
                @endif
            </div><!--/tab-content-->
        </div><!--/col-9-->
    </div><!--/row-->
</div>
@endsection