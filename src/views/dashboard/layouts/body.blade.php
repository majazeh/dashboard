<div id="sidebar" class="d-none d-sm-flex sidebar">
	@section('body-menu')
		@include('dashboard.layouts.menu')
	@show
	@section('body-desktop')
		@include('dashboard.layouts.desktop')
	@show
</div>

<button id="btn-menu" class="d-sm-none btn-menu menu-open" type="button">
<i class="fas fa-btn-menu"></i>
</button>

<div id="content" class="content">

	@section('body-topbar')
		@include('dashboard.layouts.topbar')
	@show
	
	@section('main-tag')
		@include('dashboard.layouts.main')
	@show
</div>

@include('dashboard.layouts.footer')