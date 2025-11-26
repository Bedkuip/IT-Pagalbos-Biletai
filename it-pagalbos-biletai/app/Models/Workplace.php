<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @OA\Schema(
 *   schema="Workplace",
 *   type="object",
 *   title="Workplace",
 *   description="Darbo vietos objektas",
 *   @OA\Property(property="id", type="integer", example=1),
 *   @OA\Property(property="name", type="string", example="Faculty of IT"),
 *   @OA\Property(property="email", type="string", example="it@university.lt"),
 *   @OA\Property(property="role", type="string", enum={"user","admin"}, example="user"),
 *   @OA\Property(property="created_at", type="string", format="date-time", example="2025-10-22T06:00:00Z"),
 *   @OA\Property(property="updated_at", type="string", format="date-time", example="2025-10-22T06:05:00Z")
 * )
 */
class Workplace extends Model
{
    use HasFactory;
    protected $fillable = ['name','email','role'];
}

