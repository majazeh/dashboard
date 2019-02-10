@extends('dashboard.layouts.create')

@section('form-to')
@include('dashboard.notifications.forms.to')
@endsection

@section('form-title')
@include('dashboard.notifications.forms.title')
@endsection

@section('form-services')
@include('dashboard.notifications.forms.services')
@endsection

@section('form-content')
@include('dashboard.notifications.forms.content')
@endsection

@section('form-trigger')
@include('dashboard.notifications.forms.trigger')
@endsection

@section('form')

    @yield('form-to')
    @yield('form-title')
    @yield('form-services')
    @yield('form-content')
    @yield('form-trigger')

@endsection