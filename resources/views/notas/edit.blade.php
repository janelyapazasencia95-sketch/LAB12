@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">

        <div class="col-md-8">

            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white text-center py-3">
                    <h4 class="mb-0"><i class="bi bi-pencil-square"></i> Editar Nota</h4>
                </div>

                <div class="card-body p-4">

                    {{-- Mensajes de error --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Se encontraron algunos problemas:</strong>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('notas.update', $nota) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Título --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Título</label>
                            <input type="text" name="titulo" 
                                   class="form-control shadow-sm"
                                   value="{{ old('titulo', $nota->titulo) }}"
                                   required>
                        </div>

                        {{-- Contenido --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Contenido</label>
                            <textarea name="contenido" rows="4"
                                      class="form-control shadow-sm"
                                      required>{{ old('contenido', $nota->contenido) }}</textarea>
                        </div>

                        {{-- Fecha de Vencimiento --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Fecha de vencimiento</label>
                            <input type="datetime-local"
                                   name="fecha_vencimiento"
                                   class="form-control shadow-sm"
                                   value="{{ old('fecha_vencimiento', optional($nota->recordatorio->fecha_vencimiento)->format('Y-m-d\TH:i')) }}"
                                   required>
                        </div>

                        {{-- Botones --}}
                        <div class="d-flex justify-content-between">

                            <a href="{{ route('notas.index') }}" class="btn btn-secondary px-4">
                                <i class="bi bi-arrow-left"></i> Cancelar
                            </a>

                            <button type="submit" class="btn btn-success px-4">
                                <i class="bi bi-check-circle"></i> Guardar Cambios
                            </button>

                        </div>

                    </form>

                </div>
            </div>

        </div>

    </div>
</div>
@endsection
