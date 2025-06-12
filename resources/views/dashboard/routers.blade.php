@extends('layouts.app')

@section('title', 'Routers')

@section('content')
<div class="container py-4">
    <h1 class="mt-4 mb-3">Routers</h1>
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Routers</li>
        </ol>
    </nav>


    {{-- Modal Crear Router --}}
    <div class="modal fade" id="modalConnect" tabindex="-1" aria-labelledby="modalConnectLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalConnectLabel">Registrar un nuevo Router</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <form id="formCreateRouter">
                        <div class="mb-3">
                            <label for="host" class="form-label">Host</label>
                            <input type="text" class="form-control" id="host" placeholder="host" required>
                        </div>
                        <div class="mb-3">
                            <label for="user" class="form-label">Usuario</label>
                            <input type="text" class="form-control" id="user" placeholder="user" required>
                        </div>
                        <div class="mb-3">
                            <label for="pass" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="pass" placeholder="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="port" class="form-label">Puerto</label>
                            <input type="number" class="form-control" id="port" value="8728" required>
                        </div>
                        <button type="button" class="btn btn-info w-100" id="btnCreate">Agregar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Editar Router --}}
    <div class="modal fade" id="modalEditRouter" tabindex="-1" aria-labelledby="modalEditRouterLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditRouterLabel">Editar Router</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditRouter">
                        <input type="hidden" id="edit-id">
                        <div class="mb-3">
                            <label for="edit-host" class="form-label">Host</label>
                            <input type="text" class="form-control" id="edit-host" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-user" class="form-label">Usuario</label>
                            <input type="text" class="form-control" id="edit-user" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-pass" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="edit-pass" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-port" class="form-label">Puerto</label>
                            <input type="number" class="form-control" id="edit-port" value="8728" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="btnUpdate">Guardar Cambios</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Crear Opcion --}}
    <div class="modal fade" id="modalAnalysis" tabindex="-1" aria-labelledby="modalAnalysisLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAnalysisLabel">Agrega una opción</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <form id="formCreateRouter">
                        <div class="mb-3">
                            <label for="analysis" class="form-label">Tipo de análisis</label>
                            <input type="text" class="form-control" id="analysis"
                                placeholder="ej. Detección de errores, Rendimiento del router, etc." required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Descripción</label>
                            <input type="text" class="form-control" id="description"
                                placeholder="ej. Analiza el rendimiento del router, etc." required>
                        </div>
                        <button type="button" class="btn btn-primary w-100" id="btnCreateAnalysis">Agregar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabla de Routers en Card --}}
    <div class="card mb-5">
        <div class="card-header bg-dark text-white">
            Lista de Routers
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="routers-table" class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Host</th>
                            <th>Usuario</th>
                            <th>Estado</th>
                            <th>Puerto</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Aquí se llenará dinámicamente --}}
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    <!-- Alineación del botón a la derecha -->
    <div class="mb-3 text-end">
        <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#modalConnect">
            Nuevo Router
        </button>
    </div>

    {{-- Tabla de Análisis en Card --}}
    <div class="card">
        <div class="card-header bg-secondary text-white">
            Tipos de Análisis
        </div>
        <div class="card-body mb-3">
            <div class="table-responsive">
                <table id="analysis-table" class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Análisis</th>
                            <th>Descripción</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Aquí se llenará dinámicamente --}}
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    <!-- Alineación del botón a la derecha -->
    <div class="mb-3 text-end">
        <button type="button" class="btn " data-bs-toggle="modal" title="Agregar opción"
            data-bs-target="#modalAnalysis">
            <i class="bi bi-plus-circle-fill"></i>
        </button>
    </div>
</div>
@endsection