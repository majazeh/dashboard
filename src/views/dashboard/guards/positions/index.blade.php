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
                            </tr>
                        </thead>
                        @foreach ($positions as $k => $groups)
                        <tbody class="f1">
                            <tr>
                                <th colspan="2">
                                    {{$k}}
                                </th>
                            </tr>
                        @foreach ($groups as $key => $position)
                            <tr>
                               <td>
                                   <label for="for-{{$key}}">
                                       {{$key}}
                                   </label>
                               </td>
                               <td>
                                <label class="switch">
                                    <input type="checkbox" {{ $position ? 'checked' : '' }} data-lijax='change' data-method='PATCH' data-action='{{route('dashboard.guards.positions.update', [$guard->id, $key])}}' data-name='status' id="for-{{$key}}">
                                    <span class="slider round"></span>
                                </label>
                               </td>
                            </tr>
                        @endforeach
                        </tbody>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection