<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    public function index()
    {
        $notes = Note::with(['subject', 'user'])->get();
        return view('notes.index', compact('notes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'description' => 'required|string',
            'subject_id' => 'required|integer',
            'img' => 'required|string',
        ]);

        $validated['user_id'] = Auth::id();

        Note::create($validated);

        return redirect()->route('notes')->with('success', 'Pomyślnie dodano notatkę do bazy!');
    }
}
