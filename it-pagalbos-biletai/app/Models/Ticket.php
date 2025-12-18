<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @OA\Schema(
 *   schema="Ticket",
 *   type="object",
 *   title="Ticket",
 *   description="Pagalbos bilieto objektas",
 *   @OA\Property(property="id", type="integer", example=10),
 *   @OA\Property(property="workplace_id", type="integer", example=1),
 *   @OA\Property(property="device_id", type="integer", example=5),
 *   @OA\Property(property="status", type="string", enum={"open","in_progress","resolved"}, example="open"),
 *   @OA\Property(property="priority", type="string", enum={"low","medium","high"}, example="high"),
 *   @OA\Property(property="description", type="string", example="Printer not working"),
 *   @OA\Property(property="assigned_specialist", type="string", example="Jonas Specialist"),
 *   @OA\Property(property="created_at", type="string", format="date-time", example="2025-10-22T06:00:00Z"),
 *   @OA\Property(property="updated_at", type="string", format="date-time", example="2025-10-22T06:05:00Z")
 * )
 */
class Ticket extends Model
{
    use HasFactory;
    protected $fillable = [
        'workplace_id','device_id','status','priority','description','assigned_specialist'
    ];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}
