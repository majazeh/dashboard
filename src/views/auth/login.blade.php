@extends('dashboard.layouts.app')

@section('body-tag')
<body data-page="login" class="rtl">
    <div class="glass"></div>

    <div class="enter-card">
        <div class="d-flex justify-content-center align-items-center mb-4">
            <img src="/images/cube.png" alt="logo" width="30" height="30" class="enter-logo">
            <h1 class="mb-0">{{ _d('dashboard') }}</h1>
        </div>

        <form class="d-form mb-3" method="POST">
            @csrf
            <div class="form-group">
            <input class="form-control {{ $errors->hasAny(['username', 'email', 'mobile']) ? 'is-invalid' : '' }}" type="tel" name="username" id="username" aria-describedby="usernameHelp" placeholder="موبایل">
                <label for="username" data-toggle="tooltip" data-placement="auto" title="موبایل">
                    <i class="fas fa-user"></i>
                </label>
                @if ($errors->hasAny(['username', 'email', 'mobile']))
                    <div class="invalid-feedback">{{ $errors->first('username') | $errors->first('email') | $errors->first('mobile') }}</div>
                @endif
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
            <div>
                @if (\Session::has('registerMsg'))
                    <span>{{ \Session::get('registerMsg') }}</span>
                @endif
                <button type="submit" class="btn btn-gradient btn-rounded btn-block btn-enter fs-medium font-weight-xlight">{{ _d('login/register') }}</button>
                @if (config('services.google.client_id'))
                    <a class="btn btn-block btn-rounded btn-block btn-enter btn-google fs-medium font-weight-xlight direct" href="/login/google">
                        <span>{{ _d('google.login') }}</span>
                        <img src="/images/google.svg" alt="Google" width="18">
                    </a>
                @endif
                @if(config('services.telegram.login'))
                <div class="form-group">
                        @if (config('services.telegram.redirect_url'))
                            <script async src="https://telegram.org/js/telegram-widget.js?5" data-telegram-login="{{ config('services.telegram.bot') }}" data-size="medium" data-auth-url="{{ config('services.telegram.redirect_url') }}" {{ config('services.telegram.request_access') ? 'data-request-access="write"' : '' }}></script>
                        @else
                            <script async src="https://telegram.org/js/telegram-widget.js?5" data-telegram-login="{{ config('services.telegram.bot') }}" data-size="medium" data-onauth="onTelegramAuth(user)" {{ config('services.telegram.request_access') ? 'data-request-access="write"' : '' }}></script>
                    @endif
                </div>
                @endif
            </div>
        </form>

        <div class="text-center">
            <a class="recovery-link" href="#">
                کلمه‌ی عبورم را فراموش کرده‌ام
            </a>
        </div>
    </div>
    @include('dashboard.layouts.footer')
</body>
@endsection
