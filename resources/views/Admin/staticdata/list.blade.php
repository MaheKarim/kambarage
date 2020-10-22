@extends('layouts.master')
@section('content')
<div id="newapp" class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="d-inline">{{ isset($pageTitle) ? $pageTitle : trans('messages.list') }}</h3>
                <a href="{{ route('author.index') }}" class="btn btn-sm btn-primary float-right d-inline mx-1"><i class="fa fa-angle-double-left"></i> {{ trans('messages.back') }}</a>
                <a class="btn btn-sm btn-primary float-right d-inline" href="{{route('staticdata.add', [$type])}}"><i class="fa fa-plus-circle"  ></i> {{ trans('messages.add_button_form',['form' => trans('messages.'.$type)  ]) }}</a>
            </div>
            <div class="card-body">
                <div class="card-block pall-10 text-center">
                    <div>
                        <data-table class="table table-responsive-sm md-responsive" ajax="{{ route($type.'.list') }}" :columns="[
                                {data: 'DT_RowIndex', name: 'DT_RowIndex', title : '{{ trans('messages.srno') }}','orderable' : 'false' },
                                {data: 'name','name' : 'name', 'title' : '{{ trans('messages.name') }}'},
                                {data: 'action', name: 'action',title : '{{ trans('messages.action') }}',orderable : false},
                            ]">
                        </data-table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection