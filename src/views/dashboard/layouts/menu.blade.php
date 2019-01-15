<div class="d-none d-sm-block menu">
    <a class="d-flex justify-content-center align-items-center branding-logo" href="{{ env('APP_URL') }}">
        <img src="{{ asset('images/logo.png') }}" alt="{{ ucfirst(_d('logo')) }}" width="40" height="40">
    </a>

    @section('menu-itmes')
    <a class="d-flex flex-column justify-content-center align-items-center menu-item" href="{{ route('dashboard') }}">
        <i class="fas fa-tachometer-alt"></i>
        <span>{{ _d('Dashboard') }}</span>
    </a>

    <a class="d-flex flex-column justify-content-center align-items-center menu-item" href="{{ route('users.index') }}">
        <i class="fas fa-users"></i>
        <span>{{ _d('Users') }}</span>
    </a>
    @show
</div>
