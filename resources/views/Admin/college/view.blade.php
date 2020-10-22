@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="card mt-3">
        <div class="card-header">
            <h3>{{ trans('messages.college') }} {{ trans('messages.description') }}:</h3>
            <a href="{{ route('college.index') }}" class="btn btn-sm btn-primary float-right d-inline"><i class="fa fa-angle-double-left"></i> {{ trans('messages.back') }}</a>
            <a href="{{route('school.student', [$college->college_id])}}"  class="btn btn-sm btn-primary float-right text-white inline ml-3">{{ trans('messages.student') }}</a>
            <a href="{{route('school.tutor', [$college->college_id])}}"  class="btn btn-sm btn-primary float-right text-white inline ml-3">{{ trans('messages.tutor') }}</a>
        </div>
        <div class="col-md-12 mb-3">
            <div class="ml-3 col-md-12 mt-3">
                <div>
                    <p><span style="font-weight: bold;">College Name</span>: {{$college->name}}</p>
                    <p><span style="font-weight: bold;">College Address</span>: {{$college->address}}</p>
                    <p><span style="font-weight: bold;">GPS Coordinates</span>: {{$college->gps}}</p>
                    <p><span style="font-weight: bold;">Country</span>: {{$college->country}}</p>
                </div>
            </div>
        </div>

        <div class="card-header">
            <h3>{{ trans('messages.subadmin') }}:</h3>
            <a id="back" href="{{route('college.addsubadmin', [$college->college_id])}}"  class="btn btn-sm btn-primary float-right text-white inline ml-3">{{ trans('messages.addsubadmin') }}</a>
        </div>
        <div class="col-md-12 mb-3">
            @foreach ($collegeAdmins AS $CA)
                <div class="ml-3 col-md-12 mt-3">
                    <div>
                        <p><span style="font-weight: bold;">User Name</span>: {{$CA->username}}</p>
                        <p><span style="font-weight: bold;">Name</span>: {{$CA->name}}</p>
                        <p><span style="font-weight: bold;">Email</span>: {{$CA->email}}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

@endsection
