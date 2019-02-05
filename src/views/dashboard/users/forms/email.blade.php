<div class="form-group">
    <label for="email">{{ _d('email') }}</label>
    <div class="form-input">
        <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" placeholder="{{ _d('email') }}" value="{{ isset($user->email) ? $user->email : ''}}">
        <label class="form-icon" for="email"><i class="fas fa-envelope"></i></label>
        @if ($errors->has('email'))
        <div class="invalid-feedback">{{ $errors->first('email') }}</div>
        @endif
    </div>
</div>