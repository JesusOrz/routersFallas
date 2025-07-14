@extends('layouts.app')

@section('title', 'Mis Keys')

@section('content')
<div class="container py-4">

    {{-- Modal Crear Key --}}
    <div class="modal fade" id="modalKeys" tabindex="-1" aria-labelledby="modalKeysLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalKeysLabel">Agrega una opción</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <form id="formCreateKey">
                        <div class="mb-3">
                            <label for="key" class="form-label">API Key (Esta se encriptará por seguridad)</label>
                            <input type="text" class="form-control" id="key" placeholder="ej. sk-xxxxxxxxxxxxxxxxxxx" required>
                        </div>

                        <div class="mb-3">
                            <label for="provider_id" class="form-label">Proveedores disponibles</label>
                            <select name="provider_id" id="provider_id" class="form-select">
                                <option selected disabled>Cargando...</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="model_id" class="form-label">Modelos disponibles</label>
                            <select name="model_id" id="model_id" class="form-select">
                                <option selected disabled>Esperando proveedor...</option>
                            </select>
                        </div>

                        <button type="button" class="btn btn-primary w-100" id="btnCreateKey">Agregar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <h1 class="mt-4 mb-3">Keys</h1>

    {{-- Breadcrumb --}}
    <x-breadcrumb :links="[
        'Dashboard' => route('dashboard'),
        'Keys' => ''
    ]" />

    {{-- Tabla de keys en Card --}}
    <div class="card mb-5">
                <div class="card-header bg-dark text-white">
            Mis Keys
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="keys-table" class="table table-striped table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Key</th>
                            <th>Proveedor</th>
                            <th>Modelo</th>
                            <th>Tipo</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Se llena dinámicamente vía DataTables --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Botón Agregar --}}
    <div class="mb-3 text-end">
        <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#modalKeys">
            <i class="fa-solid fa-plus"></i>
            Agregar API key
        </button>
    </div>
</div>
@endsection
