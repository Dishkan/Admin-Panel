@extends('layouts.app', [
    'namePage' => 'Create item',
    'class' => 'sidebar-mini',
    'activePage' => 'items',
    'activeNav' => '',
])

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
                                <h3 class="mb-0">{{ __('Item Management') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('item.index') }}" class="btn btn-primary btn-round">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" class="item-form" action="{{ route('item.store') }}" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            <h6 class="heading-small text-muted mb-4">{{ __('Item information') }}</h6>
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('Name') }}</label>
                                    <input type="text" name="name" id="input-name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Name') }}" value="{{ old('name') }}" required autofocus>

                                    @include('alerts.feedback', ['field' => 'name'])
                                </div>
                                <label class="form-control-label" for="input-excerpt">{{ __('Category') }}</label>
                                <div class="form-group{{ $errors->has('category_id') ? ' has-danger' : '' }}">
                                    <select title="{{ __('Category') }}" data-style="btn btn-primary btn-round" name="category_id" id="input-role" data-size="7" class="selectpicker{{ $errors->has('category_id') ? ' is-invalid' : '' }}" placeholder="{{ __('Category') }}" required>
                                        <option value="">-</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ $category->id == old('category_id') ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @include('alerts.feedback', ['field' => 'category_id'])
                                </div>
                                <div class="form-group{{ $errors->has('excerpt') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-excerpt">{{ __('Excerpt') }}</label>
                                    <textarea name="excerpt" id="input-excerpt" cols="30" rows="2" class="form-control{{ $errors->has('excerpt') ? ' is-invalid' : '' }}" placeholder="{{ __('Excerpt') }}" value="{{ old('excerpt') }}">{{ old('excerpt') }}</textarea>
                                    @include('alerts.feedback', ['field' => 'excerpt'])
                                    <label class="form-control-label" for="input-excerpt">{{ __('Picture') }}</label>
                                </div>
                                <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail">
                                        <img src="{{ asset('now') }}/img/image_placeholder.jpg" alt="...">
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                    <div>
                                        <span class="btn btn-rose btn-round btn-file">
                                        <span class="fileinput-new">{{ __('Select image') }}</span>
                                        <span class="fileinput-exists">{{ __('Change') }}</span>
                                        <input type="file" name="photo" class="custom-file-input{{ $errors->has('photo') ? ' is-invalid' : '' }}" id="input-picture" accept="image/*" required/>
                                        </span>
                                        <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> {{ __('Remove') }}</a>
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }}">
                                    <label class="form-control-label">{{ __('Description') }}</label>
                                    <textarea name="description" id="input-excerpt" cols="30" rows="2" class="form-control" placeholder="{{ __('Description') }}" value="{{ old('description') }}"></textarea>
                                    @include('alerts.feedback', ['field' => 'description'])
                                </div>
                                <label class="form-control-label" for="input-excerpt">{{ __('Tags') }}</label>
                                <div class="form-group{{ $errors->has('tags') ? ' has-danger' : '' }}">
                                    <select name="tags[]" class="selectpicker{{ $errors->has('tags') ? ' is-invalid' : '' }}" placeholder="{{ __('Tags') }}" data-style="btn btn-info btn-round" multiple title="Choose Tags" data-size="7">
                                        @foreach ($tags as $tag)
                                            <option  value="{{ $tag->id }}" {{ in_array($tag->id, old('tags') ?? []) ? 'selected' : '' }}>{{ $tag->name }}</option> 
                                        @endforeach
                                    </select>
                                    @include('alerts.feedback', ['field' => 'tags'])
                                </div>
                                <div class="form-group{{ $errors->has('status') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-role">{{ __('Status') }}</label>
                                    @foreach (config('items.statuses') as $value => $status)
                                        <div class="custom-control custom-radio mb-3">
                                            <input name="status" class="custom-control-input" id="{{ $value }}" value="{{ $value }}" type="radio" {{ old('status') == $value ? ' checked' : '' }}>
                                            <label class="custom-control-label" for="{{ $value }}">{{ $status }}</label>
                                        </div>
                                    @endforeach
                                    @include('alerts.feedback', ['field' => 'status'])
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-role">{{ __('Show on homepage') }}</label>
                                    <div class="custom-field">
                                        <label class="custom-toggle">
                                            <input type="checkbox" checked name="show_on_homepage" class="bootstrap-switch" value="1" {{ old('show_on_homepage') == 1 ? ' checked' : '' }} data-on-label="YES" data-off-label="NO" />
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">{{ __('Options') }}</label>
                                    @foreach (config('items.options') as $key => $option)
                                        <div class="custom-control custom-checkbox mb-3">
                                            <input class="custom-control-input" name="options[]" id="option-{{ $key }}"
                                                type="checkbox" value="{{ $key }}" {{ old('options') && in_array($key, old('options')) ? ' checked' : '' }}>
                                            <label class="custom-control-label" for="option-{{ $key }}">
                                                {{ $option }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="date">{{ __('Date') }}</label>
                                            <input class="form-control datepicker" name="date" id="date"
                                                placeholder="Select date" type="text" data-date-format="dd-mm-yyyy"
                                                value="{{ old('date', now()->format('d-m-Y')) }}">
                                        </div>
                                    </div>
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