@extends('layouts.app')

@section('title', 'Cargar Archivo')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Cargar Archivo de Logs</h1>

    <div class="row mb-3">
        {{-- Columna izquierda: Subida de archivo --}}
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header text-bg-secondary">
                    Subida de Archivo
                </div>
                <div class="card-body">
                    <form id="logUploadForm" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="logfile" class="form-label">Selecciona un archivo de logs (txt, log)</label>

                            <div class="border border-2 rounded-3 p-5 text-center position-relative bg-light"
                                 id="dropzone"
                                 style="cursor: pointer;">
                                <i class="bi bi-upload fs-1 text-secondary" id="upload-icon"></i>

                                <p class="mt-3 mb-0" id="dropzone-message">Arrastra y suelta el archivo aquí, o haz clic para seleccionarlo</p>
                                <p id="filename" class="text-muted mt-2"></p>
                                <input 
                                    type="file" 
                                    name="logfile" 
                                    id="logfile" 
                                    class="form-control position-absolute top-0 start-0 w-100 h-100 opacity-0" 
                                    accept=".txt,.log" 
                                    required
                                    style="cursor: pointer;">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Columna derecha: Dropdown de análisis --}}
        <div class="col-md-6">
            <div class="card h-100">
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
        </div>
    </div>

    {{-- Botón fuera del formulario --}}
    <div class="d-grid d-md-flex justify-content-md-end mb-3">
        <button class="btn btn-dark" id="submitBtn">Analizar</button>
    </div>

    {{-- Indicador de carga --}}
    <div id="loading" class="mt-3" style="display: none;">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Analizando...</span>
        </div>
        <span>Analizando logs, por favor espera...</span>
    </div>

    {{-- Resultado del análisis --}}
    <div class="card mb-3">
        <div class="card-header text-bg-secondary">
            Resultado del Análisis
        </div>
        <div class="card-body">
            <div id="resultado" class="bg-light p-3">
                <!-- El resultado del análisis aparecerá aquí -->
            </div>
        </div>
    </div>
     {{-- Recomendaciones --}}
    <div class="card">
        <div class="card-header text-bg-secondary">
            Recomendaciones
        </div>
        <div class="card-body">
            <div id="recomendaciones" class="bg-light p-3">
                <!-- El resultado del análisis aparecerá aquí -->
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/file.js') }}"></script>
@endsection
