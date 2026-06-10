<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use App\Models\Purchase;
use App\Models\Review;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Widok główny panelu: Statystyki i Zarządzanie Notatkami
     */
    public function index()
    {
        // Pobieramy wszystkie notatki z relacją autora, od najnowszych
        $notes = Note::with('author')->latest()->get();
        
        // Obliczanie statystyk globalnych
        $usersCount = User::count();
        $notesCount = Note::count();
        
        // Sumujemy obrót tylko ze sfinalizowanych płatności (np. Stripe)
        $totalRevenue = Purchase::where('status', 'completed')->sum('amount');

        return view('admin.index', compact('notes', 'usersCount', 'notesCount', 'totalRevenue'));
    }

    /**
     * Widok panelu: Zarządzanie Użytkownikami
     */
    public function users()
    {
        // Pobieramy użytkowników z automatycznym zliczeniem ich aktywności, od najnowszych
        $users = User::withCount(['notes', 'purchases'])->latest()->get();
        
        return view('admin.users', compact('users'));
    }

    /**
     * Akcja: Nadawanie / Odbieranie statusu VIP u użytkownika
     */
    public function toggleVip(User $user)
    {
        // Zabezpieczenie przed zmianą uprawnień innego administratora
        if ($user->isAdmin()) {
            return back()->with('error', 'Nie można modyfikować statusu innego administratora.');
        }

        // Odwracamy status VIP w bazie danych
        $user->update([
            'is_vip' => !$user->is_vip
        ]);
        
        $message = $user->is_vip ? 'otrzymał status VIP!' : 'stracił status VIP.';
        return back()->with('success', "Użytkownik {$user->name} {$message}");
    }

    /**
     * Akcja: Bezpowrotne kasowanie użytkownika z bazy danych
     */
    public function destroyUser(User $user)
    {
        // Blokada bezpieczeństwa: admin nie może usunąć samego siebie ani innego admina
        if ($user->isAdmin()) {
            return back()->with('error', 'Operacja zabroniona. Nie możesz usunąć konta administratora!');
        }

        $user->delete(); 
        return back()->with('success', "Użytkownik {$user->name} został pomyślnie usunięty z platformy.");
    }

    /**
     * Akcja: Kasowanie nieodpowiedniej opinii/recenzji notatki przez moderatora
     */
    public function destroyReview(Review $review)
    {
        $review->delete();
        return back()->with('success', 'Komentarz/opinia została trwale usunięta.');
    }
}