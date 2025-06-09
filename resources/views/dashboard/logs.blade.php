@extends('layouts.app')
@section('title', 'Logs')

@section('content')
    <h1>Logs</h1>
    <div class="container">

        <form id="logForm">
            <div class="mb-3">
                <label for="router_id" class="form-label">Available routers</label>
                <select name="router_id" id="router_id" class="form-select">
                    <option selected disabled>Loading routers...</option>
                </select>
            </div>
        </form>


        <div class="container mt-4 mb-3">
            <div id="logs-container" class="border p-3 bg-light" style="min-height: 200px; white-space: pre-wrap;">

            </div>
        </div>

        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button id="analizar-btn" type="button" class="btn btn-primary">
                Analizar
            </button>
        </div>

        <div id="analisis-container" class="mt-3 border p-3 bg-light"></div>
    </div>

@endsection