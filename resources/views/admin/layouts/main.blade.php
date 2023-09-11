<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
    <head>
        @include('admin.layouts.head')
        @yield('style')
    </head>
    <body class="vertical-layout vertical-menu-modern 2-columns menu-expanded fixed-navbar"
        data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">
        <div class="preloader">
            <div class="clear-loading loading-effect-2">
                <span></span>
            </div>
        </div>
        @include('admin.layouts.header')
        @include('admin.layouts.sidebar')
        <div class="app-content content">
            <div class="content-wrapper">
                @include('admin.layouts.breadcrumb')
                <div class="content-body">
                    @yield('content')
                </div>
            </div>
        </div>
        @include('admin.layouts.footer')
        @include('admin.layouts.scripts')
        @yield('scripts')
    </body>
</html>
