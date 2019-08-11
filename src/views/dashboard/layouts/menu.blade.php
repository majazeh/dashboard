<div class="d-none flex-column d-md-block menu" id="menu">
    @if (false)
        <a class="d-flex justify-content-center align-items-center branding-logo" href="{{ route('dashboard') }}">
            <img src="{{ asset('images/logo/logo-40.png') }}" alt="{{ $global->title ?: _d('Dashio') }}" width="40" height="40">
        </a>
    @endif

    <a href="{{ route('dashboard') }}" class="branding" title="{{ _d('title.dashio') }}">
        <img src="{{ asset('images/logo/logo-40.png') }}" class="branding-logo" alt="{{ $global->title ?: _d('Dashio') }}" width="40" height="40">
        <div class="branding-title">
            {{ _d('title.dashio') }}
        </div>
    </a>

    <div class="menu-inner">
        @section('menu-itmes')
            <a class="d-flex align-items-center menu-item" href="{{ route('dashboard') }}">
                <i class="fas fa-tachometer-alt"></i>
                <span>{{ _d('Dashboard') }}</span>
            </a>
            @if (\Auth::guardio('user.all'))
                <a class="d-flex align-items-center menu-item" href="{{ route('users.index') }}">
                    <i class="fas fa-users"></i>
                    <span>{{ _d('Users') }}</span>
                </a>
            @endif

            @if (\Auth::guardio('guardio.view|guardio.create|guardio.edit|guardio.delete'))
                <a class="d-flex align-items-center menu-item" href="{{ route('dashboard.guards.index') }}">
                    <i class="fas fa-users"></i>
                    <span>{{ _d('Guards') }}</span>
                </a>
            @endif

            @if (\Auth::guardio('larators'))
                <a class="d-flex align-items-center menu-item" href="{{ route('dashboard.larators.index') }}">
                    <i class="fas fa-users"></i>
                    <span>{{ _d('dashboard.larators') }}</span>
                </a>
            @endif
        @show
    </div>
</div>

<button id="btn-menu" class="d-md-none btn-menu menu-open" type="button"><i class="fas fa-bars"></i></button>