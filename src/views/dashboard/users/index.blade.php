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
                                <th class="text-center">
                                    {{ _d('id') }}
                                </th>
                                <th>
                                    {{ _d('name') }}
                                </th>
                                <th>
                                    {{ _d('username') }}
                                </th>
                                <th>
                                    {{ _d('email') }}
                                </th>
                                <th>
                                    {{ _d('mobile') }}
                                </th>
                                <th>
                                    {{ _d('account.status') }}
                                </th>
                                <th>
                                    {{ _d('account.type') }}
                                </th>
                                <th class="text-center">
                                    {{ _d('gender') }}
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
            </div>
        </div>
    </div>
</div>
@endsection