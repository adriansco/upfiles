@can('ver-dashboard')
    <li class="side-menus {{ Request::is('home') ? 'active' : '' }}">
        <a class="nav-link" href="/home">
            <i class=" fas fa-building"></i><span>Dashboard</span>
        </a>
    </li>
@endcan

@can('ver-usuario')
    <li class="side-menus {{ Request::is('users*') ? 'active' : '' }}">
        <a class="nav-link" href="/users">
            <i class=" fas fa-user-lock"></i><span>Usuarios</span>
        </a>
    </li>
@endcan

<li class="side-menus nav-item dropdown {{ Request::is('fetch-*') || Request::is('employees*') ? 'active' : '' }}">
    <a href="#" class="nav-link has-dropdown"><i class="fas fa-users"></i><span>Empleados</span></a>
    <ul class="dropdown-menu">
        <li class="{{ Request::is('fetch-employees/A') ? 'active' : '' }}"><a class="nav-link"
                href="{{ route('employees.fetch', 'A') }}">Activos</a></li>
        <li class="{{ Request::is('fetch-employees/B') ? 'active' : '' }}"><a class="nav-link"
                href="{{ route('employees.fetch', 'B') }}">Bajas</a>
        </li>
    </ul>
</li>

@can('ver-rol')
    <li class="side-menus {{ Request::is('roles*') ? 'active' : '' }}">
        <a class="nav-link" href="/roles">
            <i class="fas fa-lock"></i><span>Roles</span>
        </a>
    </li>
@endcan
