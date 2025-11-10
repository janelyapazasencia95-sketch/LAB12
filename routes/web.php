<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\NotaController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/notas', [App\Http\Controllers\NotaController::class, 'index'])->name('notas.index');
Route::post('/notas', [App\Http\Controllers\NotaController::class, 'store'])->name('notas.store');
Route::resource('posts', PostController::class);
