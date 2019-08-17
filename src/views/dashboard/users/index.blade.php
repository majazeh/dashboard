@extends('dashboard.layouts.index')

@section('users-list')
<thead class="f2">
    <tr>
        <th class="text-center">
            {{ _d('id') }}
            @sort_icon(id)
        </th>
        <th>
            {{ _d('name') }}
            @sort_icon(name)
        </th>
        <th>
            {{ _d('username') }}
            @sort_icon(username)
        </th>
        <th>
            {{ _d('email') }}
        </th>
        <th>
            {{ _d('mobile') }}
        </th>
        <th>
            <select name="status" data-lijax="change" data-state='true'>
                <option {{!request()->status ? 'selected="selected"' : ''}} value="">{{_d('account.status')}}</option>
                @foreach ($userStatus as $key => $status)
                    <option {{request()->status == $key ? 'selected="selected"' : ''}} value="{{$key}}">{{$status}}</option>
                @endforeach
            </select>
            @sort_icon(status)
        </th>
        <th>
            <select name="type" data-lijax="change" data-state='true'>
                <option {{!request()->type ? 'selected="selected"' : ''}} value="">{{_d('account.type')}}</option>
                @foreach ($userTypes as $key => $type)
                    <option {{request()->type == $key ? 'selected="selected"' : ''}} value="{{$key}}">{{$type}}</option>
                @endforeach
            </select>
            @sort_icon(type)
        </th>
        <th class="text-center">
            <select name="gender" data-lijax="change" data-state='true'>
                <option {{!request()->gender ? 'selected="selected"' : ''}} value="">{{_d('gender')}}</option>
                <option {{request()->gender == 'female' ? 'selected="selected"' : ''}} value="female">{{_d('female')}}</option>
                <option {{request()->gender == 'male' ? 'selected="selected"' : ''}} value="male">{{_d('male')}}</option>
            </select>
            @sort_icon(gender)
        </th>
        <th></th>
    </tr>
</thead>
<tbody class="f1">
    @foreach ($users as $user)
    <tr>
        <td class="text-center">{{ $user->id }}</td>
        <td>
            <a class="text-dark" href="{{ route($module->resource . '.edit', $user->id) }}">{{ $user->name }}</a>
        </td>
        <td>{{ $user->username }}</td>
        <td>{{ $user->email }}</td>
        <td>{{ $user->mobile }}</td>
        <td class="{{ $user_status_css[$user->status] }}">
            {{ _d('status.' . $user->status) }}
        </td>
        <td>{{ _d('type.' . $user->type) }}</td>
        <td class="text-center">
            <i class="fas fa-{{ $user->gender ?: 'genderless' }} {{ $user->gender == 'male' ? 'text-primary' : ($user->gender == 'female' ? 'text-info' : '')}}"></i>
        </td>
        <td class="text-center">
            @include('dashboard.layouts.compomnents.edit-link', ['link' => route($module->resource . '.edit', $user->serial ?: $user->id)])
        </td>
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
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection