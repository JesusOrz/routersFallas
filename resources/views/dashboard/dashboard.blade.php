@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Dashboard</h1>

     {{-- Breadcrumb --}}
    <x-breadcrumb :links="[
        'Dashboard' => route('dashboard'),

    ]" />

</div>
@endsection