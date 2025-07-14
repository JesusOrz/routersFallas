@extends('layouts.app')

@section('title', 'Tablas de Analisis')

@section('content')
<div class="container py-4">

    {{-- Modal Crear Opcion --}}
    <div class="modal fade" id="modalAnalysis" tabindex="-1" aria-labelledby="modalAnalysisLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAnalysisLabel">Agrega una opción</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <form id="formCreateAnalysis">
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

    <h1 class="mt-4 mb-3">Tipos de Análisis</h1>

    {{-- Breadcrumb --}}
    <x-breadcrumb :links="[
        'Dashboard' => route('dashboard'),
        'Tipos de Análisis' => ''
    ]" />

    {{-- Tabla de Análisis en Card --}}
    <div class="card mb-3">
        <div class="card-header bg-dark text-white">
            Tipos de Análisis
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="analysis-table" class="table table-striped table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Análisis</th>
                            <th>Descripción</th>
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
        <button type="button" class="btn btn-dark" data-bs-toggle="modal" title="Agregar analisís"
            data-bs-target="#modalAnalysis">
            <i class="fa-solid fa-plus"></i>
            Agregar Analisís
        </button>
    </div>
</div>
@endsection