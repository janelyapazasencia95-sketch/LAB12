@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="card shadow-sm border-0">
        <div class="card-header bg-success text-white text-center">
            <h4 class="mb-0">
                <i class="bi bi-plus-circle"></i> Nueva actividad
                <br>
                <small class="text-light">Para la nota: "{{ $nota->titulo }}"</small>
            </h4>
        </div>

        <div class="card-body p-4">

            {{-- Errores --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Error:</strong> revisa los campos.
                    <ul class="mb-0">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('actividades.store', $nota) }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="fw-bold">Título</label>
                    <input type="text" name="titulo" class="form-control shadow-sm"
                           value="{{ old('titulo') }}" required>
                </div>

                <div class="mb-3">
                    <label class="fw-bold">Descripción</label>
                    <textarea name="descripcion" rows="4"
                              class="form-control shadow-sm">{{ old('descripcion') }}</textarea>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('notas.show', $nota) }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Cancelar
                    </a>

                    <button class="btn btn-success">
                        <i class="bi bi-check-circle"></i> Guardar
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
