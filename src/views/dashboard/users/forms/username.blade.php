<div class="form-group">
    <label for="username">{{ _d('username') }}</label>
    <div class="form-input">
        <input class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}" type="text" name="username" id="username" placeholder="{{ _d('username') }}" value="{{ isset($user->username) ? $user->username : ''}}">
        <label class="form-icon" for="username"><i class="fas fa-at"></i></label>
        @if ($errors->has('username'))
        <div class="invalid-feedback">{{ $errors->first('username') }}</div>
        @endif
    </div>
</div>