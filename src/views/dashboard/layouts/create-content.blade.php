<div class="{{$module->divPanel ?: 'col-12 col-md-8 col-xl-5 mx-auto'}}">
    <form method="POST" {!! isset($multipart) ? 'enctype="multipart/form-data"' : '' !!} action="{{ $module->post_action ?: route($module->resource . ($module->action == 'edit' ? '.update' : '.store'), isset($id) ? $id : null) }}" class="d-form">
        @csrf
        @if ($module->action == 'edit')
            @method('PUT')
        @endif
        @yield('form')
        <div>
            <button type="submit" class="btn btn-{{ $module->action == 'edit' ? 'primary' : 'success' }} btn-gradient btn-action">
                @if (false)
                    @if ($module->action == 'edit')
                    <i class="fas fa-save"></i>
                    @else
                    <i class="fas fa-check"></i>
                    @endif
                @endif
                {{ $module->header }}
            </button>
        </div>
    </form>
</div>
