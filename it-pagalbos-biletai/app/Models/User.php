<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @OA\Schema(
 *     schema="User",
 *     type="object",
 *     title="Naudotojas",
 *     description="Sistemos naudotojo modelis",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Jonas Jonaitis"),
 *     @OA\Property(property="email", type="string", example="jonas@example.com"),
 *     @OA\Property(property="password", type="string", example="hashed_password", description="Slaptažodis saugomas hash formatu"),
 *     @OA\Property(property="role", type="string", example="member", description="Naudotojo rolė: guest, member, admin"),
 *     @OA\Property(property="darboviete_id", type="integer", example=2, description="Naudotojo darbovietės ID")
 * )
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'darboviete_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
