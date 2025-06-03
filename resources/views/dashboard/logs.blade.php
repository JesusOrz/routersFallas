@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Logs</h1>

    <!-- Selección de Router -->
    <form id="logForm">
        <div class="mb-3">
            <label for="router_id" class="form-label">Seleccionar Router</label>
            <select name="router_id" id="router_id" class="form-select">
                @foreach ($routers as $router)
                    <option value="{{ $router->id }}">{{ $router->host }}</option>
                @endforeach
            </select>
        </div>
        <button type="button" class="btn btn-primary" id="btnViewLogs">Ver Logs en tiempo real</button>
    </form>

    <hr>

    <!-- Subir archivo -->
    <form action="{{ route('logs.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="logfile" class="form-label">Subir archivo log (.txt)</label>
            <input type="file" name="logfile" id="logfile" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Subir archivo</button>
    </form>

    <hr>

    <!-- Resultado -->
    <h4>Resultados</h4>
    <div id="log-output" style="white-space: pre-line;"></div>
</div>
@endsection


