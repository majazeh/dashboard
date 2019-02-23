<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('header-styles')
	<link rel="stylesheet" type="text/css" href="{{ asset('vendors/bootstrap-4.2.1/css/bootstrap.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('vendors/bootstrap4-rtl/bootstrap4-rtl.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('vendors/fontawesome-pro-5.7.1/css/all.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/iziToast/css/iziToast.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('vendors/select2/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/dashio.min.css') . '?v=' . filemtime(public_path('css/dashio.min.css'))  }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') . '?v=' . filemtime(public_path('css/main.css'))  }}">
@show

<title>{{ $global->title ?: _d('Dashio') }}</title>