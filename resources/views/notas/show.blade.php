@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detalle de Nota</h1>

    @if (session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif

    <h2>{{ $nota->titulo }}</h2>
    <p>{{ $nota->contenido }}</p>

    <h3>Recordatorio</h3>
    @if ($nota->recordatorio)
        <p>Fecha vencimiento: {{ $nota->recordatorio->fecha_vencimiento }}</p>
        <p>Estado: {{ $nota->recordatorio->completado ? 'Completado' : 'Pendiente' }}</p>
    @else
        <p>Sin recordatorio</p>
    @endif

    <hr>

    <h3>Actividades</h3>

    <a href="{{ route('actividades.create', $nota) }}">Agregar actividad</a>

    <ul>
        @forelse ($nota->actividades as $actividad)
            <li>
                <strong>{{ $actividad->titulo }}</strong>
                @if($actividad->completado)
                    (Completada)
                @endif
                <br>
                <small>{{ $actividad->descripcion }}</small>
                <br>
                <a href="{{ route('actividades.edit', $actividad) }}">Editar</a>

                <form action="{{ route('actividades.destroy', $actividad) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('¿Eliminar esta actividad?')">Eliminar</button>
                </form>
            </li>
        @empty
            <li>No hay actividades registradas.</li>
        @endforelse
    </ul>

    <hr>

    <a href="{{ route('notas.index') }}">Volver al listado</a>
</div>
@endsection
