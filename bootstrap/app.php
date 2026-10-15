<?php

use App\Exceptions\ApiException;
use App\Exceptions\ApiUnauthenticatedException;
use App\Http\Middleware\EnsureApiRole;
use App\Services\ArkanaApi;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'api.role' => EnsureApiRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );

        // Expired/revoked token: drop the API session and ask to log in again.
        $exceptions->render(function (ApiUnauthenticatedException $e, Request $request) {
            app(ArkanaApi::class)->forgetSession();

            return redirect()->guest(route('login'))->with('error', 'Sesi Anda telah berakhir. Silakan masuk kembali.');
        });

        // Other API failures: forms go back with the message, pages show it.
        $exceptions->render(function (ApiException $e, Request $request) {
            if ($e->status === 404) {
                abort(404);
            }

            if (! $request->isMethod('GET')) {
                return back()->withInput()->with('error', $e->getMessage());
            }

            return response()->view('errors.api', ['message' => $e->getMessage()], $e->status >= 500 ? 503 : $e->status);
        });

        $exceptions->dontReport([ApiException::class]);
    })->create();
