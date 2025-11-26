<?php
namespace App\Http\Middleware;

use Closure;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtMiddleware
{
    public function handle($request, Closure $next)
    {
        $token = $request->bearerToken(); // paima Authorization: Bearer <token>

        if (!$token) {
            return response()->json(['error' => 'Token not provided'], 401);
        }

        try {
            $credentials = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));
            // galima priskirti user_id prie request
            $request->attributes->add(['user_id' => $credentials->sub, 'role' => $credentials->role]);
        } catch (Exception $e) {
            return response()->json(['error' => 'Invalid or expired token'], 401);
        }

        return $next($request);
    }
}
