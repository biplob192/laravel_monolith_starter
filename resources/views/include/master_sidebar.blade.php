<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
        <img src="{{ asset('/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">MY COMPANY</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ route('auth.dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>

                </li>
                @role('admin')
                    {{-- <li class="nav-item">
                    <a href="{{route('users.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Users
                        </p>
                    </a>
                </li> --}}
                    {{-- <li class="nav-item">
                    <a href="{{route('attendance.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-user-clock"></i>
                        <p>
                            Attendance
                        </p>
                    </a>
                </li> --}}

                    {{-- <li class="nav-item">
                    <a href="requirements" class="nav-link">
                        <i class="nav-icon fas fa-cloud-sun-rain"></i>
                        <p>
                            Requirements
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('crop_requirements.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Index
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('crop_requirements.create')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    New Requirement
                                </p>
                            </a>
                        </li>
                    </ul>
                </li> --}}

                    <li class="nav-item">
                        <a href="crops" class="nav-link">
                            <i class="nav-icon fas fa-seedling"></i>
                            <p>
                                Crops
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('crops.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        Index
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('crops.create') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        New Crop
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('crop_requirements.create') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        New Requirement
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="categories" class="nav-link">
                            <i class="nav-icon fas fa-layer-group"></i>
                            <p>
                                Category
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('categories.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        Index
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('categories.create') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        New Category
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="seasons" class="nav-link">
                            <i class="nav-icon fas fa-sun"></i>
                            <p>
                                Season
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('seasons.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        Index
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('seasons.create') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        New Season
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    {{-- <li class="nav-item">
                    <a href="users" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Users
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('users.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Index
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('users.create')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    New User
                                </p>
                            </a>
                        </li>
                    </ul>
                </li> --}}
                @endrole
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
