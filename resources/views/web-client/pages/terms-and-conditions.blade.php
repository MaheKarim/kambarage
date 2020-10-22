@extends('layouts.web-client')

@section('content')
<div id="page-content-wrapper">
	<div class="col-12 my-3">
        <div class=""> 
            <h3>Terms and conditions</h3> 
            <p>{!!  nl2br($term_condition_data->value??"") !!}</p>
        </div>
    </div>
</div>
@endsection