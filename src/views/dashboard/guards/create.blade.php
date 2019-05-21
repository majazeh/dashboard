@extends('dashboard.layouts.create')

@section('form')
<div class="form-group">
    <label for="title">{{ _d('guard.title') }}</label>
    <div class="form-input">
        <input class="form-control" type="text" name="title" id="title" placeholder="{{ _d('guard.title') }}" value="{{ isset($guard) ? $guard->title : '' }}">
        <label class="form-icon" for="title"><i class="fas fa-shield-check"></i></label>
    </div>
</div>
@endsection
