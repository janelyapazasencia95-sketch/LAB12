@extends('layouts.app')

@section('title', 'Notes and Reminders')

@section('content')
<div class="container mt-4">

    {{-- Encabezado --}}
    <h1 class="text-center mb-4">Notes and Reminders</h1>

    {{-- Mensaje de éxito --}}
    @if(session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif

    {{-- Formulario para crear nota --}}
    <div class="card mb-4">
        <div class="card-header fw-bold">
            Formulario para Crear Nota
        </div>
        <div class="card-body">
            <form action="{{ route('notas.store') }}" method="POST">
                @csrf

                <div class="row mb-3">
                    <label for="user_id" class="col-md-3 col-form-label">Seleccionar Usuario</label>
                    <div class="col-md-9">
                        <select name="user_id" id="user_id" class="form-select" required>
                            <option value="">-- Seleccione un usuario --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="titulo" class="col-md-3 col-form-label">Título Nota</label>
                    <div class="col-md-9">
                        <input type="text" name="titulo" id="titulo" class="form-control" placeholder="Ej. Comprar libros" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="contenido" class="col-md-3 col-form-label">Contenido</label>
                    <div class="col-md-9">
                        <textarea name="contenido" id="contenido" rows="3" class="form-control" placeholder="Detalles de la nota..." required></textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="fecha_vencimiento" class="col-md-3 col-form-label">Fecha Vencimiento</label>
                    <div class="col-md-9">
                        <input type="datetime-local" name="fecha_vencimiento" id="fecha_vencimiento" class="form-control" required>
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Añadir Nota</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Listado de usuarios y notas --}}
    @foreach ($users as $user)
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><strong>Usuario:</strong> {{ $user->name }}</span>
                <span class="badge bg-info text-dark">{{ $user->total_notas }} Active Notes</span>
            </div>
            <div class="card-body">
                @forelse ($user->notas as $nota)
                    <div class="border rounded p-3 mb-3">
                        <h5 class="{{ $nota->recordatorio->completado ? 'text-decoration-line-through text-muted' : '' }}">
                            {{ $nota->titulo_formateado }}
                        </h5>
                        <p>{{ $nota->contenido }}</p>
                        <small class="text-muted">
                            <strong>Due:</strong> {{ \Carbon\Carbon::parse($nota->recordatorio->fecha_vencimiento)->format('Y-m-d H:i') }}
                            @if($nota->recordatorio->completado)
                                <span class="badge bg-success ms-2">Completed</span>
                            @else
                                <span class="badge bg-warning text-dark ms-2">Pending</span>
                            @endif
                        </small>
                    </div>
                @empty
                    <p class="text-muted">No hay notas activas.</p>
                @endforelse
            </div>
        </div>
    @endforeach
</div>
@endsection
