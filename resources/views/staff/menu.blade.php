<li class="nav-item">
    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->is('admin') ? 'active' : '' }}">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>
            Dashboard
        </p>
    </a>
</li>
<li class="nav-item {{ request()->is('admin/students', 'admin/students/*') ? 'menu-open' : '' }}">
    <a href="{{ route('students.list') }}"
        class="nav-link {{ request()->is('admin/students', 'admin/students/*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-user"></i>
        <p>
            Students
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('students.list') }}" class="nav-link {{ request()->is('admin/students') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Students List</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('create.student') }}"
                class="nav-link {{ request()->is('admin/students/create', 'admin/students/create/*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Create Student</p>
            </a>
        </li>
    </ul>
</li>
<li class="nav-item {{ request()->is('admin/society', 'admin/society/*') ? 'menu-open' : '' }}">
    <a href="{{ route('society.list') }}"
        class="nav-link {{ request()->is('admin/society', 'admin/society/*') ? 'active' : '' }}">
        <i class="nav-icon fa-solid fa-house-chimney-user"></i>
        <p>
            Societies
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('society.list') }}"
                class="nav-link {{ request()->is('admin/society') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Societies List</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('societies.view') }}"
                class="nav-link {{ request()->is('admin/society/view', 'admin/society/view/*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>View all Societies</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('view.society.registrationforms') }}"
                class="nav-link {{ request()->is('admin/society/registrationforms') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Registration Forms</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('create.society') }}"
                class="nav-link {{ request()->is('admin/society/create', 'admin/society/create/*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Create Society</p>
            </a>
        </li>
    </ul>
</li>



{{-- <li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-th"></i>
        <p>
            Simple Link
            <span class="right badge badge-danger">New</span>
        </p>
    </a>
</li> --}}
