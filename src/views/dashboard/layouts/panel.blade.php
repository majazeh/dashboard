@extends(isset($display->home) ? $display->home : 'dashboard.home')

@section('main')
<div class="d-flex justify-content-between align-items-center mb-3 pb-2 page-head" data-xhr="page-head">
    <div class="page-head-content">
        <h2 class="mb-0 f3 page-head-title">
            {{ $module->header }}
        </h2>
        <div class="f1 page-head-text">
            <span>{{ $module->desc ?: '' }}</span>
            @if (Breadcrumbs::exists(\Request::route()->getName()))
                {{ Breadcrumbs::render(\Request::route()->getName(), \Data::all()) }}
            @endif
        </div>
    </div>

    <div class="d-flex page-head-actions" data-xhr="topbar-actions">
        @yield('topbar-actions')
    </div>
</div>

<div class="container-fluid" data-xhr="container-fluid">
    @section('container-fluid')
    <div class="row">
        @yield('panel.content')
    </div>
    @show
</div>
@endsection
