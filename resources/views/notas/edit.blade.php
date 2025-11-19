@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Nota</h1>

    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('notas.update', $nota) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label>Título</label><br>
            <input type="text" name="titulo" value="{{ old('titulo', $nota->titulo) }}" required>
        </div>

        <div>
            <label>Contenido</label><br>
            <textarea name="contenido" rows="5" required>{{ old('contenido', $nota->contenido) }}</textarea>
        </div>

        <div>
            <label>Fecha de vencimiento del recordatorio</label><br>
            <input type="datetime-local"
                   name="fecha_vencimiento"
                   value="{{ old('fecha_vencimiento', optional($nota->recordatorio)->fecha_vencimiento ? $nota->recordatorio->fecha_vencimiento->format('Y-m-d\TH:i') : '') }}"
                   required>
        </div>

        <button type="submit">Actualizar</button>
        <a href="{{ route('notas.index') }}">Cancelar</a>
    </form>
</div>
@endsection
