@extends('layouts.app')

@section('title', 'Cargar Archivo')

@section('content')
<h1>Cargar Archivo de Logs</h1>

<div class="container">
    <form id="logUploadForm" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="logfile" class="form-label">Selecciona un archivo de logs (.txt)</label>
            <input type="file" name="logfile" id="logfile" class="form-control" accept=".txt" required>
        </div>

        <button type="submit" class="btn btn-primary" id="submitBtn">Subir y Analizar</button>
    </form>

    <div id="loading" class="mt-3" style="display: none;">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Analizando...</span>
        </div>
        <span>Analizando logs, por favor espera...</span>
    </div>

    <br>
    <div id="resultado" style="white-space: pre-wrap;"></div>
</div>

<script>
document.getElementById('logUploadForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const submitBtn = document.getElementById('submitBtn');
    const loading = document.getElementById('loading');
    const resultado = document.getElementById('resultado');

    submitBtn.disabled = true;
    loading.style.display = 'block';
    resultado.innerHTML = '';

    let formData = new FormData(this);

    fetch("{{ route('logs.upload') }}", {
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.respuesta) {
            resultado.innerHTML = `<div class="alert alert-success">${data.respuesta}</div>`;
        } else if (data.error) {
            resultado.innerHTML = `<div class="alert alert-danger">${data.error}</div>`;
        }
    })
    .catch(error => {
        resultado.innerHTML = `<div class="alert alert-danger">Error: ${error}</div>`;
    })
    .finally(() => {
        loading.style.display = 'none';
        submitBtn.disabled = false;
    });
});
</script>
@endsection
