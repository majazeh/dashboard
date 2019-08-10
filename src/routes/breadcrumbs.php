<?php
Breadcrumbs::for('dashboard', function ($trail, $data) {

    $trail->push(_d('dashboard'), route('dashboard'));
});

Breadcrumbs::for('users.index', function ($trail, $data) {
    $trail->parent('dashboard', $data);
    $trail->push(_d('users.index') . (isset($data['users']) ? ' (' . $data['users']->total() . ')' : ''), route('users.index'));
});
Breadcrumbs::for('users.create', function ($trail, $data) {
    $trail->parent('users.index', $data);
    $trail->push(_d('users.create') , route('users.create'));
});
Breadcrumbs::for('users.edit', function ($trail, $data) {
    $trail->parent('users.index', $data);
    $trail->push(_d('users.edit') , route('users.edit', $data['user']->id));
});

Breadcrumbs::for('dashboard.larators.index', function ($trail, $data) {
    $trail->parent('dashboard', $data);
    $trail->push(_d('dashboard.larators.index'), route('dashboard.larators.index'));
});
?>