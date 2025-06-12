@extends('layouts.app')
@section('title', 'Logs')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Análisis de Logs</h1>

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

            {{-- Card: Dropdown de Análisis --}}
            <div class="card mb-3">
                <div class="card-header text-bg-secondary">
                    Tipo de Análisis
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="analysis_type" class="form-label">Análisis</label>
                        <select name="analysis_type" id="analysis_type" class="form-select">
                            <option selected disabled>Cargando opciones...</option>
                        </select>
                    </div>

                    <!-- Alineación del botón a la derecha -->
                    <div class="text-end">
                        <button type="button" class="btn" data-bs-toggle="tooltip" title="Agregar opción">
                            <i class="bi bi-plus-circle-fill"></i>
                        </button>
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
                        style="min-height: 200px; white-space: pre-wrap;">
                        <!-- Los logs se cargarán aquí -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Resultado del análisis --}}
    <div class="card">
        <div class="card-header text-bg-secondary">
            Resultado del Análisis
        </div>
        <div class="card-body">
            <div id="analisis-container" class="bg-light p-3">
                <!-- El resultado del análisis aparecerá aquí -->
            </div>
        </div>
    </div>
</div>
@endsection