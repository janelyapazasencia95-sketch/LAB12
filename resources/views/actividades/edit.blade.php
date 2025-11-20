@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="card shadow-sm border-0">

        <div class="card-header bg-primary text-white text-center">
            <h4 class="mb-0">
                <i class="bi bi-pencil-square"></i> Editar actividad
            </h4>
        </div>

        <div class="card-body p-4">

            {{-- Errores --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Error:</strong> revisa los campos.
                    <ul>
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('actividades.update', $actividad) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="fw-bold">Título</label>
                    <input type="text" name="titulo" class="form-control shadow-sm"
                           value="{{ old('titulo', $actividad->titulo) }}" required>
                </div>

                <div class="mb-3">
                    <label class="fw-bold">Descripción</label>
                    <textarea name="descripcion" rows="4"
                              class="form-control shadow-sm">{{ old('descripcion', $actividad->descripcion) }}</textarea>
                </div>

                <div class="form-check mb-4">
                    <input type="checkbox" class="form-check-input" name="completado"
                           {{ $actividad->completado ? 'checked' : '' }}>
                    <label class="form-check-label">Marcar como completada</label>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('notas.show', $actividad->nota) }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Cancelar
                    </a>

                    <button class="btn btn-primary">
                        <i class="bi bi-save"></i> Actualizar
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
