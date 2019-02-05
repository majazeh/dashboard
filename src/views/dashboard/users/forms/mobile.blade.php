<div class="form-group">
    <label for="mobile">{{ _d('mobile') }}</label>
    <div class="form-input">
        <input class="form-control {{ $errors->has('mobile') ? 'is-invalid' : '' }}" type="tel" name="mobile" id="mobile" placeholder="{{ _d('mobile') }}" value="{{ isset($user->mobile) ? $user->mobile : ''}}">
        <label class="form-icon" for="mobile"><i class="fas fa-mobile-alt"></i></label>
        @if ($errors->has('mobile'))
        <div class="invalid-feedback">{{ $errors->first('mobile') }}</div>
        @endif
    </div>
</div>