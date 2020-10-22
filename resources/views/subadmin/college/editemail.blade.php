@extends('layouts.app')

@section('content')
    <!-- Table -->
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card bg-secondary shadow border-0">
                <div class="card-body px-lg-5 py-lg-5">
                    <div class="text-center text-muted mb-4">
                        <a href="{{ route('school.'.$user_type, ['id' => $user->college_id]) }}" class="btn btn-sm btn-primary float-right d-inline"><i class="fa fa-angle-double-left"></i> {{ trans('messages.back') }}</a>
                        <small>Edit {{ucfirst($user_type)}} Email</small>
                    </div>
                    <form method="POST" action="{{ route('school.updateemail', [$user_type, $user->id]) }}">
                    {{ csrf_field() }}

                        <input name="college_id" value="{{$user->college_id}}" type="hidden">
                        <div class="form-group">
                            <div class="input-group input-group-alternative mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                </div>
                                <input id="email" type="email" placeholder="{{ __('E-mail') }}" class="form-control @error('email') is-invalid @enderror" name="email" value="@php if(!empty(old('email'))){echo old('email'); }else{echo $user->email;} @endphp" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-block btn-primary mt-4">Update {{ucfirst($user_type)}} Email</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
