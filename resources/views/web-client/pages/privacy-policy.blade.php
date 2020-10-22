@extends('layouts.web-client')

@section('content')

<div id="page-content-wrapper">
	<div class="col-12 my-3">
        <div class="">
            <h3>Privacy policy</h3>
            <p>{!!  nl2br($privacy_policy_data->value??"") !!}</p>
        </div>
    </div>
</div>
@endsection