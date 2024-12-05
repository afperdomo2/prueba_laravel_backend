<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Hotel::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:hotels',
            'address' => 'required|string',
            'city' => 'required|string',
            'nit' => 'required|string|unique:hotels',
            'max_rooms' => 'required|integer|min:1',
        ]);

        $hotel = Hotel::create($validated);
        return response()->json($hotel, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json(Hotel::with('rooms')->findOrFail($id));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return response()->json(Hotel::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $hotel = Hotel::findOrFail($id);

        $validated = $request->validate([
            'name' => 'string|unique:hotels,name,' . $hotel->id,
            'address' => 'string',
            'city' => 'string',
            'nit' => 'string|unique:hotels,nit,' . $hotel->id,
            'max_rooms' => 'integer|min:1',
        ]);

        $hotel->update($validated);
        return response()->json($hotel);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $hotel = Hotel::findOrFail($id);
        $hotel->delete();
        return response()->json($hotel);
    }
}
