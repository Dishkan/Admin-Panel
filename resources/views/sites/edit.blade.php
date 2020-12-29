@extends('layouts.app', [
    'class' => 'sidebar-mini ',
    'namePage' => 'Edit user',
    'activePage' => 'user',
    'activeNav' => '',
])
@if($site->id)
@section('content')
    <div class="panel-header">
    </div>
    <div class="content">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Sites Management') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('sites.index') }}" class="btn btn-primary btn-round">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('sites.update', $site) }}" autocomplete="off"
                              enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <h6 class="heading-small text-muted mb-4">{{ __('Site information') }}</h6>
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('dealer_name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-place_name">{{ __('Dealer name') }}</label>
                                    <input type="text" name="dealer_name" id="input-place-name" class="form-control{{ $errors->has('dealer_name') ? ' is-invalid' : '' }}" placeholder="{{ __('Dealer name') }}" value="{{ old('dealer_name', $site->dealer_name) }}"  required autofocus>

                                </div>
                                <div class="form-group{{ $errors->has('place_name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-place_name">{{ __('Place name') }}</label>
                                    <input type="text" name="place_name" id="input-place-name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Place name') }}" value="{{ old('place_name', $site->place_name) }}"  required autofocus>

                                </div>
                                <div class="form-group{{ $errors->has('old_website_url') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-website-url">{{ __('Website') }}</label>
                                    <input type="text" name="old_website_url" id="input-website-url" class="form-control{{ $errors->has('old_website_url') ? ' is-invalid' : '' }}" placeholder="{{ __('Website url') }}" value="{{ old('old_website_url', $site->old_website_url) }}"  required autofocus>
                                </div>
                                <div class="form-group{{ $errors->has('lead_email') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-lead-email">{{ __('Lead email') }}</label>
                                    <input type="email" name="lead_email" id="input-lead-email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Lead email') }}" value="{{ old('lead_email', $site->lead_email) }}" required>
                                </div>
                                <div class="form-group{{ $errors->has('country') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-country">{{ __('Country') }}</label>
                                    <input type="text" name="country" id="input-country" class="form-control{{ $errors->has('country') ? ' is-invalid' : '' }}" placeholder="{{ __('Country') }}" value="{{ old('country', $site->country) }}" required>
                                </div>
                                <div class="form-group{{ $errors->has('state') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-state">{{ __('State') }}</label>
                                    <input type="text" name="state" id="input-state" class="form-control{{ $errors->has('state') ? ' is-invalid' : '' }}" placeholder="{{ __('State') }}" value="{{ old('state', $site->state) }}" required>
                                </div>
                                <div class="form-group{{ $errors->has('state') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-city">{{ __('City') }}</label>
                                    <input type="text" name="city" id="input-city" class="form-control{{ $errors->has('city') ? ' is-invalid' : '' }}" placeholder="{{ __('City') }}" value="{{ old('city', $site->city) }}" required>
                                </div>
                                <div class="form-group{{ $errors->has('postal_code') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-postal-code">{{ __('Postal code') }}</label>
                                    <input type="text" name="postal_code" id="input-postal-code" class="form-control{{ $errors->has('city') ? ' is-invalid' : '' }}" placeholder="{{ __('Postal code') }}" value="{{ old('postal_code', $site->postal_code) }}" required>
                                </div>
                                <div class="form-group{{ $errors->has('dealer_number') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-dealer-number">{{ __('Dealer number') }}</label>
                                    <input type="text" name="dealer_number" id="input-dealer-number" class="form-control{{ $errors->has('dealer_number') ? ' is-invalid' : '' }}" placeholder="{{ __('Dealer number') }}" value="{{ old('dealer_number', $site->dealer_number) }}" required>
                                </div>
                                <div class="form-group{{ $errors->has('address') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-address">{{ __('Address') }}</label>
                                    <input type="text" name="address" id="input-address" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" placeholder="{{ __('Address') }}" value="{{ old('Address', $site->address) }}" required>
                                </div>
                                <div class="form-group{{ $errors->has('type') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-type">{{ __('Type') }}</label>
                                    <select name="type" id="input-type" data-style="btn btn-primary btn-round" class="selectpicker{{ $errors->has('type') ? ' is-invalid' : '' }}" placeholder="{{ __('Type') }}" required>
                                        <option  >{{ $site->type }}</option>
                                        @if($site->type != 'group')
                                            <option> group </option>
                                        @endif
                                        @if($site->type != 'oem')
                                        <option> oem </option>
                                        @endif
                                        @if($site->type != 'independent')
                                            <option> independent </option>
                                        @endif
                                    </select>
                                </div>
                                <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail">
                                        @if ($site->old_website_favicon_src)
                                            <img src="{{ $site->path() }}" alt="...">
                                        @else
                                            <img src="{{asset('now')}}/img/image_placeholder.jpg" alt="...">
                                        @endif
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                    <div>
                                        <span class="btn btn-rose btn-round btn-file">
                                        <span class="fileinput-new">{{ __('Select icon')}}</span>
                                        <span class="fileinput-exists">{{ __('Change')}}</span>
                                        <input type="file" name="icon" class="custom-file-input" id="input-picture" accept="image/*"/>
                                        </span>
                                        <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i>{{__('Remove')}}</a>
                                    </div>
                                </div>
                                <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail">
                                        @if ($site->old_website_logo_src)
                                            <img src="{{ $site->path() }}" alt="...">
                                        @else
                                            <img src="{{asset('now')}}/img/image_placeholder.jpg" alt="...">
                                        @endif
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                    <div>
                                        <span class="btn btn-rose btn-round btn-file">
                                        <span class="fileinput-new">{{ __('Select logo')}}</span>
                                        <span class="fileinput-exists">{{ __('Change')}}</span>
                                        <input type="file" name="logo" class="custom-file-input" id="input-picture" accept="image/*"/>
                                        </span>
                                        <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i>{{__('Remove')}}</a>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Save changes') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@endif