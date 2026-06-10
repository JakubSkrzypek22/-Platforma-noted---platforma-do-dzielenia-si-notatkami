<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class VipController extends Controller
{
    /** Cena pakietu VIP (zł). */
    private const PRICE = 19.99;

    // Strona z prezentacją oferty VIP
    public function index(Request $request)
    {
        return view('vip.index');
    }

    // Podsumowanie zamówienia przed przekierowaniem do Stripe
    public function checkout(Request $request)
    {
        if ($request->user()->isVip()) {
            return redirect()->route('dashboard')->with('success', 'Posiadasz już aktywne konto VIP!');
        }

        return view('vip.checkout', ['price' => self::PRICE]);
    }

    // Rozpoczęcie płatności VIP przez Stripe Checkout
    public function processPayment(Request $request)
    {
        $user = $request->user();

        if ($user->isVip()) {
            return redirect()->route('dashboard');
        }

        if (! config('services.stripe.secret')) {
            return back()->with('error', 'Płatności nie są jeszcze skonfigurowane. Uzupełnij klucze Stripe w pliku .env.');
        }

        try {
            $response = $this->stripeClient()->post('https://api.stripe.com/v1/checkout/sessions', [
                'mode'           => 'payment',
                'success_url'    => route('vip.payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url'     => route('vip.checkout'),
                'customer_email' => $user->email,
                'line_items'     => [[
                    'quantity'   => 1,
                    'price_data' => [
                        'currency'     => 'pln',
                        'unit_amount'  => (int) round(self::PRICE * 100),
                        'product_data' => ['name' => 'Noted VIP — konto Premium (30 dni)'],
                    ],
                ]],
                'metadata' => [
                    'user_id' => $user->id,
                    'type'    => 'vip',
                ],
            ]);
        } catch (\Throwable $e) {
            report($e);

            return back()->with('error', 'Nie udało się połączyć z systemem płatności. Spróbuj ponownie za chwilę.');
        }

        if (! $response->successful() || ! $response->json('url')) {
            report(new \RuntimeException('Stripe VIP checkout error: ' . $response->body()));

            return back()->with('error', 'Nie udało się rozpocząć płatności. Spróbuj ponownie później.');
        }

        return redirect()->away($response->json('url'));
    }

    // Powrót ze Stripe — weryfikacja płatności i aktywacja VIP
    public function paymentSuccess(Request $request)
    {
        $user      = $request->user();
        $sessionId = $request->query('session_id');

        if ($user->isVip()) {
            return redirect()->route('dashboard')->with('success', 'Twoje konto VIP jest już aktywne.');
        }

        if (! $sessionId || ! config('services.stripe.secret')) {
            return redirect()->route('vip.index');
        }

        try {
            $session = $this->stripeClient()->get("https://api.stripe.com/v1/checkout/sessions/{$sessionId}");
        } catch (\Throwable $e) {
            report($e);

            return redirect()->route('vip.index')->with('error', 'Nie udało się zweryfikować płatności.');
        }

        $paid       = $session->successful() && $session->json('payment_status') === 'paid';
        $matchesYou = (int) $session->json('metadata.user_id') === $user->id;

        if ($paid && $matchesYou) {
            $user->update(['is_vip' => true]);

            return redirect()->route('dashboard')
                ->with('success', 'Gratulacje! Twoje konto zostało uaktualnione do statusu VIP. Witamy w klubie Premium!');
        }

        return redirect()->route('vip.index')
            ->with('error', 'Płatność nie została potwierdzona. Jeśli pobraliśmy środki, skontaktuj się z nami.');
    }

    /**
     * Klient HTTP do Stripe z pakietem certyfikatów CA (Windows/PHP bez curl.cainfo).
     */
    private function stripeClient(): \Illuminate\Http\Client\PendingRequest
    {
        $client   = Http::asForm()->timeout(25)->withToken(config('services.stripe.secret'));
        $caBundle = storage_path('certs/cacert.pem');

        if (is_file($caBundle)) {
            return $client->withOptions(['verify' => $caBundle]);
        }

        if (app()->environment('local')) {
            return $client->withoutVerifying();
        }

        return $client;
    }
}
