@extends($layouts->mod == 'html' ? 'dashboard.layouts.panel' :  'dashboard.layouts.panel-xhr')

@section('panel.content')
@include('dashboard.layouts.create-content')
@endsection
@section('topbar-actions')
<a href="{{ route($module->resource . '.index') }}" class="btn btn-sm btn-info btn-gradient">
    <i class="{{ $module->icons['index'] }}"></i>
    {{ _d($module->resource.'.index') }}
</a>
@if ($module->action == 'edit')
<a href="{{ route($module->resource . '.create') }}" class="btn btn-sm btn-success btn-gradient">
    <i class="{{ $module->icons['create'] }}"></i>
    {{ _d($module->resource.'.create') }}
</a>
@endif

@endsection