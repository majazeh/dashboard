@extends($layouts->mod == 'html' ? 'dashboard.layouts.panel' : 'dashboard.layouts.panel-xhr')

@section('panel.content')
@include('dashboard.layouts.index-content')
@endsection

@section('topbar-actions')
<a href="{{ route($module->resource . '.create') }}" class="btn btn-xs btn-outline-success btn-rounded d-none d-sm-inline-block btn-success-color">
    <i class="{{ $module->icons['create'] }}"></i>
    {{ _d($module->resource . '.create') }}</a>
    @endsection
