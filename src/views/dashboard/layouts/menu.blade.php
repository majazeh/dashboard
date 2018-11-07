<nav id="menu" class="d-none d-sm-flex flex-wrap flex-sm-nowrap flex-sm-column align-items-stretch menu menu-optional">
    <div id="branding-logo" class="d-none d-sm-flex align-items-center justify-content-center branding branding-logo">
        <a class="branding-logo-img" href="{{ env('APP_URL') }}">
			<img src="{{ env('APP_LOGO_50', asset('images/logo/logo-50.png')) }}" alt="cube" width="50" height="50">
		</a>
    </div>
	@section('menu-itmes')
	    <a href="{{ route('dashboard') }}" class="f3 f-sm-1 d-flex flex-column justify-content-center align-items-center text-white text-center menu-item">
			<i class="fas fa-tachometer-alt mb-1"></i>
			<span>پیشخوان</span>
		</a>

		<a href="{{ route('users.index') }}" class="f3 f-sm-1 d-flex flex-column justify-content-center align-items-center text-white text-center menu-item">
			<i class="fas fa-user"></i>
			<span>{{ _d('users') }}</span>
		</a>
	@show
</nav>