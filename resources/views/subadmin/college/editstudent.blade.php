@extends('layouts.app')

@section('content')
    <!-- Table -->
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card bg-secondary shadow border-0">
                <div class="card-body px-lg-5 py-lg-5">
                    <div class="text-center text-muted mb-4">
                        <a href="{{ route('school.student', ['id' => $student->college_id]) }}" class="btn btn-sm btn-primary float-right d-inline"><i class="fa fa-angle-double-left"></i> {{ trans('messages.back') }}</a>
                        <small>Edit Student</small>
                    </div>
                    <form method="POST" action="{{ route('school.updatestudent', [$student->id]) }}">
                    {{ csrf_field() }}

                        <input name="college_id" value="{{$student->college_id}}" type="hidden">
                        <div class="form-group">
                            <div class="input-group input-group-alternative mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-hat-3"></i></span>
                                </div>

                                <input type="hidden" name="student_id" value="{{$student->id}}">
                                <input id="name" type="text" placeholder="{{ __('Name') }}" class="form-control @error('name') is-invalid @enderror" name="name" value="@php if(!empty(old('name'))){echo old('name'); }else{echo $student->name;} @endphp" required autocomplete="name" autofocus>

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

                                <input id="username" type="text" placeholder="{{ __('Registration Number') }}" class="form-control @error('username') is-invalid @enderror" name="username" value="@php if(!empty(old('username'))){echo old('username'); }else{echo $student->username;} @endphp" required autocomplete="username" autofocus>

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

                                <input id="email" type="email" placeholder="{{ __('E-mail') }}" class="form-control @error('email') is-invalid @enderror" name="email" value="@php if(!empty(old('email'))){echo old('email'); }else{echo $student->email;} @endphp" required autocomplete="email">

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

                                <input id="contact_number" type="tel" placeholder="{{ __('Contact Number') }}" class="form-control @error('contact_number') is-invalid @enderror" name="contact_number" value="@php if(!empty(old('contact_number'))){echo old('contact_number'); }else{echo $student->contact_number;} @endphp" required autocomplete="contact_number">

                                @error('contact_number')
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
                            <button type="submit" class="btn btn-block btn-primary mt-4">Update Student</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
