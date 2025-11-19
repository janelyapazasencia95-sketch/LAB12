@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar actividad</h1>

    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('actividades.update', $actividad) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label>Título</label><br>
            <input type="text" name="titulo" value="{{ old('titulo', $actividad->titulo) }}" required>
        </div>

        <div>
            <label>Descripción</label><br>
            <textarea name="descripcion" rows="4">{{ old('descripcion', $actividad->descripcion) }}</textarea>
        </div>

        <div>
            <label>
                <input type="checkbox" name="completado" {{ $actividad->completado ? 'checked' : '' }}>
                Completada
            </label>
        </div>

        <button type="submit">Actualizar</button>
        <a href="{{ route('notas.show', $actividad->nota) }}">Cancelar</a>
    </form>
</div>
@endsection
