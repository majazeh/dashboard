<div class="form-group">
    <label for="name">
        {{ _d('name') }} <small class="text-secondary">{{_d('optional')}}</small>
    </label>
    <div class="form-input">
        <input class="form-control" type="text" name="name" id="name" placeholder="{{ _d('name') }}" value="{{ isset($user->name) ? $user->name : ''}}">

        <label for="name" class="form-icon">
            <i class="fas fa-user-tag"></i>
        </label>
    </div>
</div>