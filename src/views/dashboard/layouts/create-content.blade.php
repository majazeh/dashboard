<div class="{{$module->divPanel or 'col-12 col-md-8 col-xl-5 mx-auto'}}">
    <div class="wrapper pb-5">
        <div class="d-flex justify-content-center align-items-center wrapper-icon">
            <i class="{{ $module->icon }}"></i>
        </div>

        <form method="POST" action="{{ $module->post_action or route($module->resource . ($module->action == 'edit' ? '.update' : '.store'), isset($id) ? $id : null) }}" class="d-form">
            @csrf
            @if ($module->action == 'edit')
                @method('PUT')
            @endif
            @yield('form')
            <div class="wrapper-actions">
                <button type="submit" class="btn btn-{{ $module->action == 'edit' ? 'primary' : 'success' }} btn-action">
                    @if ($module->action == 'edit')
                    <i class="fas fa-save"></i>
                    @else
                    <i class="fas fa-check"></i>
                    @endif
                    {{ $module->header }}
                </button>
            </div>
        </form>
    </div>
</div>