<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Request $request, $hotelId)
    {
        $hotel = Hotel::findOrFail($hotelId);

        $validated = $request->validate([
            'type' => 'required|in:Estándar,Junior,Suite',
            'accommodation' => 'required|in:Sencilla,Doble,Triple,Cuádruple',
            'quantity' => 'required|integer|min:1',
        ]);

        // Validar la combinación de tipo y acomodación
        $validTypes = [
            'Estándar' => ['Sencilla', 'Doble'],
            'Junior' => ['Triple', 'Cuádruple'],
            'Suite' => ['Sencilla', 'Doble', 'Triple'],
        ];

        if (!in_array($validated['accommodation'], $validTypes[$validated['type']])) {
            $message = "El tipo de habitación {$validated['type']} solo puede tener acomodación {$validTypes[$validated['type']][0]} o {$validTypes[$validated['type']][1]}";
            return response()->json(['error' => $message], 422);
        }

        // Validar el total de habitaciones del hotel
        $currentRooms = $hotel->rooms->sum('quantity');
        if ($currentRooms + $validated['quantity'] > $hotel->max_rooms) {
            return response()->json(['error' => 'El total de habitaciones supera el máximo permitido'], 422);
        }

        // Crear la habitación asociada al hotel
        $room = $hotel->rooms()->create($validated);
        return response()->json($room, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return response()->json(Room::findOrFail($id)->delete());
    }
}
