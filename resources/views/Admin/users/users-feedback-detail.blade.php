@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="card mt-3">
        <div class="card-header">
            <h3>{{ trans('pageTitle') }}:
                <a href="{{ route('users_feedback') }}" class="btn btn-sm btn-primary float-right d-inline"><i class="fa fa-angle-double-left"></i> {{ trans('messages.back') }}</a>
            </h3>
        </div>
        <div class="col-md-12 mb-3">
            <div class="ml-3 col-md-12 mt-3">
                <div>
                    <p>User Name: {{$feedback->name}}</p>
                    <p>User Email: {{$feedback->email}}</p>
                    <p>User Mobile: {{$feedback->contact_number}}</p>
                    <p>User Type: {{$user_role}}</p>
                    <p>College: {{$college}}</p>
                </div>
            </div>
        </div>

        <div class="card-header">
            <h3>{{trans('messages.users_feedback')." ".trans('comment')}}:</h3>
            <div>
                {{$feedback->comment}}
            </div>
        </div>
    </div>
</div>

@endsection
