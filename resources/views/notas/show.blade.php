@extends('layouts.app')

@section('content')
<div class="container mt-4">

    {{-- Mensaje de éxito --}}
    @if (session('success'))
        <div class="alert alert-success text-center">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    {{-- Título --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <h2 class="fw-bold">{{ $nota->titulo }}</h2>
            <p class="text-muted">{{ $nota->contenido }}</p>
        </div>
    </div>

    {{-- Recordatorio --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-primary text-white fw-bold">
            <i class="bi bi-bell"></i> Recordatorio
        </div>
        <div class="card-body">
            @if ($nota->recordatorio)
                <p><strong>Fecha vencimiento:</strong>
                    {{ $nota->recordatorio->fecha_vencimiento->format('Y-m-d H:i') }}
                </p>

                <p>
                    <strong>Estado:</strong>
                    @if($nota->recordatorio->completado)
                        <span class="badge bg-success">Completado</span>
                    @else
                        <span class="badge bg-warning text-dark">Pendiente</span>
                    @endif
                </p>
            @else
                <p class="text-muted">Sin recordatorio</p>
            @endif
        </div>
    </div>

    {{-- Actividades --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-info text-white fw-bold d-flex justify-content-between">
            <span><i class="bi bi-list-task"></i> Actividades</span>
            <a href="{{ route('actividades.create', $nota) }}" class="btn btn-light btn-sm">
                <i class="bi bi-plus-circle"></i> Nueva actividad
            </a>
        </div>

        <div class="card-body">
            @forelse ($nota->actividades as $actividad)
                <div class="border rounded p-3 mb-3">

                    <h5 class="mb-1">
                        {{ $actividad->titulo }}
                        @if($actividad->completado)
                            <span class="badge bg-success">Completada</span>
                        @endif
                    </h5>

                    <p class="text-muted mb-2">{{ $actividad->descripcion }}</p>

                    <div class="d-flex gap-2">
                        <a href="{{ route('actividades.edit', $actividad) }}"
                           class="btn btn-sm btn-primary">
                            <i class="bi bi-pencil-square"></i> Editar
                        </a>

                        <form action="{{ route('actividades.destroy', $actividad) }}"
                              method="POST" onsubmit="return confirm('¿Eliminar esta actividad?')">
                            @csrf
                            @method('DELETE')

                            <button class="btn btn-sm btn-danger">
                                <i class="bi bi-trash"></i> Eliminar
                            </button>
                        </form>
                    </div>

                </div>
            @empty
                <p class="text-muted">No hay actividades registradas.</p>
            @endforelse
        </div>
    </div>

    {{-- Botón regresar --}}
    <a href="{{ route('notas.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Volver al listado
    </a>

</div>
@endsection
