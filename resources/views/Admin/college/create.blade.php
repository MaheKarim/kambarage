@extends('layouts.master')

@section('content')
<div class="col-md-6 offset-md-3">
    <div class="card">
        <div class="card-header">
            <h3 class="d-inline">{{ isset($pageTitle) ? $pageTitle : trans('messages.list') }}</h3>
            <a href="{{ route('college.index') }}" class="btn btn-sm btn-primary float-right d-inline"><i class="fa fa-angle-double-left"></i> {{ trans('messages.back') }}</a>
        </div>
        <div class="card-block pall-10">
            {!! Form::open(['route' => 'college.store','data-toggle'=>"validator"])!!}
                <div class="row">
                    <div class="col-md-12">
                        {!! Form::hidden('college_id', isset($college->college_id) ? $college->college_id : '') !!}
                        <div class="form-group has-feedback">
                            {!!Form::label('name',trans('messages.field_name',['field' => trans('messages.college')]).' *',['class'=>'form-control-label'])!!}
                            {!! Form::text('name',isset($college->name) ? $college->name : null,['class'=>'form-control', 'required', 'placeholder' => trans('messages.enter_field_name',['field' => trans('messages.college')]) ])!!}
                            <div class="help-block with-errors"></div>   
                            @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif    
                        </div>
                        <div class="form-group has-feedback">
                            {!!Form::label('address',trans('messages.field_address',['field' => trans('messages.college')]).' *',['class'=>'form-control-label'])!!}
                            {!! Form::text('address',isset($college->address) ? $college->address : null,['class'=>'form-control', 'required', 'placeholder' => trans('messages.enter_field_address',['field' => trans('messages.college')]) ])!!}
                            <div class="help-block with-errors"></div>   
                            @if ($errors->has('address'))
                                <span class="text-danger">{{ $errors->first('address') }}</span>
                                @endif    
                        </div>
                        <div class="form-group has-feedback">
                            {!!Form::label('gps',trans('messages.gps'),['class'=>'form-control-label'])!!}
                            {!! Form::text('gps',isset($college->gps) ? $college->gps : null,['class'=>'form-control', 'placeholder' => trans('messages.enter_gps') ])!!}
                            <div class="help-block with-errors"></div>   
                            @if ($errors->has('gps'))
                                <span class="text-danger">{{ $errors->first('gps') }}</span>
                                @endif    
                        </div>
                        <div class="form-group has-feedback">
                            {!!Form::label('country',trans('messages.country',).' *',['class'=>'form-control-label'])!!}
                            {!! Form::select('country', $countrylist, isset($college->country) ? $college->country : null,['class'=>'form-control', 'required', 'placeholder' => trans('messages.countryselect',) ])!!}
                            <div class="help-block with-errors"></div>   
                            @if ($errors->has('country'))
                                <span class="text-danger">{{ $errors->first('country') }}</span>
                                @endif    
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::submit(trans('messages.save'),['class' => 'btn btn-md btn-primary']) !!}
                        </div>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
@section('body_bottom')
<script>
    $(document).ready(function(){
        $('.category-list-item').addClass('active');
    });
</script>
@endsection