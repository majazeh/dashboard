<div class="d-none flex-column d-md-block menu" id="menu">
    <a class="d-flex justify-content-center align-items-center branding-logo" href="{{ route('dashboard') }}">
        <img src="{{ asset('images/logo/logo-40.png') }}" alt="{{ $global->title ?: _d('Dashio') }}" width="40" height="40">
    </a>

    <div class="menu-inner">
        @section('menu-itmes')
            <a class="d-flex flex-column justify-content-center align-items-center menu-item" href="{{ route('dashboard') }}">
                <i class="fas fa-tachometer-alt"></i>
                <span>{{ _d('Dashboard') }}</span>
            </a>
            @if (\Auth::guardio('user.all'))
                <a class="d-flex flex-column justify-content-center align-items-center menu-item" href="{{ route('users.index') }}">
                    <i class="fas fa-users"></i>
                    <span>{{ _d('Users') }}</span>
                </a>
            @endif
        @show
    </div>
</div>

<button id="btn-menu" class="d-md-none btn-menu menu-open" type="button"><i class="fas fa-bars"></i></button>