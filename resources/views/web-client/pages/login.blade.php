@extends('layouts.web-client')

@section('content')
<div class="woocommerce"> 
	<div class="row mx-3 my-5">
        <form action="">
            @csrf
            <div class="col">
                <div class="row">
                    <div class="col-12 text-center" >
                        <img class="logo" src="/wp-content/logo-new.png"
                        alt="Dark Mode Logo">
                    </div>
                    <div class="col-12 text-left">
                        <p>Welcome, please enter your credentials to login</p>
                    </div>
                    <div class="col-12 form-group">
                        <input type="text" placeholder="Email.." class="form-control">
                    </div>
                    <div class="col-12 form-group">
                        <input type="passord" placeholder="Password.." class="form-control">
                    </div>
                    <div class="col-12 form-group">
                        <button type="submit" class="btn btn-custom btn-block my-3 rounded-pill" name="login" value="Log in">Log in</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
@section('page-styles')
<style>
    nav{
        display:none !important;
    }
    main{
        position:relative!important;
    }
    main>div{
        height:100% !important;
    }
    footer{
        position:fixed !important;
        bottom: 0px; 
    }
    footer h6{
        font-size: 13px !important;
    }
    .pt-fixed{
        display:block !important;
        top: 30px !important;
    }
    .logo{
        height:100px !important;
    }
</style>
@endsection