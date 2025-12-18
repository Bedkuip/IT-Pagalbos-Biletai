<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\RefreshToken;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Firebase\JWT\JWT;

/**
 * @OA\Tag(
 *     name="Auth",
 *     description="Autentifikacijos ir autorizacijos API"
 * )
 */
class AuthController extends Controller {
    /**
     * @OA\Post(
     *     path="/auth/login",
     *     tags={"Auth"},
     *     summary="Prisijungimas",
     *     description="Naudotojas pateikia el. paštą ir slaptažodį, gauna JWT access ir refresh tokenus",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", example="user@example.com"),
     *             @OA\Property(property="password", type="string", example="secret123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sėkmingas prisijungimas",
     *         @OA\JsonContent(
     *             @OA\Property(property="access_token", type="string"),
     *             @OA\Property(property="access_expires_in", type="integer", example=900),
     *             @OA\Property(property="refresh_token", type="string")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Neteisingi prisijungimo duomenys")
     * )
     */


public function login(Request $req)
{
    // Find user by email only
    $user = User::where('email', $req->email)->first();

    if (!$user) {
        return response()->json(['error' => 'Invalid email'], 401);
    }

    // Generate access token
    $access = JWT::encode([
        'sub' => $user->id,
        'role' => $user->role,
        'exp' => now()->addMinutes(config('auth.access_ttl'))->timestamp,
    ], env('JWT_SECRET'), 'HS256');

    // Generate refresh token
    $refreshPlain = Str::random(64);
    RefreshToken::create([
        'user_id' => $user->id,
        'token_hash' => hash('sha256', $refreshPlain),
        'expires_at' => now()->addDays(config('auth.refresh_ttl')),
        'user_agent' => $req->userAgent(),
        'ip' => $req->ip(),
    ]);

    // Return tokens
    return response()->json([
        'access_token' => $access,
        'access_expires_in' => config('auth.access_ttl') * 60,
        'refresh_token' => $refreshPlain,
    ]);
}
    /**
     * @OA\Post(
     *     path="/auth/refresh",
     *     tags={"Auth"},
     *     summary="Atnaujinti JWT tokenus",
     *     description="Naudotojas pateikia refresh tokeną, gauna naują access ir refresh tokenų porą",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"refresh_token"},
     *             @OA\Property(property="refresh_token", type="string", example="abc123...")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sėkmingai atnaujinti tokenai",
     *         @OA\JsonContent(
     *             @OA\Property(property="access_token", type="string"),
     *             @OA\Property(property="access_expires_in", type="integer", example=900),
     *             @OA\Property(property="refresh_token", type="string")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Neteisingas arba pasibaigęs refresh tokenas")
     * )
     */
    public function refresh(Request $req)
    {
        $provided = $req->input('refresh_token');
        $hash = hash('sha256', $provided);

        $stored = RefreshToken::where('token_hash', $hash)->first();
        if (!$stored || $stored->revoked_at || $stored->expires_at->isPast()) {
            return response()->json(['error' => 'Invalid refresh token'], 401);
        }

        // Rotacija: atšaukti seną
        $stored->update(['revoked_at' => now()]);

        $user = $stored->user;

        $access = JWT::encode([
            'sub' => $user->id,
            'role' => $user->role,
            'exp' => now()->addMinutes(config('auth.access_ttl'))->timestamp,
        ], env('JWT_SECRET'), 'HS256');

        $newPlain = Str::random(64);
        RefreshToken::create([
            'user_id' => $user->id,
            'token_hash' => hash('sha256', $newPlain),
            'expires_at' => now()->addDays(config('auth.refresh_ttl')),
            'user_agent' => $req->userAgent(),
            'ip' => $req->ip(),
        ]);

        return response()->json([
            'access_token' => $access,
            'access_expires_in' => config('auth.access_ttl') * 60,
            'refresh_token' => $newPlain,
        ]);
    }
    /**
     * @OA\Post(
     *     path="/auth/logout",
     *     tags={"Auth"},
     *     summary="Atsijungimas",
     *     description="Naudotojas pateikia refresh tokeną, kuris anuliuojamas",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"refresh_token"},
     *             @OA\Property(property="refresh_token", type="string", example="abc123...")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sėkmingas atsijungimas",
     *         @OA\JsonContent(
     *             @OA\Property(property="ok", type="boolean", example=true)
     *         )
     *     )
     * )
     */
    public function logout(Request $req)
    {
        $provided = $req->input('refresh_token');
        $hash = hash('sha256', $provided);

        RefreshToken::where('token_hash', $hash)->update(['revoked_at' => now()]);
        return response()->json(['ok' => true]);
    }

}
/* YES PASSWORD
public function login(Request $req)
{
    $user = User::where('email', $req->email)->first();
    if (!$user || !Hash::check($req->password, $user->password)) {
        return response()->json(['error' => 'Invalid credentials'], 401);
    }

    $access = JWT::encode([
        'sub' => $user->id,
        'role' => $user->role,
        'exp' => now()->addMinutes(config('auth.access_ttl'))->timestamp,
    ], env('JWT_SECRET'), 'HS256');

    $refreshPlain = Str::random(64);
    RefreshToken::create([
        'user_id' => $user->id,
        'token_hash' => hash('sha256', $refreshPlain),
        'expires_at' => now()->addDays(config('auth.refresh_ttl')),
        'user_agent' => $req->userAgent(),
        'ip' => $req->ip(),
    ]);

    return response()->json([
        'access_token' => $access,
        'access_expires_in' => config('auth.access_ttl') * 60,
        'refresh_token' => $refreshPlain,
    ]);
}*/
