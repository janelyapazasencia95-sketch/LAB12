@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear Nota</h1>

    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('notas.store') }}" method="POST">
        @csrf

        <div>
            <label>Título</label><br>
            <input type="text" name="titulo" value="{{ old('titulo') }}" required>
        </div>

        <div>
            <label>Contenido</label><br>
            <textarea name="contenido" rows="5" required>{{ old('contenido') }}</textarea>
        </div>

        <div>
            <label>Fecha de vencimiento del recordatorio</label><br>
            <input type="datetime-local" name="fecha_vencimiento" value="{{ old('fecha_vencimiento') }}" required>
        </div>

        <button type="submit">Guardar</button>
        <a href="{{ route('notas.index') }}">Cancelar</a>
    </form>
</div>
@endsection
