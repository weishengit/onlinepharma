@extends('layouts.front')

@section('content')
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

<div class="container">
  <div class="tab-content">
    <div class="tab-pane active" id="home">
      <hr>
      <form action="{{ route('profile.password.edit') }}" method="post">
        @csrf
        @method('PUT')
          <div class="form-group">
            <label for="password">New Password</label>
            <input type="password" name="password" class="form-control" id="password" aria-describedby="passwordHelp" placeholder="Enter New Password...">
            <small id="passwordHelp" class="form-text text-muted">Please use a strong password.</small>
          </div>
          <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="Confirm New Password...">
          </div>
          <button type="submit" class="btn btn-success">Submit</button>
          <a href="{{ route('profile.index') }}"><button type="button" class="btn btn-danger">Cancel</button></a>
      </form>
      <hr>
    </div>
  </div><!--/tab-content-->
</div><!--/col-9-->
@endsection