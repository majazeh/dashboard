<div class="form-group">
    <label for="password">{{ _d('password') }}</label>
    <div class="form-input">
        <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" type="password" name="password" id="password" placeholder="{{ _d('password') }}">
        <label class="form-icon" for="password"><i class="fas fa-shield-alt"></i></label>
        @if ($errors->has('password'))
        <div class="invalid-feedback">{{ $errors->first('password') }}</div>
        @endif
    </div>
</div>