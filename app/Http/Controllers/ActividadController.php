<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use App\Models\Nota;
use Illuminate\Http\Request;

class ActividadController extends Controller
{
    // Formulario para crear actividad para una nota
    public function create(Nota $nota)
    {
        $this->authorizeNota($nota);

        return view('actividades.create', compact('nota'));
    }

    // Guardar actividad nueva
    public function store(Request $request, Nota $nota)
    {
        $this->authorizeNota($nota);

        $request->validate([
            'titulo'      => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $nota->actividades()->create([
            'titulo'      => $request->titulo,
            'descripcion' => $request->descripcion,
            'completado'  => false,
        ]);

        return redirect()->route('notas.show', $nota)
            ->with('success', 'Actividad creada correctamente.');
    }

    // Formulario para editar actividad
    public function edit(Actividad $actividad)
    {
        $this->authorizeNota($actividad->nota);

        return view('actividades.edit', compact('actividad'));
    }

    // Actualizar actividad
    public function update(Request $request, Actividad $actividad)
    {
        $this->authorizeNota($actividad->nota);

        $request->validate([
            'titulo'      => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'completado'  => 'nullable|boolean',
        ]);

        $actividad->update([
            'titulo'      => $request->titulo,
            'descripcion' => $request->descripcion,
            'completado'  => $request->has('completado'),
        ]);

        return redirect()->route('notas.show', $actividad->nota)
            ->with('success', 'Actividad actualizada correctamente.');
    }

    // Eliminar actividad
    public function destroy(Actividad $actividad)
    {
        $this->authorizeNota($actividad->nota);

        $nota = $actividad->nota;

        $actividad->delete();

        return redirect()->route('notas.show', $nota)
            ->with('success', 'Actividad eliminada correctamente.');
    }

    protected function authorizeNota(Nota $nota)
    {
        if ($nota->user_id !== auth()->id()) {
            abort(403, 'No autorizado');
        }
    }
}
