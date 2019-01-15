<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

<head>
    @include('dashboard.layouts.header')
</head>

@section('body-tag')
<body class="d-flex rtl">
    @section('body')
    @include('dashboard.layouts.body')
    @show
</body>
@show

</html>
