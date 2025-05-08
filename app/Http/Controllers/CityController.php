<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Region;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cities = City::with('region')->get(); // Cargar la relación 'region'

        return Inertia::render('CityList', [
            'cities' => $cities,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $regions = Region::all(); // Obtener todas las regiones
        return Inertia::render('CityCreate', [
            'regions' => $regions, // Pasar las regiones al componente Vue
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'region_id' => 'required|exists:regions,id', // Validar que la región exista
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Guardar la imagen si se proporciona
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('cities', 'public');
        }

        City::create($validated);

        return redirect()->route('city.index')->with('success', 'Ciudad creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(City $city)
    {
        $city->load('region');
        
        return Inertia::render('CityShow',[
            'cities' => $city
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(City $city)
    {
        $regions = Region::all(); 

        return Inertia::render('CityEdit', [
            'city' => $city,
            'regions' => $regions, 
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, City $city)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'region_id' => 'required|exists:regions,id', 
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Guardar la imagen si se proporciona
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('cities', 'public');
        }

        $city->update($validated);

        return redirect()->route('city.index')->with('success', 'Ciudad actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(City $city)
    {
        $city->delete();
        return redirect()->route('city.index');
    }
}