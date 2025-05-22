@extends('layouts.app')

@section('title', 'Logs del MikroTik')

@section('content')
    <h1 class="mt-4">Logs del MikroTik</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Logs</li>
    </ol>

    @if(count($logs) > 0)
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Hora</th>
                    <th>Tema</th>
                    <th>Mensaje</th>
                </tr>
            </thead>
            <tbody>
                @foreach($logs as $log)
                    <tr>
                        <td>{{ $log['time'] ?? '-' }}</td>
                        <td>{{ $log['topics'] ?? '-' }}</td>
                        <td>{{ $log['message'] ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="alert alert-warning">No se pudieron obtener los logs del router.</div>
    @endif
@endsection
