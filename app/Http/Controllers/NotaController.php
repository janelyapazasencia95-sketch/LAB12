<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Nota;
use Illuminate\Http\Request;

class NotaController extends Controller
{
    /**
     * Listar usuarios con sus notas.
     */
    public function index()
    {
        $users = User::with([
                'notas.recordatorio',
                'notas.actividades',
            ])
            ->withCount('notas as total_notas')
            ->get();

        return view('notas.index', compact('users'));
    }

    /**
     * Guardar nueva nota.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id'           => 'required|exists:users,id',
            'titulo'            => 'required|string|max:255',
            'contenido'         => 'required|string',
            'fecha_vencimiento' => 'required|date|after:now',
        ]);

        // Evitar que un usuario cree notas a nombre de otros
        if ($request->user_id != auth()->id()) {
            abort(403, 'No puedes crear notas para otro usuario.');
        }

        $nota = Nota::create([
            'user_id'   => $request->user_id,
            'titulo'    => $request->titulo,
            'contenido' => $request->contenido,
        ]);

        $nota->recordatorio()->create([
            'fecha_vencimiento' => $request->fecha_vencimiento,
            'completado'        => false,
        ]);

        return redirect()
            ->route('notas.index')
            ->with('success', 'Nota creada correctamente.');
    }

    /**
     * Mostrar detalle.
     */
    public function show(Nota $nota)
    {
        $nota->load(['recordatorio', 'actividades']);

        return view('notas.show', compact('nota'));
    }

    /**
     * Formulario de edición.
     */
    public function edit(Nota $nota)
    {
        // 🔒 Seguridad
        if ($nota->user_id !== auth()->id()) {
            abort(403, 'No tienes permiso para editar esta nota.');
        }

        $nota->load('recordatorio');

        return view('notas.edit', compact('nota'));
    }

    /**
     * Actualizar nota.
     */
    public function update(Request $request, Nota $nota)
    {
        // 🔒 Seguridad
        if ($nota->user_id !== auth()->id()) {
            abort(403, 'No tienes permiso para actualizar esta nota.');
        }

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
     * Eliminar nota.
     */
    public function destroy(Nota $nota)
    {
        // 🔒 Seguridad
        if ($nota->user_id !== auth()->id()) {
            abort(403, 'No tienes permiso para eliminar esta nota.');
        }

        $nota->delete();

        return redirect()
            ->route('notas.index')
            ->with('success', 'Nota eliminada correctamente.');
    }
}
