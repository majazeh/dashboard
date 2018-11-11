@extends('dashboard.layouts.index')

@section('index.content')
<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead class="f1">
            <tr>
                <th class="text-center">
                    {{ _d('id') }}
                    <i class="fas fa-sort text-black-50"></i>
                </th>
                <th>
                    {{ _d('name') }}
                    <i class="fas fa-sort text-black-50"></i>
                </th>
                <th>
                    {{ _d('username') }}
                    <i class="fas fa-sort text-black-50"></i>
                </th>
                <th>
                    {{ _d('email') }}
                    <i class="fas fa-sort text-black-50"></i>
                </th>
                <th>
                    {{ _d('mobile') }}
                    <i class="fas fa-sort text-black-50"></i>
                </th>
                <th>
                    {{ _d('account.status') }}
                    <i class="fas fa-sort text-black-50"></i>
                </th>
                <th>
                    {{ _d('account.type') }}
                    <i class="fas fa-sort text-black-50"></i>
                </th>
                <th class="text-center">
                    {{ _d('gender') }}
                    <i class="fas fa-sort text-black-50"></i>
                </th>
                <th></th>
            </tr>
        </thead>
        <tbody class="f2">
            @foreach ($users as $user)
            <tr>
                <td class="text-center">
                    {{ $user->id }}
                </td>
                <td>
                    <a class="text-dark" href="{{ route($module->resource . '.edit', $user->id) }}">
                        {{ $user->name }}
                    </a>
                </td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->mobile }}</td>
                <td class="{{ ['active' => 'text-success', 'waiting' => 'text-warning', 'block' => 'text-danger'][$user->status] }}">
                    {{ _d('status.' . $user->status) }}
                </td>
                <td>{{ _d('type.' . $user->type) }}</td>
                <td class="text-center">
                    <i class="fas fa-{{ $user->gender ?: 'genderless' }} {{ $user->gender == 'male' ? 'text-primary' : ($user->gender == 'female' ? 'text-info' : '')}}"></i>
                </td>
                <td class="d-flex justify-content-around">
                    <a class="text-secondary" href="{{ route($module->resource . '.edit', $user->id) }}">
                        <i class="fas fa-edit"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $users->links() }}
</div>
@endsection