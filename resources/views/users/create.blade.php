@extends('layouts.app', [
    'class' => 'sidebar-mini ',
    'namePage' => 'Create user',
    'activePage' => 'user',
    'activeNav' => '',
])

@section('content')
    <div class="panel-header panel-header-sm">
    </div>
    <div class="content">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('User Management') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('user.index') }}" class="btn btn-primary btn-round">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('user.store') }}" autocomplete="off"
                            enctype="multipart/form-data">
                            @csrf
                            <h6 class="heading-small text-muted mb-4">{{ __('User information') }}</h6>
                            <div class="pl-lg-4">
                                <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail">
                                        <img src="" alt="...">
                                        <img src="{{asset('now')}}/img/image_placeholder.jpg" alt="...">
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                    <div>
                                        <span class="btn btn-rose btn-round btn-file">
                                        <span class="fileinput-new">{{ __('Select Profile Photo')}}</span>
                                        <span class="fileinput-exists">{{ __('Change')}}</span>
                                        <input type="file" name="profile_photo" class="custom-file-input"
                                               id="input-picture" accept="image/*"/>
                                        </span>
                                        <a href="#pablo" class="btn btn-danger btn-round fileinput-exists"
                                           data-dismiss="fileinput"><i class="fa fa-times"></i>{{__('Remove')}}</a>
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('firstname') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('First name') }}</label>
                                    <input type="text" name="firstname" id="input-name" class="form-control{{ $errors->has('firstname') ? ' is-invalid' : '' }}" placeholder="{{ __('First name') }}" value="{{ old('firstname') }}" required autofocus>

                                    @include('alerts.feedback', ['field' => 'firstname'])
                                </div>
                                <div class="form-group{{ $errors->has('lastname') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('Last name') }}</label>
                                    <input type="text" name="lastname" id="input-name" class="form-control{{ $errors->has('lastname') ? ' is-invalid' : '' }}" placeholder="{{ __('Last name') }}" value="{{ old('lastname') }}" required autofocus>

                                    @include('alerts.feedback', ['field' => 'lastname'])
                                </div>
                                <div class="form-group{{ $errors->has('phonenumber') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('Phone number') }}</label>
                                    <input type="text" name="phonenumber" id="input-name" class="form-control{{ $errors->has('phonenumber') ? ' is-invalid' : '' }}" placeholder="{{ __('Phone number') }}" value="{{ old('phonenumber') }}" required autofocus>

                                    @include('alerts.feedback', ['field' => 'phonenumber'])
                                </div>
                                <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-email">{{ __('Email') }}</label>
                                    <input type="email" name="email" id="input-email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}" value="{{ old('email') }}" required>

                                    @include('alerts.feedback', ['field' => 'email'])
                                </div>
                                <div class="form-group{{ $errors->has('role_id') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-role">{{ __('Role') }}</label>
                                    <select name="role_id" id="input-role" class="form-control{{ $errors->has('role_id') ? ' is-invalid' : '' }}" placeholder="{{ __('Role') }}" required>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}" {{ $role->id == old('role_id') ? 'selected' : '' }}>{{ $role->name }}</option>
                                        @endforeach
                                    </select>

                                    @include('alerts.feedback', ['field' => 'role_id'])
                                </div>
                                <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-password">{{ __('Password') }}</label>
                                    <input type="password" name="password" id="input-password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ __('Password') }}" value="" required>

                                    @include('alerts.feedback', ['field' => 'password'])
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-password-confirmation">{{ __('Confirm Password') }}</label>
                                    <input type="password" name="password_confirmation" id="input-password-confirmation" class="form-control" placeholder="{{ __('Confirm Password') }}" value="" required>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection