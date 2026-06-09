<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VipController extends Controller
{
    // Strona z prezentacją oferty VIP
    public function index(Request $request)
    {
        return view('vip.index');
    }

    // Formularz płatności (Kasa)
    public function checkout(Request $request)
    {
        if ($request->user()->isVip()) {
            return redirect()->route('dashboard')->with('success', 'Posiadasz już aktywne konto VIP!');
        }
        return view('vip.checkout');
    }

    // Przetwarzanie płatności kartą i aktywacja flagi w bazie
    public function processPayment(Request $request)
    {
        $user = $request->user();

        if ($user->isVip()) {
            return redirect()->route('dashboard');
        }

        $request->validate([
            'card_name'   => 'required|string|max:255',
            'card_number' => 'required|string',
            'card_expiry' => 'required|string',
            'card_cvc'    => 'required|string',
        ], [
            'card_name.required'   => 'Podaj imię i nazwisko właściciela karty.',
            'card_number.required' => 'Podaj numer karty.',
            'card_expiry.required' => 'Podaj datę ważności karty.',
            'card_cvc.required'    => 'Podaj kod CVC.',
        ]);

        // Aktywujemy konto VIP bezpośrednio na modelu użytkownika
        $user->update(['is_vip' => true]);

        return redirect()->route('dashboard')
            ->with('success', 'Gratulacje! Twoje konto zostało uaktualnione do statusu VIP. Witamy w klubie Premium!');
    }
}