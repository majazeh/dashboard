<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('header-styles')
	<link rel="stylesheet" type="text/css" href="{{ asset('vendors/bootstrap-4.1.3/bootstrap.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('vendors/bootstrap4-rtl/bootstrap4-rtl.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('vendors/fontawesome-5.2.0/css/all.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('vendors/iziToast/css/iziToast.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/dashio.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
@show

<title>{{ $global->title ?: _d('Dashio') }}</title>