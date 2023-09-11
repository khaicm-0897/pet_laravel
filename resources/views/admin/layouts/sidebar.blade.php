<div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class=" navigation-header">
                <span>Bảng điều khiển</span>
                <i class=" ft-minus" data-toggle="tooltip" data-placement="right" data-original-title="General"></i>
            </li>

            <li class="nav-item {{ Request::is('admin/users*') ? 'active' : '' }}">
                <a href="#">
                    <i class="ft-user"></i>
                    <span class="menu-title" data-i18n="">{{ trans('admin.menu.users') }}</span>
                </a>
                <ul class="menu-content">
                    <li class="{{ Request::is('admin/users') ? 'active' : '' }}">
                        <a class="menu-item" href="{{route('admin.users.index')}}">{{ trans('common.title.list') }}</a>
                    </li>
                    <li class="{{ Request::is('admin/users/create') ? 'active' : '' }}">
                        <a class="menu-item" href="{{route('admin.users.create')}}">
                            {{ trans('common.title.create') }}
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item {{ Request::is('admin/blogs*') ? 'active' : '' }}">
                <a href="#">
                    <i class="ft-user"></i>
                    <span class="menu-title" data-i18n="">{{ trans('admin.menu.blogs') }}</span>
                </a>
                <ul class="menu-content">
                    <li class="{{ Request::is('admin/blogs') ? 'active' : '' }}">
                        <a class="menu-item" href="{{route('admin.blogs.index')}}">{{ trans('common.title.list') }}</a>
                    </li>
                    <li class="{{ Request::is('admin/blogs/create') ? 'active' : '' }}">
                        <a class="menu-item" href="{{route('admin.blogs.create')}}">
                            {{ trans('common.title.create') }}
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>
