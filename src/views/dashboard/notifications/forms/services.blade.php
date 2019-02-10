<div class="form-group">
    <label for="services">{{ _d('services') }}</label>
    <select class="custom-select form-control" name="services" id="services">
        @foreach (array_merge(['web'], config('notifications.services', [])) as $service)
        	<option value="{{ $service }}">{{ $service }}</option>
        @endforeach
    </select>
</div>