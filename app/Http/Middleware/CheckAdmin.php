<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Sprawdzamy: czy użytkownik jest w ogóle zalogowany ORAZ czy ma rolę admina
        if (Auth::check() && Auth::user()->isAdmin()) {
            // Jeśli tak, puszczamy go dalej
            return $next($request);
        }

        // Jeśli nie, odsyłamy go na stronę główną z komunikatem błędu
        return redirect('/')->with('error', 'Brak uprawnień. Strona tylko dla administratorów.');
    }
}