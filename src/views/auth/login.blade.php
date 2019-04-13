@extends('dashboard.layouts.app')

@section('body-tag')
<body data-page="login" class="rtl">
    <div class="glass"></div>
    <div class="enter-card">
        <div class="mb-4">
            <div class="text-center mb-2"><img src="{{ asset('images/logo-40.png') }}" alt="{{ _d('title.dashio') }}" width="50" height="50"></div>
            <h1 class="mb-0">{{ _d('title.dashio') }}</h1>
        </div>
        <form method="POST">
            @csrf
            <div class="form-group">
                <div class="form-input">
                    <input class="form-control {{ $errors->hasAny(['username', 'email', 'mobile']) ? 'is-invalid' : '' }}" type="text" name="username" id="username" placeholder="{{ ucfirst(_d('mobile')) }}">
                    <label class="form-icon" for="username" data-toggle="tooltip" data-placement="auto" title="{{ ucfirst(_d('mobile')) }}"><i class="fas fa-user"></i></label>
                    @if ($errors->hasAny(['username', 'email', 'mobile']))
                    <div class="invalid-feedback">{{ $errors->first('username') | $errors->first('email') | $errors->first('mobile') }}</div>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <div class="form-input">
                    <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" type="password" name="password" id="password" placeholder="{{ ucfirst(_d('password')) }}">
                    <label class="form-icon" for="password" data-toggle="tooltip" data-placement="auto" title="{{ ucfirst(_d('password')) }}"><i class="fas fa-shield-alt"></i></label>
                    @if ($errors->has('password'))
                    <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                    @endif
                </div>
            </div>

            <div>
                @if (\Session::has('registerMsg'))
                <span>{{ \Session::get('registerMsg') }}</span>
                @endif
                @if (isset($token))
                    <button type="submit" class="btn btn-block btn-primary btn-gradient">{{ ucfirst(_d('reset.password')) }}</button>
                    <a href="{{route('login')}}" class="btn btn-block btn-success btn-gradient">{{ ucfirst(_d('login')) }} / {{ ucfirst(_d('register')) }}</a>
                @else
                    <button type="submit" class="btn btn-block btn-primary btn-gradient">{{ ucfirst(_d('login')) }}
                        @if (config('auth.enter.revovery', false))
                        / {{ ucfirst(_d('register')) }}
                        @endif
                    </button>
                    @if (config('auth.enter.revovery', true))
                    <button name="reset" value="true" type="submit" class="btn btn-block btn-secondary btn-gradient">{{ _d('Password reset') }}</button>
                    @endif
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
                @endif
            </div>
        </form>
    </div>
</body>
@endsection
