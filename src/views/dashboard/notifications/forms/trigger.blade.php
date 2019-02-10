@if (is_array(config('notifications.triggers')))
	<div class="form-group">
		<label for="trigger">{{ _d('trigger') }}</label>
		<select class="custom-select form-control" name="trigger" id="trigger">
			@foreach (array_merge(config('notifications.triggers')) as $trigger)
			<option value="{{ $trigger }}">{{ $trigger }}</option>
			@endforeach
		</select>
	</div>
@endif