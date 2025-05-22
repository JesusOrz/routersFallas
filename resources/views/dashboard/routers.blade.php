@extends('layouts.app')

@section('title', 'Routers')

@section('content')
    <h1 class="mt-4">Routers</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Routers</li>
    </ol>

    {{-- Mensaje de conexión --}}
    @if(isset($mensaje))
        <div class="alert alert-info">
            {{ $mensaje }}
        </div>
    @endif

    <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">First</th>
          <th scope="col">Last</th>
          <th scope="col">Handle</th>
        </tr>
      </thead>
      <tbody class="table-group-divider">
        <tr>
          <th scope="row">1</th>
          <td>Mark</td>
          <td>Otto</td>
          <td>@mdo</td>
        </tr>
        <tr>
          <th scope="row">2</th>
          <td>Jacob</td>
          <td>Thornton</td>
          <td>@fat</td>
        </tr>
        <tr>
          <th scope="row">3</th>
          <td>John</td>
          <td>Doe</td>
          <td>@social</td>
        </tr>
      </tbody>
    </table>
@endsection
