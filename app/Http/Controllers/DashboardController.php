<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $myNotes = $user->notes()
            ->with('files')
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->latest()
            ->get();

        $purchasedNotes = $user->purchasedNotes()
            ->with(['author', 'files'])
            ->withAvg('reviews', 'rating')
            ->orderByDesc('purchases.created_at')
            ->get();

        $favoriteNotes = $user->favoriteNotes()
            ->with(['author', 'files'])
            ->withAvg('reviews', 'rating')
            ->orderByDesc('favorites.created_at')
            ->get();

        $stats = [
            'notes'     => $myNotes->count(),
            'purchased' => $purchasedNotes->count(),
            'favorites' => $favoriteNotes->count(),
            'earnings'  => round($myNotes->sum(fn ($n) => $n->purchases()->sum('amount')), 2),
            'rating'    => $user->sellerReviewsCount() ? $user->sellerRating() : null,
        ];

        return view('dashboard.index', compact('user', 'myNotes', 'purchasedNotes', 'favoriteNotes', 'stats'));
    }
}
