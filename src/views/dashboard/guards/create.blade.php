@extends('dashboard.layouts.create')

@section('form')
<div class="form-group">
    <label for="title">{{ _d('guard.title') }}</label>
    <div class="form-input">
        <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" placeholder="{{ _d('guard.title') }}" value="{{ $guard->title or '' }}">
        <label class="form-icon" for="title"><i class="fas fa-shield-check"></i></label>
        @if ($errors->has('title'))
        <div class="invalid-feedback">{{ $errors->first('title') }}</div>
        @endif
    </div>
</div>
@endsection
