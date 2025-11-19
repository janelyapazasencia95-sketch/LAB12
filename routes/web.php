<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\NotaController;
use App\Http\Controllers\ActividadController;

Route::get('/', function () {
    return view('welcome');
});

// Rutas de autenticación (login, register, etc.)
Auth::routes();

// Dashboard por defecto
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Rutas protegidas (solo usuarios autenticados)
Route::middleware(['auth'])->group(function () {

    // CRUD de notas (index, create, store, show, edit, update, destroy)
    Route::resource('notas', NotaController::class);

    // CRUD de posts
    Route::resource('posts', PostController::class);

    // Rutas anidadas para actividades de una nota
    Route::prefix('notas/{nota}')->group(function () {
        Route::get('actividades/crear', [ActividadController::class, 'create'])
            ->name('actividades.create');

        Route::post('actividades', [ActividadController::class, 'store'])
            ->name('actividades.store');
    });

    // Rutas para editar/actualizar/eliminar una actividad (shallow)
    Route::get('actividades/{actividad}/editar', [ActividadController::class, 'edit'])
        ->name('actividades.edit');

    Route::put('actividades/{actividad}', [ActividadController::class, 'update'])
        ->name('actividades.update');

    Route::delete('actividades/{actividad}', [ActividadController::class, 'destroy'])
        ->name('actividades.destroy');
});
