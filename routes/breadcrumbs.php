<?php

use Diglactic\Breadcrumbs\Breadcrumbs;

// Base Title
$baseTitle = [
    'list' => trans('common.title.list') . ' ',
    'create' => trans('common.title.create') . ' ',
    'edit' => trans('common.title.edit') . ' ',
];

// <!--------- Users ---------!>
Breadcrumbs::for('users', function ($trail) {
    $trail->push(trans('admin.menu.users'), route('admin.users.index'));
});
// Users > index
Breadcrumbs::for('admin-users-index', function ($trail) use ($baseTitle) {
    $trail->parent('users');
    $trail->push($baseTitle['list'] . trans('admin.menu.users'), route('admin.users.index'));
});
// Users > create
Breadcrumbs::for('admin-users-create', function ($trail) use ($baseTitle) {
    $trail->parent('users');
    $trail->push($baseTitle['create'] . trans('admin.menu.users'), route('admin.users.create'));
});
// Users > edit
Breadcrumbs::for('admin-users-edit', function ($trail) use ($baseTitle) {
    $trail->parent('users');
    $trail->push($baseTitle['edit'] . trans('admin.menu.users'));
});

// <!--------- Blogs ---------!>
Breadcrumbs::for('blogs', function ($trail) {
    $trail->push(trans('admin.menu.blogs'), route('admin.blogs.index'));
});
// Blog > index
Breadcrumbs::for('admin-blogs-index', function ($trail) use ($baseTitle) {
    $trail->parent('blogs');
    $trail->push($baseTitle['list'] . trans('admin.menu.blogs'), route('admin.blogs.index'));
});
// Blog > create
Breadcrumbs::for('admin-blogs-create', function ($trail) use ($baseTitle) {
    $trail->parent('blogs');
    $trail->push($baseTitle['create'] . trans('admin.menu.blogs'), route('admin.blogs.create'));
});
// Blog > edit
Breadcrumbs::for('admin-blogs-edit', function ($trail) use ($baseTitle) {
    $trail->parent('blogs');
    $trail->push($baseTitle['edit'] . trans('admin.menu.blogs'));
});
