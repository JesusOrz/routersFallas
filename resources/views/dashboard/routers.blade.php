@extends('layouts.app')

@section('title', 'Routers')

@section('content')
    <h1 class="mt-4">Routers</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Routers</li>
    </ol>

    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>HOST</th>
                <th>USER</th>
                <th>PORT</th>
                <th>STATE</th>
            </tr>
        </thead>
        <tbody>
            @foreach($resultados as $router)
                <tr>
                    <td>{{ $router['id'] }}</td>
                    <td>{{ $router['host'] }}</td>
                    <td>{{ $router['user'] }}</td>
                    <td>{{ $router['port'] }}</td>
                    <td>{{ $router['state'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
