@extends('layouts.app')

@section('content')
    <!-- Table -->
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card bg-secondary shadow border-0">
                <div class="card-body px-lg-5 py-lg-5">
                   <a href="{{ route('assistant.index') }}" class="btn btn-sm btn-primary float-right d-inline"><i class="fa fa-angle-double-left"></i> {{ trans('messages.back') }}</a>
                    <div class="text-center text-muted mb-4">
                        <small>{{trans('messages.edit_assistant')}}</small>
                    </div>
                    <form method="POST" action="{{ route('assistant.update', [$assistant->id]) }}">
                    {{ csrf_field() }}

                        <div class="form-group">
                            <div class="input-group input-group-alternative mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-hat-3"></i></span>
                                </div>
                                <input id="name" type="text" placeholder="{{ __('Name') }}" class="form-control @error('name') is-invalid @enderror" name="name" value="@php if(!empty(old('name'))){echo old('name'); }else{echo $assistant->name;} @endphp" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group input-group-alternative mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-hat-3"></i></span>
                                </div>

                                <input id="username" type="text" placeholder="{{ __('User Name') }}" class="form-control @error('username') is-invalid @enderror" name="username" value="@php if(!empty(old('username'))){echo old('username'); }else{echo $assistant->username;} @endphp" required autocomplete="username" autofocus>

                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group input-group-alternative mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                </div>

                                <input id="email" type="email" placeholder="{{ __('E-mail') }}" class="form-control @error('email') is-invalid @enderror" name="email" value="@php if(!empty(old('email'))){echo old('email'); }else{echo $assistant->email;} @endphp" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group input-group-alternative mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-phone-83"></i></span>
                                </div>

                                <input id="contact_number" type="tel" placeholder="{{ __('Contact Number') }}" class="form-control @error('contact_number') is-invalid @enderror" name="contact_number" value="@php if(!empty(old('contact_number'))){echo old('contact_number'); }else{echo $assistant->contact_number;} @endphp" required autocomplete="contact_number">

                                @error('contact_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                                <label for="role">Select Roles</label>
                                <div class="form-check">
@php 
    if(!empty(old('role')))
    {
        $roles = old('name');
    }
    else
    {
        $roles = array_map("trim",explode(";;", $assistant->admin_assistant_roles));
    }
@endphp
                                    <input class="form-check-input" name="role[]" type="checkbox" value="category" @if(in_array("category", $roles, true)) checked @endif>Manage Category<br>
                                    <input class="form-check-input" name="role[]" type="checkbox" value="college" @if(in_array("college", $roles, true)) checked @endif>Manage College<br>
                                    <input class="form-check-input" name="role[]" type="checkbox" value="contributors" @if(in_array("contributors", $roles, true)) checked @endif>Manage Contributors<br>
                                    <input class="form-check-input" name="role[]" type="checkbox" value="content" @if(in_array("content", $roles, true)) checked @endif>Manage Content<br>
                                    <input class="form-check-input" name="role[]" type="checkbox" value="sales" @if(in_array("sales", $roles, true)) checked @endif>Manage Sales<br>
                                    <input class="form-check-input" name="role[]" type="checkbox" value="terms_of_service" @if(in_array("terms_of_service", $roles, true)) checked @endif>Manage Terms Of Service<br>
                                    <input class="form-check-input" name="role[]" type="checkbox" value="user_feedback" @if(in_array("user_feedback", $roles, true)) checked @endif>Manage User Feedback<br>
                                </div>

                                @error('role[]')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-block btn-primary mt-4">Update account</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
