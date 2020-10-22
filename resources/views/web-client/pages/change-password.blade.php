@extends('layouts.web-client')

@section('content')

<div id="page-content-wrapper">
	<div class="col-12 my-3">
        <div class="">
            <h3>Change your password</h3>
            @if(session('success'))
                <div class="row">
                    <div class="col-md-6">
                        <p id="change-password-success">{{session('success')}}</p>
                    </div>
                </div>
            @endif
            <form action="{{route('web-client.store-new-password')}}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <label for="">Enter new password:</label>
                        <input type="password" name="password" id="" class='form-control'>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="">Confirm new password:</label>
                        <input type="password" name="password_confirmation" id="" class='form-control'>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button class="btn btn-primary" onclick="return confirm('Are you sure you want to change your password?');">Save</button>                    
                    </div>
                </div>
                <div class="row">
                    @if($errors->all())
                    <div class="col-md-6" id="change-password-errors">
                        @foreach($errors->all() as $error)
                            <p>{{$error}}</p>
                        @endforeach
                    </div>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
@endsection