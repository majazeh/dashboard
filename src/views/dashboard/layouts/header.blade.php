<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('header-styles')
	<link rel="stylesheet" type="text/css" href="{{ asset('vendors/bootstrap-4.2.1/css/bootstrap.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('vendors/bootstrap4-rtl/bootstrap4-rtl.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('vendors/fontawesome-pro-5.7.1/css/all.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/iziToast/css/iziToast.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('vendors/select2/select2.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('vendors/Date-Time-Picker-Bootstrap-4/css/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/dashio.min.css') . '?v=' . filemtime(public_path('css/dashio.min.css'))  }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') . '?v=' . filemtime(public_path('css/main.css'))  }}">

	@if (file_exists(public_path('favicon.ico')))
	<link rel="icon" href="{{ asset('favicon.ico') }}?v={{ filemtime(public_path('favicon.ico')) }}" type="image/x-icon" />
	@endif

	@if (file_exists(public_path('apple-touch-icon.png')))
		<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}?v={{ filemtime(public_path('apple-touch-icon.png')) }}">
	@endif

	@if (file_exists(public_path('favicon-32x32.png')))
		<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}?v={{ filemtime(public_path('favicon-32x32.png')) }}">
	@endif

	@if (file_exists(public_path('favicon-16x16.png')))
		<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}?v={{ filemtime(public_path('favicon-16x16.png')) }}">
	@endif

	@if (file_exists(public_path('site.webmanifest')))
	<link rel="manifest" href="/site.webmanifest">
	@endif

	@if (file_exists(public_path('safari-pinned-tab.svg')))
		<link rel="mask-icon" href="{{ asset('safari-pinned-tab.svg') }}?v={{ filemtime(public_path('safari-pinned-tab.svg')) }}" color="#ffde00">
	@endif

	<meta name="msapplication-TileColor" content="#ffde00">
	<meta name="theme-color" content="#ffde00">
@show

<title>{{ $global->title ?: _d('Dashio') }}</title>