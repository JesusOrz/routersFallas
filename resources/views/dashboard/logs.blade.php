@extends('layouts.app')
@section('title', 'Logs')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Análisis de Logs</h1>

    {{-- Formulario para seleccionar el router --}}
    <div class="card mb-4">
        <div class="card-header text-bg-secondary">
            Selección del Router
        </div>
        <div class="card-body">
            <form id="logForm">
                <div class="mb-3">
                    <label for="router_id" class="form-label">Routers disponibles</label>
                    <select name="router_id" id="router_id" class="form-select">
                        <option selected disabled>Cargando routers...</option>
                    </select>
                </div>
            </form>
        </div>
    </div>

    {{-- Contenedor de logs --}}
    <div class="card mb-4">
        <div class="card-header text-bg-secondary">
            Logs del Router
        </div>
        <div class="card-body">
            <div id="logs-container" class="bg-light border p-3" style="min-height: 200px; white-space: pre-wrap;">
                <!-- Los logs se cargarán aquí -->
            </div>
        </div>
    </div>

    {{-- Botón para analizar --}}
    <div class="text-end mb-4">
        <button id="analizar-btn" type="button" class="btn btn-dark">
            Analizar
        </button>
    </div>

    {{-- Contenedor para el análisis de logs --}}
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
