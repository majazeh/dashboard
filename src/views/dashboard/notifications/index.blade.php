@extends('dashboard.layouts.index')
@if(!\Auth::guardio('notifications.edit|notifications.create'))
@section('topbar-actions')@show
@endif
@section('users-list')
<thead class="f2">
    <tr>
        <th class="text-center">
            {{ _d('time') }}
            @sort_icon(time)
        </th>
        <th class="text-center">
            {{ _d('from') }}
            @sort_icon(from)
        </th>
        <th>
            {{ _d('to') }}
            @sort_icon(to)
        </th>
        <th>
            {{ _d('title') }}
            @sort_icon(title)
        </th>
        <th>
            {{ _d('status') }}
            @sort_icon(status)
        </th>
        <th></th>
    </tr>
</thead>
<tbody class="f1">
    @foreach ($notifications as $notification)
    <tr>
        <td class="text-center">{{ $notification->created_at }}</td>
        <td class="text-center">{{ $notification->from_id }}</td>
        <td class="text-center">{{ $notification->to_id }}</td>
        <td class="text-center">{{ $notification->title }}</td>
        <td class="text-center">{{ $notification->status }}</td>
        <td></td>
    </tr>
    @endforeach
</tbody>
@endsection

@section('container-fluid')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        @yield('users-list')
                    </table>
                    {{ $notifications->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection