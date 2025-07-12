<aside id="sidebar">
    <div class="h-100">
        <div class="sidebar-logo">
            <h3 class="sidebar-item">Bienvenido {{ Auth::user()->name ?? 'Usuario' }} !!</h3>
        </div>

        <ul class="sidebar-nav">
            <li class="sidebar-header">CORE</li>

            <li class="sidebar-item">
                <a href="{{ route('dashboard') }}" title="Dashboard" class="sidebar-link">
                    <i class="bi bi-speedometer"></i> 
                    Dashboard
                </a>
            </li>

            <li class="sidebar-header">TOOLS</li>

            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed" data-bs-toggle="collapse" data-bs-target="#registros"
                    aria-expanded="false" aria-controls="registros">
                    <i class="fa-regular fa-file-lines pe-2"></i>
                    Registros
                </a>
                <ul id="registros" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item"><a href="{{ route('keysTable') }}" class="sidebar-link">Mis Keys</a></li>
                    <li class="sidebar-item"><a href="{{ route('routersTable') }}" class="sidebar-link">Mis Routers</a></li>
                    <li class="sidebar-item"><a href="{{ route('analysisTable') }}" class="sidebar-link">Tipos de Analisís</a></li>
                </ul>
            </li>

            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed" data-bs-toggle="collapse" data-bs-target="#auth"
                    aria-expanded="false" aria-controls="auth">
                    <i class="fa-solid fa-magnifying-glass-chart"></i>
                    Analisís
                </a>
                <ul id="auth" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item"><a href="{{ route('logs') }}" class="sidebar-link">Analizar Log</a></li>
                    <li class="sidebar-item"><a href="{{ route('cargar-logs') }}" class="sidebar-link">Cargar Archivo</a></li>
                </ul>
            </li>

            
        </ul>
    </div>
</aside>

