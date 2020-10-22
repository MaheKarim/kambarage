@extends('layouts.master')
@section('content')
<div id="newapp" class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="d-inline">{{ isset($pageTitle) ? $pageTitle : trans('messages.list') }}</h3>
                <a href="{{ route((Auth::user()->role_id === 1) ? 'college.show' : 'school.show', ['id' => $college_id]) }}" class="btn btn-sm btn-primary float-right d-inline"><i class="fa fa-angle-double-left"></i> {{ trans('messages.back') }}</a>
                <a href="{{ route('tutor.create', [$college_id]) }} " class="btn btn-sm float-right btn-primary"><i class="fa fa-plus-circle"  ></i> {{ trans('messages.add_button_form',['form' => trans('messages.tutor')  ]) }}</a>
                <a href="{{ route('tutor.import.form', [$college_id]) }} " class="btn btn-sm float-right btn-primary"><i class="fa fa-plus-circle"  ></i> {{ trans('messages.import_button_form',['form' => trans('messages.tutor')  ]) }}</a>
            </div>
            <div class="card-body">
                <div class="card-block pall-10 text-center">
                    <div>
                        <data-table class="table table-responsive-sm md-responsive" ajax="{{ route('tutor.list', [$college_id]) }}" :columns="[
                                {data: 'DT_RowIndex', name: 'DT_RowIndex', title : '{{ trans('messages.srno') }}','orderable' : 'false' },
                                {data: 'name','name' : 'name', 'title' : '{{ trans('messages.name') }}'},
                                {data: 'email','name' : 'email', 'title' : '{{ trans('messages.email') }}'},
                                {data: 'contact_no','name' : 'contact_no', 'title' : '{{ trans('messages.contact_no') }}'},
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
@section('body_bottom')
<script>
    $(document).ready(function(){
        $('.college-list-item').addClass('active');
    });
</script>
@endsection