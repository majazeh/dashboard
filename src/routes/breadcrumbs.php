<?php
Breadcrumbs::for('dashboard', function ($trail, $data) {

    $trail->push(_d('dashboard'), route('dashboard'));
});
?>