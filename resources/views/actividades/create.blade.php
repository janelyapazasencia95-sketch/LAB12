@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Nueva actividad para la nota: "{{ $nota->titulo }}"</h1>

    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('actividades.store', $nota) }}" method="POST">
        @csrf

        <div>
            <label>Título</label><br>
            <input type="text" name="titulo" value="{{ old('titulo') }}" required>
        </div>

        <div>
            <label>Descripción</label><br>
            <textarea name="descripcion" rows="4">{{ old('descripcion') }}</textarea>
        </div>

        <button type="submit">Guardar</button>
        <a href="{{ route('notas.show', $nota) }}">Cancelar</a>
    </form>
</div>
@endsection
