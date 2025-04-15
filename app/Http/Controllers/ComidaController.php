<?php

namespace App\Http\Controllers;

use App\Models\Comida;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ComidaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Return Inertia::render('Index',[
            'comidas' => Comida::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Return Inertia::render('Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required|max:255',
            'image' => 'required|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('comida', 'public');
            $validate['image_path'] = $imagePath;
        }

        Comida::create($validate);

        return redirect()->route('comida.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Comida $comida)
    {
        Return Inertia::render('Show',[
            'comida' => $comida
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comida $comida)
    {
        Return Inertia::render('Edit',[
            'comida' => $comida
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comida $comida)
    {
        $validate = $request->validate([
            'name' => 'nullable|max:255',
            'description' => 'nullable|max:255',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Remove image from validate array if no new image was uploaded
        if (!$request->hasFile('image')) {
            unset($validate['image']);
        } else {
            $imagePath = $request->file('image')->store('comida', 'public');
            $validate['image'] = $imagePath;
        }

        $comida->update($validate);

        return redirect()->route('comida.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comida $comida)
    {
        $comida->delete();

        return redirect()->route('comida.index');
    }
}
