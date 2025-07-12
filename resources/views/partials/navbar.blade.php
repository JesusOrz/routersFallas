<nav class="navbar navbar-expand-lg navbar-light bg-light px-3 border-bottom">
    <div class="d-flex align-items-center">
        <!-- Botón del menú (sidebar toggle) -->
        <button class="btn me-2" id="sidebarToggle">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Logo y nombre del sistema -->
        <a class="navbar-brand d-flex align-items-center" href="{{ route('dashboard') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" height="40" class="me-2">
            <span class="fw-bold ">Mubu Network</span>
        </a>
    </div>

    <!-- Dropdown de usuario -->
    <ul class="navbar-nav ms-auto">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-user-circle fa-lg me-1"></i>
                {{ Auth::user()->name ?? 'Usuario' }}
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                <!-- Opción de Ayuda -->
                <li>
                    <a class="dropdown-item" href="#" onclick="toggleChatbot(); return false;">
                        <i class="bi bi-question-circle-fill me-2"></i> Ayuda
                    </a>
                </li>

                <li><hr class="dropdown-divider"></li>

                <!-- Logout -->
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item">
                            <i class="fas fa-sign-out-alt me-2"></i> Cerrar sesión
                        </button>
                    </form>
                </li>
            </ul>
        </li>
    </ul>
</nav>
