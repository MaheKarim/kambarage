@extends('layouts.master')

@section('content')
<div class="col-md-6 offset-md-3">
    <div class="card">
        <div class="card-header">
            <h3 class="d-inline">{{ isset($pageTitle) ? $pageTitle : trans('messages.list') }}</h3>
            <a href="{{ route('school.student', [$college_id]) }}" class="btn btn-sm btn-primary float-right d-inline"><i class="fa fa-angle-double-left"></i> {{ trans('messages.back') }}</a>
        </div>
        <div class="card-block pall-10">
            <p><span>Your Excel/CSV file should contain 5 colums, arranged in the following order:<br>
                Name, email, Registration Number, contact Number, password
             </span></p>
            <p><span>DO NOT HAVE A HEADER/HEADING ON YOUR IMPORT FILE</span></p>
            <form method="POST" enctype="multipart/form-data" action="{{ route('student.import', [$college_id]) }}">
            {{ csrf_field() }}

                <input type="hidden" name="college_id" value="{{$college_id}}">
                <div class="form-group">
                    <input id="file" type="file" class="form-control-file" name="file" required>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-block btn-primary mt-4">Import file</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
