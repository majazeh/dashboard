@extends('dashboard.layouts.app')

@section('menu-itmes')
<a href="{{ env('DASHIO_PATH') }}" class="fs-large fs-sm-small fs-large fs-sm-small d-flex flex-column justify-content-center align-items-center text-white text-center menu-item">
	<i class="fas fa-tachometer-alt mb-1"></i>
	<span>تست</span>
</a>
@endsection
