@extends('layouts.app')

@section('content')
    <!-- Table -->
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card bg-secondary shadow border-0">
                <div class="card-body px-lg-5 py-lg-5">
                   <a href="{{ route('assistant.index') }}" class="btn btn-sm btn-primary float-right d-inline"><i class="fa fa-angle-double-left"></i> {{ trans('messages.back') }}</a>
                    <div class="text-center text-muted mb-4">
                        <small>{{trans('messages.add_assistant')}}</small>
                    </div>
                    <form method="POST" action="{{ route('assistant.store') }}">
                    {{ csrf_field() }}

                        <div class="form-group">
                            <div class="input-group input-group-alternative mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-hat-3"></i></span>
                                </div>
                                <input id="name" type="text" placeholder="{{ __('Name') }}" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

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

                                <input id="username" type="text" placeholder="{{ __('User Name') }}" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

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

                                <input id="email" type="email" placeholder="{{ __('E-mail') }}" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

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

                                <input id="contact_number" type="tel" placeholder="{{ __('Contact Number') }}" class="form-control @error('contact_number') is-invalid @enderror" name="contact_number" value="{{ old('contact_number') }}" required autocomplete="contact_number">

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
                                    <input class="form-check-input" name="role[]" type="checkbox" value="category">Manage Category<br>
                                    <input class="form-check-input" name="role[]" type="checkbox" value="college">Manage College<br>
                                    <input class="form-check-input" name="role[]" type="checkbox" value="contributors">Manage Contributors<br>
                                    <input class="form-check-input" name="role[]" type="checkbox" value="content">Manage Content<br>
                                    <input class="form-check-input" name="role[]" type="checkbox" value="sales">Manage Sales<br>
                                    <input class="form-check-input" name="role[]" type="checkbox" value="terms_of_service">Manage Terms Of Service<br>
                                    <input class="form-check-input" name="role[]" type="checkbox" value="user_feedback">Manage User Feedback<br>
                                </div>

                                @error('role[]')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="form-group">
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                </div>

                                <input id="password" type="password" placeholder="{{ __('Password') }}" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                </div>

                                <input id="password-confirm" placeholder="{{ __('Confirm password') }}" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        {{--<div class="text-muted font-italic"><small>password strength: <span class="text-success font-weight-700">strong</span></small></div>--}}
                        <div class="text-center">
                            <button type="submit" class="btn btn-block btn-primary mt-4">Create account</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
