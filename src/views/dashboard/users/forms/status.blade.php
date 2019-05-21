@if (\Auth::guardio('users.change.status'))
<div class="form-group">
    <label>{{ _d('account.status') }}</label>
    @foreach ($userStatus as $type => $value)
    <div class="custom-control custom-radio">
        @isset ($user)
        <input type="radio" value="{{ $type }}" id="{{ $type }}" {{ $user->status == $type ? 'checked="checked"' : '' }} name="status" class="custom-control-input">
        @else
        <input type="radio" value="{{ $type }}" id="{{ $type }}" {{ $type == 'waiting' ? 'checked="checked"' : '' }} name="status" class="custom-control-input">
        @endisset
        <label class="custom-control-label f2 text-secondary" for="{{ $type }}">{{ $value }}</label>
    </div>
    @endforeach
</div>
@endif