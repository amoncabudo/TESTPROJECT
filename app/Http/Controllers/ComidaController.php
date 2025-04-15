<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Comida;

class ComidaController extends Controller
{
    public function index()
    {
        $comidas = Comida::all();
        
        return Inertia::render('Index', [
            'comidas' => $comidas
        ]);
    }

    public function create()
    {
        return Inertia::render('Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
        }

        Comida::create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $imageName ?? null
        ]);

        return redirect()->route('comida.index')
            ->with('success', 'Comida creada exitosamente.');
    }

    public function show(Comida $comida)
    {
        return Inertia::render('Show', [
            'comida' => $comida
        ]);
    }

    public function edit(Comida $comida)
    {
        return Inertia::render('Edit', [
            'comida' => $comida
        ]);
    }

    public function update(Request $request, Comida $comida)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('image')) {
            // Eliminar imagen anterior si existe
            if ($comida->image && file_exists(public_path('images/' . $comida->image))) {
                unlink(public_path('images/' . $comida->image));
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            
            $comida->image = $imageName;
        }

        $comida->name = $request->name;
        $comida->description = $request->description;
        $comida->save();

        return redirect()->route('comida.index')
            ->with('success', 'Comida actualizada exitosamente.');
    }

    public function destroy(Comida $comida)
    {
        // Eliminar imagen si existe
        if ($comida->image && file_exists(public_path('images/' . $comida->image))) {
            unlink(public_path('images/' . $comida->image));
        }

        $comida->delete();

        return redirect()->route('comida.index')
            ->with('success', 'Comida eliminada exitosamente.');
    }
}