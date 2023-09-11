<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
    @include('admin.auth.head')
    @yield('style')
</head>
<body class="vertical-layout vertical-menu-modern 1-column bg-full-screen-image
    menu-expanded blank-page blank-page"
    data-open="click" data-menu="vertical-menu-modern" data-col="1-column">
    @include('admin.auth.header')
    @yield('content')
    @include('admin.auth.scripts')
</body>
</html>
