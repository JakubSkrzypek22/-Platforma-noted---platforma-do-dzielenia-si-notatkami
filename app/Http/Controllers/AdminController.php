<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use App\Models\Purchase;
use Illuminate\Http\Request;
use App\Models\Review;

class AdminController extends Controller
{
    // Widok główny: Statystyki i Notatki
    public function index()
    {
        $notes = Note::with('author')->latest()->get();
        
        // Szybkie statystyki
        $usersCount = User::count();
        $notesCount = Note::count();
        $totalRevenue = Purchase::where('status', 'completed')->sum('amount');

        return view('admin.index', compact('notes', 'usersCount', 'notesCount', 'totalRevenue'));
    }

    // Widok: Lista użytkowników
    public function users()
    {
        // Pobieramy użytkowników wraz z ilością ich notatek i zakupów
        $users = User::withCount(['notes', 'purchases'])->latest()->get();
        
        return view('admin.users', compact('users'));
    }

    // Akcja: Nadawanie / Odbieranie VIP
    public function toggleVip(User $user)
    {
        if ($user->isAdmin()) {
            return back()->with('error', 'Administrator ma już najwyższe uprawnienia.');
        }

        $user->update(['is_vip' => !$user->is_vip]);
        
        $message = $user->is_vip ? 'otrzymał status VIP!' : 'stracił status VIP.';
        return back()->with('success', "Użytkownik {$user->name} {$message}");
    }

    // Akcja: Kasowanie użytkownika
    public function destroyUser(User $user)
    {
        if ($user->isAdmin()) {
            return back()->with('error', 'Nie możesz usunąć konta głównego administratora!');
        }

        $user->delete(); 
        return back()->with('success', 'Użytkownik został trwale usunięty z platformy.');
    }
    // Akcja: Kasowanie opinii/komentarza
    public function destroyReview(Review $review)
    {
        $review->delete();
        return back()->with('success', 'Komentarz został trwale usunięty.');
    }
}