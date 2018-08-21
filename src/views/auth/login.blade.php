@extends('dashboard.layouts.app')

@section('body-tag')
<body data-page="login" class="rtl">
	<div class="glass"></div>

    <div class="login-card">
        <div class="d-flex justify-content-center align-items-center mb-4">
            <img src="/images/cube.png" alt="logo" width="30" height="30" class="mr-1">
            <h1 class="mb-0">داشبورد</h1>
        </div>

        <form class="d-form-group was-validated" method="POST">
            @csrf
            <div class="form-group">
            <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="tel" name="mobile" id="mobile" aria-describedby="mobileHelp" placeholder="موبایل">
                <label for="mobile" data-toggle="tooltip" data-placement="auto" title="موبایل">
                    <i class="fas fa-mobile-alt"></i>
                </label>
                @if ($errors->has('email'))
                    <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                @endif
                <!--<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>-->
            </div>

            <div class="form-group">
                <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" type="password" name="password" id="password" placeholder="کلمه‌ی عبور">
                <label for="password" data-toggle="tooltip" data-placement="auto" title="کلمه‌ی عبور">
                    <i class="fas fa-shield-alt"></i>
                </label>
                @if ($errors->has('password'))
                    <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                @endif
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-gradient btn-rounded font-weight-xlight">ورود / ‌ثبت‌ نام</button>
                <a class="btn btn-block btn-rounded btn-login btn-google my-3" href="#">
                    <span class="font-weight-xlight">ورود با گوگل</span>
                    <img src="/images/google.svg" alt="Google" width="18">
                </a>
            </div>
        </form>
        <div class="text-forget text-center">
            <a href="#">کلمه‌ی عبورم را فراموش کرده‌ام</a>
        </div>
    </div>
	@include('dashboard.layouts.footer')
</body>
@endsection
