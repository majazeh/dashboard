<div class="form-group">
    <label for="to_id">{{ _d('Send to') }}</label>
    <div class="form-input">
        <select class="form-control select2-select" data-url="{{route('api.users.index')}}" data-id="id" data-title="name" name="to_id" id="to_id">
            @if (isset($product->to_id))
                <option value="{{ $product->to_id }}" selected="">{{ $product->to_name }}</option>
            @endif
        </select>
    </div>
</div>