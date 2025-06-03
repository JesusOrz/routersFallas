@extends('layouts.app')

@section('title', 'Routers')

@section('content')
<h1 class="mt-4">Routers</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Routers</li>
</ol>

<button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalConnect">
    New Router
</button>
<div class="modal fade" id="modalConnect" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">REGISTER A NEEW ROUTER</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">HOST</span>
                    <input type="text" class="form-control" placeholder="host" aria-label="host"
                        aria-describedby="basic-addon1" id="host">
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">USER</span>
                    <input type="text" class="form-control" placeholder="user" aria-label="user"
                        aria-describedby="basic-addon1" id="user">
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">PASSWORD</span>
                    <input type="text" class="form-control" placeholder="pass" aria-label="pass"
                        aria-describedby="basic-addon1" id="pass">
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">PORT</span>
                    <input type="number" class="form-control" value="8728" aria-label="port"
                        aria-describedby="basic-addon1" id="port">
                </div>
                <button class="btn btn-info w-100 py-2" name="action" value="add" type="button"
                    id="btnCreate">Add</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de edición -->
<div class="modal fade" id="modalEditRouter" tabindex="-1" aria-labelledby="modalEditRouterLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEditRouterLabel">Editar Router</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="edit-id">
        <div class="mb-3">
          <label for="edit-host" class="form-label">Host</label>
          <input type="text" class="form-control" id="edit-host">
        </div>
        <div class="mb-3">
          <label for="edit-user" class="form-label">Usuario</label>
          <input type="text" class="form-control" id="edit-user">
        </div>
        <div class="mb-3">
          <label for="edit-pass" class="form-label">Contraseña</label>
          <input type="password" class="form-control" id="edit-pass">
        </div>
        <div class="mb-3">
          <label for="edit-port" class="form-label">Puerto</label>
          <input type="number" class="form-control" id="edit-port" value="8728">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="btnUpdate">Guardar Cambios</button>
      </div>
    </div>
  </div>
</div>

<table id="routers-table" class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>HOST</th>
            <th>USER</th>
            <th>STATE</th>
            <th>PORT</th>
            <th>ACTIONS</th>
        </tr>
    </thead>
</table>


@endsection