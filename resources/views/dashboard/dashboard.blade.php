@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Dashboard</h1>

    {{-- Breadcrumb --}}
    <x-breadcrumb :links="['Dashboard' => route('dashboard')]" />

   <div class="row row-cols-1 row-cols-md-2 g-4">

        {{-- Card 1: Routers --}}
        <div class="col">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <a href="{{ route('routersTable') }}"  class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                MIS ROUTERS
</a>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="router-count">
                                
                            </div>
                        </div>
                        <i class="bi bi-router-fill fs-2 text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card 2: Keys --}}
        <div class="col">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <a href="{{ route('keysTable') }}" class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                MIS KEYS
</a>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="key-count">
                                
                            </div>
                        </div>
                        <i class="bi bi-key-fill fs-2 text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card 3: Análisis Realizados
        <div class="col">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                ANÁLISIS REALIZADOS
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <!-- Valor aquí -->
                            </div>
                        </div>
                        <i class="bi bi-clipboard2-pulse-fill fs-2 text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>

        --}}

        {{-- Card adicional opcional --}}
        {{-- <div class="col">
            <div class="card border-left-warning shadow h-100 py-2">
                ...
            </div>
        </div> --}}
    </div>
</div>
@endsection
