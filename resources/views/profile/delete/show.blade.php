@extends('layouts.front')

@section('content')
<hr>
<div class="container bootstrap snippet">
    <div class="row">
  		<div class="col-sm-10"><h1>Delete Account</h1></div>
    </div>
    <br>
    <div class="row">
  		
                <div class="alert alert-danger" role="alert">
                    <h4 class="alert-heading">Delete Account</h4>
                    <p><strong>Warning!</strong>  This button will deactivate your account</p>
                    <hr>
                    <p class="mb-0">
                        <div class="btn-group" role="group">
                        <form action="{{ route('profile.delete.show') }}" method="post">
                            @csrf
                            @method('delete')
                            <button class="btn btn-lg btn-danger" type="submit"><i class="glyphicon glyphicon-ok-sign"></i>Deactivate</button>
                        </form>
                        </div>
                        <div class="btn-group" role="group">
                            <a href="{{ route('profile.index') }}"><button class="btn btn-lg btn-success" type="submit"><i class="glyphicon glyphicon-ok-sign"></i>Go Back</button></a>
                        </div>
                    </p>
                </div>
            
    </div><!--/row-->
</div>

@endsection