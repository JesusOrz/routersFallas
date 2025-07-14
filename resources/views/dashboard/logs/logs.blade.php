@extends('layouts.app')
@section('title', 'Logs')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Análisis de Logs</h1>

    {{-- Breadcrumb --}}
    <x-breadcrumb :links="[
        'Dashboard' => route('dashboard'),
        'Logs' => ''
    ]" />

    {{-- Fila con dropdowns a la izquierda y logs a la derecha --}}
    <div class="row mb-4">
        {{-- Columna izquierda --}}
        <div class="col-md-4">

            {{-- Card: Dropdown de Routers --}}
            <div class="card mb-3">
                <div class="card-header text-bg-secondary">
                    Selección del Router
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="router_id" class="form-label">Routers disponibles</label>
                        <select name="router_id" id="router_id" class="form-select">
                            <option selected disabled>Cargando routers...</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- Card: Dropdown de IAs --}}
            <div class="card mb-3">
                <div class="card-header text-bg-secondary">
                    Selección de Proveedor
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="provider_id" class="form-label">Proveedores disponibles</label>
                        <select name="provider_id" id="provider_id" class="form-select">
                            <option selected disabled>Cargando...</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- Card: Dropdown de IAs --}}
            <div class="card mb-3">
                <div class="card-header text-bg-secondary">
                    Selección de Modelos
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="model_id" class="form-label">Modelos disponibles</label>
                        <select name="model_id" id="model_id" class="form-select">
                            <option selected disabled>Esperando proveedor...</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- Card: Checkboxes de Análisis --}}
            <div class="card mb-3">
                <div class="card-header text-bg-secondary">
                    Tipo de Análisis
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Análisis disponibles</label>
                        <div id="analysis_type_container">
                            <!-- Aquí se insertarán los checkboxes -->
                            <div class="text-muted">Cargando opciones...</div>
                        </div>
                    </div>
                </div>
            </div>




            {{-- Botón de análisis --}}
            <div class="text-end">
                <button id="analizar-btn" type="button" class="btn btn-dark w-20">
                    Analizar
                </button>
            </div>
        </div>

        {{-- Columna derecha --}}
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-header text-bg-secondary">
                    Logs del Router
                </div>
                <div class="card-body">
                    <div id="logs-container" class="bg-light border p-3"
                        style="min-height: 600px; max-height: 600px; overflow-y: auto; white-space: pre-wrap;">
                        <!-- Los logs se cargarán aquí -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Resultado del análisis --}}
    <div class="card mb-3">
        <div class="card-header text-bg-secondary">
            Resultado del Análisis
        </div>
        <div class="card-body">
            <div id="analisis-container" class="bg-light p-3">
                <!-- El resultado del análisis aparecerá aquí -->
            </div>
        </div>
    </div>

    {{-- Recomendaciones --}}
    <div class="card mb-3">
        <div class="card-header text-bg-secondary">
            Recomendaciones
        </div>
        <div class="card-body">
            <div id="recomendaciones-container" class="bg-light p-3">
                <!-- El resultado del análisis aparecerá aquí -->
            </div>
        </div>
    </div>

    {{-- Boton para descargar PDF --}}

    <div class="text-end">
        <button id="descargar-pdf" class="btn btn-primary mt-3" style="display:none;">
            <i class="bi bi-file-earmark-arrow-down"></i>
            Descargar análisis en PDF
        </button>

    </div>

</div>
@endsection