<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Middleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $authHeader = $request->header('Authorization');
        if ($authHeader && str_starts_with($authHeader, 'Bearer ')) {
            $token = trim(substr($authHeader, 7));

            // Find user by remember_token
            $user = User::where('remember_token', $token)->first();
            if ($user) {
                Auth::login($user);
                return $next($request);
            }
        }

        return response()->json([
            'result' => false,
            'message' => 'Unauthorized you need to login first !! '
        ], 401);
    }
}