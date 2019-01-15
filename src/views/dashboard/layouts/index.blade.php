@extends($layouts->mod == 'html' ? 'dashboard.layouts.panel' : 'dashboard.layouts.panel-xhr')

@section('panel.content')
@include('dashboard.layouts.index-content')
@endsection

@section('topbar-actions')
	@if (Route::has($module->resource . '.create'))
	<a href="{{ route($module->resource . '.create') }}" class="btn btn-sm btn-success btn-gradient">
	    <i class="{{ $module->icons['create'] }}"></i>
	    {{ _d($module->resource . '.create') }}</a>
	@endif
@endsection
