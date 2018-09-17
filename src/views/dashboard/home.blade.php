@extends('dashboard.layouts.app')

@section('menu-itmes')
@parent()
<a href="{{ route('users.index') }}" class="fs-large fs-sm-small fs-large fs-sm-small d-flex flex-column justify-content-center align-items-center text-white text-center menu-item">
			<i class="fas fa-user"></i>
			<span>{{ _d('users') }}</span>
		</a>
@endsection
