<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    // Znajdź sekcję z middleware i upewnij się, że wygląda mniej więcej tak:
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'admin' => \App\Http\Middleware\CheckAdmin::class,
    ]);
})
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {


        $exceptions->report(function (Exception $e) {
            Log::channel('stderr')->error($e->getMessage());
        });

        $exceptions->render(function (QueryException $e, Request $request) {
            $errorCode = $e->errorInfo[0] ?? null;
            if ($errorCode == '23000') {
                return back()->withError('Nie można usunąć rekordu, dla którego istnieją rekordy podrzędne.');
            } else {
                return back()->withError(print_r($e->errorInfo, true))->withInput();
            }

            return back()->withError($e->getMessage())->withInput();
        });

    })->create();
