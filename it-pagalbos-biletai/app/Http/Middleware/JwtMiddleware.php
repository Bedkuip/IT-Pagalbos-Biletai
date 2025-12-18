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
        $token = $request->bearerToken(); // Authorization: Bearer <token>

        if (!$token) {
            return response()->json(['error' => 'Token not provided'], 401);
        }

        try {
            // Decode the JWT
            $decoded = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));

            // Force into array to avoid null issues with stdClass
            $credentials = json_decode(json_encode($decoded), true);

            // Debug logs
            \Log::info('Decoded JWT payload:', $credentials);

            // Attach claims to request attributes
            $request->attributes->add([
                'user_id' => $credentials['sub'] ?? null,
                'role'    => $credentials['role'] ?? null,
            ]);

        } catch (Exception $e) {
            \Log::error('JWT decode failed: ' . $e->getMessage());
            return response()->json(['error' => 'Invalid or expired token', 'details' => $e->getMessage()], 401);
        }

        return $next($request); // call $next, not $handle
    }
}
