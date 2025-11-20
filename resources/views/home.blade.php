@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white fw-bold">
                    Dashboard
                </div>

                <div class="card-body text-center p-4">

                    <p class="mb-4">¡Te has logueado correctamente!</p>

                    <a href="{{ route('notas.index') }}" class="btn btn-success px-4">
                        <i class="bi bi-journal-check"></i> Ir a Notas
                    </a>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
