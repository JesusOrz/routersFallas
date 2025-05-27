@extends('layouts.app')

@section('title', 'Logs del MikroTik')

@section('content')
    <h1 class="mt-4">Logs de Routers MikroTik</h1>

    <style>
        .log-table-wrapper {
            width: 80%;
            margin: 20px auto;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .log-table-container {
            max-height: 250px;
            overflow-y: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #ffffff;
        }

        thead {
            background-color: #4a90e2;
            color: white;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #dddddd;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        th {
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        caption {
            caption-side: top;
            padding: 10px;
            font-size: 1.5em;
            font-weight: bold;
            color: #333;
        }
    </style>

    @foreach ($logsPorRouter as $router)
        <div class="log-table-wrapper">
            <caption>Router: {{ $router['host'] }}</caption>
            <div class="log-table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Hora</th>
                            <th>Mensaje</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($router['logs'] as $log)
                            <tr>
                                <td>{{ $log['time'] ?? '-' }}</td>
                                <td title="{{ $log['message'] ?? '' }}">{{ $log['message'] ?? json_encode($log) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2">Sin logs disponibles.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach
@endsection
