<div id="main" class="main px-3 py-1" data-xhr="main">
@section('main')
    <div class="d-flex mb-5 page-head">
        <div class="d-flex justify-content-center align-items-center page-head-icon">
            <i class="fas fa-tachometer-alt"></i>
        </div>

        <div class="d-flex align-items-center px-3 page-head-body">
            <h2 class="mb-0 page-head-title">
                {{ _d('dashboard') }}
            </h2>
            <p class="d-none d-lg-block text-muted mb-0 page-head-text"></p>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-10 offset-md-1">
                <div class="wrapper mb-2">
                    <h3>
                        {{ _d('Welcome') }}
                    </h3>
                    <p class="mb-0">
                        {{ _d('Welcome to dashboard') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@show
</div>
