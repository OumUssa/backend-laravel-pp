<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        
        // 1. Tell Laravel 11 to append CORS headers to all API routes
        $middleware->append(\Illuminate\Http\Middleware\HandleCors::class);

        // Exclude specific routes from CSRF if needed
        $middleware->validateCsrfTokens(
            except: [
                'createUser', 
            ]
        );

        $middleware->alias([
            'auth.api' => \App\Http\Middleware\Middleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Your custom 404 handler for API routes
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => 'Record not found.'
                ], 404)
                ->header('Access-Control-Allow-Origin', '*')
                ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
                ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
            }
        });
    })
    ->create();