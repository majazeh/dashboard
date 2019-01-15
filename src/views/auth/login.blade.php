@extends('dashboard.layouts.app')

@section('body-tag')
<body data-page="login" class="rtl">
    <div class="glass"></div>
    <div class="enter-card">
        <div class="d-flex justify-content-center align-items-center mb-4">
            <img src="{{ asset('images/logo.png') }}" alt="{{ _d('Logo') }}" width="30" height="30" class="enter-logo">
            <h1 class="mb-0">{{ _d('Dashio') }}</h1>
        </div>
        <form method="POST">
            @csrf
            <div class="form-group">
                <div class="form-input">
                    <input class="form-control {{ $errors->hasAny(['username', 'email', 'mobile']) ? 'is-invalid' : '' }}" type="tel" name="username" id="username" aria-describedby="usernameHelp" placeholder="{{ _d('Mobile') }}">
                    <label class="form-icon" for="username" data-toggle="tooltip" data-placement="auto" title="{{ _d('Mobile') }}">
                        <i class="fas fa-user"></i>
                    </label>
                    @if ($errors->hasAny(['username', 'email', 'mobile']))
                    <div class="invalid-feedback">{{ $errors->first('username') | $errors->first('email') | $errors->first('mobile') }}</div>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <div class="form-input">
                    <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" type="password" name="password" id="password" placeholder="{{ _d('Password') }}">
                    <label class="form-icon" for="password" data-toggle="tooltip" data-placement="auto" title="{{ _d('Password') }}">
                        <i class="fas fa-shield-alt"></i>
                    </label>
                    @if ($errors->has('password'))
                    <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                    @endif
                </div>
            </div>
            <div>
                @if (\Session::has('registerMsg'))
                <span>{{ \Session::get('registerMsg') }}</span>
                @endif
                <button type="submit" class="btn btn-block btn-primary btn-gradient">{{ _d('Login') }} / {{ _d('Register') }}</button>
                @if (config('services.google.client_id'))
                <a class="btn btn-block btn-secondary btn-gradient direct" href="/login/google">
                        <span>{{ _d('Login with Google') }}</span>
                        <img src="/images/google.svg" alt="Google" width="18">
                    </a>
                @endif
                @if(config('services.telegram.login'))
                <div>
                        @if (config('services.telegram.redirect_url'))
                            <script async src="https://telegram.org/js/telegram-widget.js?5" data-telegram-login="{{ config('services.telegram.bot') }}" data-size="medium" data-auth-url="{{ config('services.telegram.redirect_url') }}" data-request-access="{{ config('services.telegram.request_access') ? 'write' : '' }}"></script>
                        @else
                            <script async src="https://telegram.org/js/telegram-widget.js?5" data-telegram-login="{{ config('services.telegram.bot') }}" data-size="medium" data-onauth="onTelegramAuth(user)" {{ config('services.telegram.request_access') ? 'data-request-access="write"' : '' }}></script>
                    @endif
                </div>
                @endif
            </div>
        </form>
        {{-- <div class="text-center">
            <a class="recovery-link" href="#">
                {{ _d('Forgot password?') }}
            </a>
        </div> --}}
    </div>
    @include('dashboard.layouts.footer')
</body>
@endsection
