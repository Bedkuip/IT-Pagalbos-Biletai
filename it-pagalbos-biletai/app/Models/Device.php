<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *   schema="Device",
 *   type="object",
 *   title="Device",
 *   description="Įrenginio objektas",
 *   @OA\Property(property="id", type="integer", example=100),
 *   @OA\Property(property="workplace_id", type="integer", example=1),
 *   @OA\Property(property="type", type="string", enum={"pc","printer","network","other"}, example="pc"),
 *   @OA\Property(property="status", type="string", enum={"active","inactive","maintenance"}, example="active"),
 *   @OA\Property(property="serial", type="string", example="SN-1234-XYZ"),
 *   @OA\Property(property="created_at", type="string", format="date-time", example="2025-10-22T06:00:00Z"),
 *   @OA\Property(property="updated_at", type="string", format="date-time", example="2025-10-22T06:05:00Z")
 * )
 */
class Device extends Model
{
    use HasFactory;
    protected $fillable = ['workplace_id','type','status','serial'];
}

