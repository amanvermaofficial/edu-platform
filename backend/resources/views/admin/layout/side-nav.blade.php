<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src={{ asset('admin/dist/img/AdminLTELogo.png') }} alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Admin</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src={{ asset('admin/dist/img/user2-160x160.jpg') }} class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ auth()->user()->name }}</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                @can('users.view')
                    <li class="nav-item">
                        <a href="{{ route('admin.users.index') }}"
                            class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Users</p>
                        </a>
                    </li>
                @endcan
                @can('students.view')
                    <li class="nav-item">
                        <a href="{{ route('admin.students.index') }}"
                            class="nav-link {{ request()->routeIs('admin.students.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-graduate"></i>
                            <p>Students</p>
                        </a>
                    </li>
                @endcan

                @can('quizzes.view')
                    <li class="nav-item {{ request()->routeIs('admin.quizzes.*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-question-circle"></i>
                            <p>
                                Quizzes
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">

                            <li class="nav-item">
                                <a href="{{ route('admin.quizzes.index') }}"
                                    class="nav-link {{ request()->routeIs('admin.quizzes.index') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>All Quizzes</p>
                                </a>
                            </li>
                            @can('quiz-questions.import')
                                <li class="nav-item">
                                    <a href="{{ route('admin.quiz.questions.import') }}"
                                        class="nav-link {{ request()->routeIs('admin.quiz.questions.import') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Upload Questions (CSV)</p>
                                    </a>
                                </li>
                            @endcan

                            @can('quiz-attempts.view')
                                <li class="nav-item">
                                    <a href="{{ route('admin.quiz-attempts.index') }}"
                                        class="nav-link {{ request()->routeIs('admin.quiz-attempts.*') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-clipboard-list"></i>
                                        <p>Quiz Attempts</p>
                                    </a>
                                </li>
                            @endcan

                        </ul>

                    </li>
                @endcan
                @can('roles.view')
                    <li
                        class="nav-item {{ request()->routeIs('admin.roles.*') || request()->routeIs('admin.permissions.*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link">
                            <p>
                                Roles & Permissions
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">
                            @can('roles.view')
                                <li class="nav-item">
                                    <a href="{{ route('admin.roles.index') }}"
                                        class="nav-link {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Roles</p>
                                    </a>
                                </li>
                            @endcan
                            @can('permissions.view')
                                <li class="nav-item">
                                    <a href="{{ route('admin.permissions.index') }}"
                                        class="nav-link {{ request()->routeIs('admin.permissions.*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Permissions</p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('courses.view')
                    <li
                        class="nav-item {{ request()->routeIs('admin.courses.*') || request()->routeIs('admin.trades.*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link">
                            <p>
                                Courses & Trades
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">
                            @can('courses.view')
                                <li class="nav-item">
                                    <a href="{{ route('admin.courses.index') }}"
                                        class="nav-link {{ request()->routeIs('admin.courses.*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Courses</p>
                                    </a>
                                @endcan
                            </li>

                            @can('trades.view')
                                <li class="nav-item">
                                    <a href="{{ route('admin.trades.index') }}"
                                        class="nav-link {{ request()->routeIs('admin.trades.*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Trades</p>
                                    </a>
                                </li>
                            @endcan


                        </ul>
                    </li>
                @endcan
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
