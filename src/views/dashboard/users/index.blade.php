@extends('dashboard.layouts.index')

@section('index.content')
<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr class="d-form">
                <th>#</th>

                <th>
                    <div class="form-group mb-0">
                        <input class="form-control" type="text" name="name" id="name" placeholder="{{ _d('name') }}">
                        <label for="name">
                            <i class="fas fa-user-tag"></i>
                        </label>
                    </div>
                </th>

                <th>
                    <div class="form-group mb-0">
                        <input class="form-control" type="text" name="username" id="username" placeholder="{{ _d('username') }}">
                        <label for="username">
                            <i class="fas fa-at"></i>
                        </label>
                    </div>
                </th>

                <th>
                    <div class="form-group mb-0">
                        <input class="form-control" type="text" name="email" id="email" placeholder="{{ _d('email') }}">
                        <label for="email">
                            <i class="fas fa-envelope"></i>
                        </label>
                    </div>
                </th>

                <th>
                    <div class="form-group mb-0">
                        <input class="form-control" type="text" name="mobile" id="mobile" placeholder="{{ _d('mobile') }}">
                        <label for="mobile">
                            <i class="fas fa-mobile-alt"></i>
                        </label>
                    </div>
                </th>

                <th>{{ _d('account.status') }}</th>

                <th>{{ _d('account.type') }}</th>

                <th>{{ _d('gender') }}</th>

                <th>
                    <i class="fas fa-cogs"></i>
                </th>
            </tr>
        </thead>

        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>
                    <a href="{{ route($module->resource . '.edit', $user->id) }}">{{ $user->id }}</a>
                </td>

                <td>{{ $user->name }}</td>

                <td>{{ $user->username }}</td>

                <td>{{ $user->email }}</td>

                <td>{{ $user->mobile }}</td>

                <td>
                    {{ _d('status.' . $user->status) }}
                </td>

                <td>{{ _d('type.' . $user->type) }}</td>

                <td class="text-center">
                    <i class="fas fa-{{ $user->gender ?: 'genderless' }} {{ $user->gender == 'male' ? 'text-primary' : ($user->gender == 'female' ? 'text-info' : '')}}"></i>
                </td>

                <td class="text-center">
                    <a href="{{ route($module->resource . '.edit', $user->id) }}">
                        <i class="fas fa-edit text-secondary"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $users->links() }}
</div>
@endsection
