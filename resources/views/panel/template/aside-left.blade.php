<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('panel.main.index') }}" class="brand-link">
        <img src="{{ asset('Auth-Panel/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{ env('APP_NAME') }}</span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ env('APP_URL') }}/storage/{{ auth()->user()->photo }}" class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ auth()->user()->name ?? 'Desconhecido' }}</a>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-flat" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item has-treeview {{ request()->is('painel-de-controle') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('painel-de-controle') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('panel.main.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Principal</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview {{ request()->is('users') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('users') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-user"></i>
                        <p>
                            Usuários
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('panel.users.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Lista</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview" {{ request()->is('accesses') ? 'menu-open' : '' }}>
                    <a href="#" class="nav-link {{ request()->is('accesses') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-key"></i>
                        <p>
                            Perfis
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('panel.accesses.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Lista</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>
