@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="card mt-3">
        <div class="card-header">
            <h3>{{ trans('messages.college') }} {{ trans('messages.description') }}:</h3>

            <a href="{{ route('school.show', ['id' => $college->college_id]) }}" class="btn btn-sm btn-primary float-right d-inline"><i class="fa fa-angle-double-left"></i> {{ trans('messages.back') }}</a>

            <a href="{{route('school.student', [$college->college_id])}}"  class="btn btn-sm btn-primary float-right text-white inline ml-3">{{ trans('messages.student') }}</a>
            <a href="{{route('school.tutor', [$college->college_id])}}"  class="btn btn-sm btn-primary float-right text-white inline ml-3">{{ trans('messages.tutor') }}</a>
        </div>
        <div class="col-md-12 mb-3">
            <div class="ml-3 col-md-12 mt-3">
                    <a href="{{route('school.edit', [$college->college_id])}}"  class="btn btn-sm btn-primary float-right text-white inline ml-3">{{ trans('messages.edit') }} {{ trans('messages.college') }}</a>
                <div>
                    <p>College Name: {{$college->name}}</p>
                    <p>College Address: {{$college->address}}</p>
                    <p>GPS Coordinates: {{$college->gps}}</p>
                    <p>Country: {{$college->country}}</p>
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
                @if(Auth::user()->id === $CA->id)        
                    <a href="{{route('subadmin.settings')}}"  class="btn btn-sm btn-primary float-right text-white inline ml-3">{{ trans('messages.edit') }} {{ trans('messages.profile') }}</a>
                @endif
                    <div>
                        <h4>User Name: {{$CA->username}}</h4>
                        <h4>Name: {{$CA->name}}</h4>
                        <h4>Email: {{$CA->email}}</h4>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

@endsection
