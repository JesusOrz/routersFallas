<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                <div class="sb-sidenav-menu-heading">Addons</div>

                <a class="nav-link" href="{{ route('routers') }}">
                    <div class="sb-nav-link-icon"><i class="bi bi-router-fill"></i></div>
                    Routers
                </a>
                
                <a class="nav-link" href="{{ route('logs') }}">
                    <div class="sb-nav-link-icon"><i class="bi bi-clipboard2-pulse-fill"></i></div>
                    Logs
                </a>

                
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            {{ Auth::user()->name ?? 'Usuario' }}
        </div>
    </nav>
</div>
