<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Nota;
use Illuminate\Http\Request;

class NotaController extends Controller
{
    /**
     * Listar usuarios con sus notas, recordatorios y actividades.
     * Esta acción carga la vista resources/views/notas/index.blade.php
     */
    public function index()
    {
        // Trae todos los usuarios con sus notas, recordatorio y actividades
        $users = User::with([
                'notas.recordatorio',
                'notas.actividades',
            ])
            ->withCount('notas as total_notas') // para el badge de "Active Notes"
            ->get();

        return view('notas.index', compact('users'));
    }

    /**
     * Guardar una nueva nota con su recordatorio.
     * (Formulario está en la misma vista index)
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id'           => 'required|exists:users,id',
            'titulo'            => 'required|string|max:255',
            'contenido'         => 'required|string',
            'fecha_vencimiento' => 'required|date|after:now',
        ]);

        // Crear la nota
        $nota = Nota::create([
            'user_id'   => $request->user_id,
            'titulo'    => $request->titulo,
            'contenido' => $request->contenido,
        ]);

        // Crear el recordatorio asociado
        $nota->recordatorio()->create([
            'fecha_vencimiento' => $request->fecha_vencimiento,
            'completado'        => false,
        ]);

        return redirect()
            ->route('notas.index')
            ->with('success', 'Nota creada correctamente.');
    }

    /**
     * Mostrar detalle de una nota.
     */
    public function show(Nota $nota)
    {
        $nota->load(['recordatorio', 'actividades']);

        return view('notas.show', compact('nota'));
    }

    /**
     * Formulario de edición de una nota.
     */
    public function edit(Nota $nota)
    {
        $nota->load('recordatorio');

        return view('notas.edit', compact('nota'));
    }

    /**
     * Actualizar una nota y su recordatorio.
     */
    public function update(Request $request, Nota $nota)
    {
        $request->validate([
            'titulo'            => 'required|string|max:255',
            'contenido'         => 'required|string',
            'fecha_vencimiento' => 'required|date',
        ]);

        $nota->update([
            'titulo'    => $request->titulo,
            'contenido' => $request->contenido,
        ]);

        if ($nota->recordatorio) {
            $nota->recordatorio->update([
                'fecha_vencimiento' => $request->fecha_vencimiento,
            ]);
        } else {
            $nota->recordatorio()->create([
                'fecha_vencimiento' => $request->fecha_vencimiento,
                'completado'        => false,
            ]);
        }

        return redirect()
            ->route('notas.show', $nota)
            ->with('success', 'Nota actualizada correctamente.');
    }

    /**
     * Eliminar nota (recordatorio y actividades se eliminan en cascada).
     */
    public function destroy(Nota $nota)
    {
        $nota->delete();

        return redirect()
            ->route('notas.index')
            ->with('success', 'Nota eliminada correctamente junto con su recordatorio y actividades.');
    }
}
