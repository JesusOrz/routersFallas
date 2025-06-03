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

                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="bi bi-clipboard2-pulse-fill"></i></div>
                                Logs
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>

                <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ route('logs') }}">Ver logs</a>
                        <a class="nav-link" href="{{ route('logs') }}">Cargar archivo</a>
                    </nav>
                </div>


            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            {{ Auth::user()->name ?? 'Usuario' }}
        </div>
    </nav>
</div>