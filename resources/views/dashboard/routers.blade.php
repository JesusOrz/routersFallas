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
                    <input type="text" class="form-control" value="8728" aria-label="port"
                        aria-describedby="basic-addon1" id="port">
                </div>
                <button class="btn btn-info w-100 py-2" name="action" value="add" type="button"
                    id="btnCreate">Add</button>
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




<script>
const CSRF_TOKEN = "{{ csrf_token() }}";
const ROUTERS_STORE_URL = "{{ route('routers.create') }}";
const ROUTERS_JSON_URL = "{{ route('routers.json') }}";
</script>

@endsection