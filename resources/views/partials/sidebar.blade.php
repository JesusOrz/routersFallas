<aside id="sidebar">
    <div class="h-100">
        <div class="sidebar-logo">
            <h3 class="sidebar-item">Bienvenido {{ Auth::user()->name ?? 'Usuario' }} !!</h3>
        </div>

        <hr class="sidebar-divider my-0">

        <ul class="sidebar-nav">
            <li class="sidebar-header">CORE</li>

            <li class="sidebar-item">
                <a href="{{ route('dashboard') }}"
                   title="Dashboard"
                   class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer"></i>
                    Dashboard
                </a>
            </li>

            <hr class="sidebar-divider my-0">

            <li class="sidebar-header">TOOLS</li>

            {{-- Registros --}}
            <li class="sidebar-item">
                <a href="#" 
                   class="sidebar-link {{ request()->routeIs('keysTable', 'routersTable', 'analysisTable') ? '' : 'collapsed' }}"
                   data-bs-toggle="collapse" 
                   data-bs-target="#registros"
                   aria-expanded="{{ request()->routeIs('keysTable', 'routersTable', 'analysisTable') ? 'true' : 'false' }}"
                   aria-controls="registros">
                    <i class="fa-regular fa-file-lines pe-2"></i>
                    Registros
                </a>
                <ul id="registros" 
                    class="sidebar-dropdown list-unstyled collapse {{ request()->routeIs('keysTable', 'routersTable', 'analysisTable') ? 'show' : '' }}"
                    data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                        <a href="{{ route('keysTable') }}"
                           class="sidebar-link {{ request()->routeIs('keysTable') ? 'active' : '' }}">
                            Mis Keys
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="{{ route('routersTable') }}"
                           class="sidebar-link {{ request()->routeIs('routersTable') ? 'active' : '' }}">
                            Mis Routers
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="{{ route('analysisTable') }}"
                           class="sidebar-link {{ request()->routeIs('analysisTable') ? 'active' : '' }}">
                            Tipos de Analisís
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Análisis --}}
            <li class="sidebar-item">
                <a href="#" 
                   class="sidebar-link {{ request()->routeIs('logs', 'cargar-logs') ? '' : 'collapsed' }}"
                   data-bs-toggle="collapse" 
                   data-bs-target="#auth"
                   aria-expanded="{{ request()->routeIs('logs', 'cargar-logs') ? 'true' : 'false' }}"
                   aria-controls="auth">
                    <i class="fa-solid fa-magnifying-glass-chart"></i>
                    Analisís
                </a>
                <ul id="auth"
                    class="sidebar-dropdown list-unstyled collapse {{ request()->routeIs('logs', 'cargar-logs') ? 'show' : '' }}"
                    data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                        <a href="{{ route('logs') }}"
                           class="sidebar-link {{ request()->routeIs('logs') ? 'active' : '' }}">
                            Analizar Log
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="{{ route('cargar-logs') }}"
                           class="sidebar-link {{ request()->routeIs('cargar-logs') ? 'active' : '' }}">
                            Cargar Archivo
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</aside>
