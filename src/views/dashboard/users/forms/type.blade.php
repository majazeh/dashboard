@if (\Auth::guardio('users.change.type'))
<div class="form-group">
    <label for="type">{{ _d('user.type') }}</label>
    <select class="custom-select form-control" name="type" id="type">
        @foreach ($userTypes as $type => $value)
        @isset ($user)
        <option value="{{ $type }}" {{ $user->type == $type ? 'selected="selected"' : '' }}>{{ $value }}</option>
        @else
        <option value="{{ $type }}" {{ $type == 'user' ? 'selected="selected"' : '' }}>{{ $value }}</option>
        @endisset
        @endforeach
    </select>
</div>
@endif