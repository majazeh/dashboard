@extends('dashboard.layouts.create')

@section('form')
<div class="form-group">
    <input class="form-control" type="text" name="name" id="name" placeholder="{{ _d('name') }}" value="{{ isset($user->name) ? $user->name : ''}}">

    <label for="name">
        <i class="fas fa-user-tag"></i>
    </label>
</div>

<div class="form-group">
    <input class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}" type="text" name="username" id="username" placeholder="{{ _d('username') }}" value="{{ isset($user->username) ? $user->username : ''}}">

    <label for="username">
        <i class="fas fa-at"></i>
    </label>

    @if ($errors->has('username'))
    <div class="invalid-feedback">{{ $errors->first('username') }}</div>
    @endif
</div>

<div class="form-group">
    <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" placeholder="{{ _d('email') }}" value="{{ isset($user->email) ? $user->email : ''}}">

    <label for="email">
        <i class="fas fa-envelope"></i>
    </label>

    @if ($errors->has('email'))
    <div class="invalid-feedback">{{ $errors->first('email') }}</div>
    @endif
</div>

<div class="form-group">
    <input class="form-control {{ $errors->has('mobile') ? 'is-invalid' : '' }}" type="tel" name="mobile" id="mobile" placeholder="{{ _d('mobile') }}" value="{{ isset($user->mobile) ? $user->mobile : ''}}">

    <label for="mobile">
        <i class="fas fa-mobile-alt"></i>
    </label>

    @if ($errors->has('mobile'))
    <div class="invalid-feedback">{{ $errors->first('mobile') }}</div>
    @endif
</div>


<div class="form-group">
    <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" type="password" name="password" id="password" placeholder="{{ _d('password') }}">

    <label for="password">
        <i class="fas fa-shield-alt"></i>
    </label>

    @if ($errors->has('password'))
    <div class="invalid-feedback">{{ $errors->first('password') }}</div>
    @endif
</div>

<div class="radio tick">
    <label>
        {{ _d('account.status') }}
    </label>
    @foreach ($userStatus as $type => $value)
    <div class="custom-control custom-radio">
        @isset ($user)
        <input type="radio" value="{{ $type }}" id="{{ $type }}" {{ $user->status == $type ? 'checked="checked"' : '' }} name="status" class="custom-control-input">
        @else
        <input type="radio" value="{{ $type }}" id="{{ $type }}" {{ $type == 'waiting' ? 'checked="checked"' : '' }} name="status" class="custom-control-input">
        @endisset
        <label class="custom-control-label" for="{{ $type }}">
            {{ $value }}
        </label>
    </div>
    @endforeach
</div>

<div class="radio tick">
    <label>
        {{ _d('gender') }}
    </label>

    <div class="custom-control custom-radio">
        <input type="radio" value="female" id="female" name="gender" class="custom-control-input" {{ isset($user->gender) && $user->gender == 'female' ? 'checked="checked"' : '' }}>
        <label class="custom-control-label" for="female">
            {{ _d('female') }}
        </label>
    </div>

    <div class="custom-control custom-radio">
        <input type="radio" value="male" id="male" name="gender" class="custom-control-input" {{ isset($user->gender) && $user->gender == 'male' ? 'checked="checked"' : '' }}>
        <label class="custom-control-label" for="male">
            {{ _d('male') }}
        </label>
    </div>
</div>

<div class="input-group">
    <select class="custom-select" name="type" id="type">
        @foreach ($userTypes as $type => $value)
        @isset ($user)
        <option value="{{ $type }}" {{ $user->type == $type ? 'selected="selected"' : '' }}>{{ $value }}</option>
        @else
        <option value="{{ $type }}" {{ $type == 'user' ? 'selected="selected"' : '' }}>{{ $value }}</option>
        @endisset
        @endforeach
    </select>
</div>
@endsection
