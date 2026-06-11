<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trip;

class TripController extends Controller
{
    public function index(Request $request)
    {
        $trips = Trip::with('country')->get(); // docelowo filtrowane dla usera
        return view('trips.index', compact('trips'));
    }

    public function store(Request $request)
    {
        // TODO: Dodanie walidacji dla wycieczki (Admin only)
        $validated = $request->validate([
            'name' => 'required|string|max:25',
            'continent' => 'required|string|max:25',
            'period' => 'required|integer',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'img' => 'required|string|max:25',
            'country_id' => 'required|exists:countries,id',
        ]);

        Trip::create($validated);

        return redirect()->route('trips')->with('success', 'Wycieczka dodana pomyślnie.');
    }
}
