<div id="main" class="main px-3 py-1" data-xhr="main">
    <div class="d-flex mb-5 page-head" data-xhr="page-head">
        <div class="d-flex justify-content-center align-items-center page-head-icon">
            <i class="{{ $module->icon }}"></i>
        </div>

        <div class="d-flex align-items-center px-3 page-head-body">
            <h2 class="mb-0 page-head-title">{{ $module->header }}</h2>
            <p class="d-none d-lg-block text-muted mb-0 page-head-text">
                {{ $module->desc or '' }}
            </p>
        </div>
    </div>
    <div class="container-fluid" data-xhr="container-fluid">
        @section('container-fluid')
        <div class="row">
            @yield('panel.content')
        </div>
        @show
    </div>
</div>

<div class="topbar-actions" data-xhr="topbar-actions">
    @yield('topbar-actions')
</div>