@extends('dashboard.layouts.create')

@section('form-name')
@include('dashboard.users.forms.name')
@endsection

@section('form-username')
@include('dashboard.users.forms.username')
@endsection

@section('form-email')
@include('dashboard.users.forms.email')
@endsection

@section('form-mobile')
@include('dashboard.users.forms.mobile')
@endsection

@section('form-password')
@include('dashboard.users.forms.password')
@endsection

@section('form-status')
@include('dashboard.users.forms.status')
@endsection

@section('form-gender')
@include('dashboard.users.forms.gender')
@endsection

@section('form-type')
@include('dashboard.users.forms.type')
@endsection

@section('form')

    @yield('form-name')
    @yield('form-username')
    @yield('form-email')
    @yield('form-mobile')
    @yield('form-password')
    @yield('form-status')
    @yield('form-gender')
    @yield('form-type')

@endsection