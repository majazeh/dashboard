@extends('dashboard.layouts.index')

@section('container-fluid')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="f2">
                            <tr>
                                <th>
                                    {{ _d('title') }}
                                    @sort_icon(title)
                                </th>
                                <th>
                                    {{ _d('description') }}
                                </th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="f1">
                            @foreach ($guards as $guard)
                            <tr>
                               <td>
                                <a href="{{ route('dashboard.guards.positions.index', $guard->id) }}">{{$guard->title}}</a>
                               </td>
                               <td>
                                   {{$guard->description}}
                               </td>
                                <td class="text-center">
                                    <a class="text-secondary" href="{{ route($module->resource . '.edit', $guard->id) }}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $guards->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection