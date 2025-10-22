<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class DeviceController extends Controller
{
    /**
     * @OA\Get(
     *   path="/api/v1/devices",
     *   tags={"Devices"},
     *   summary="List all devices (with optional filters)",
     *   @OA\Parameter(name="type", in="query", required=false, @OA\Schema(type="string", enum={"pc","printer","network","other"})),
     *   @OA\Parameter(name="status", in="query", required=false, @OA\Schema(type="string", enum={"active","inactive","maintenance"})),
     *   @OA\Response(response=200, description="Successful list")
     * )
     */
    public function index(Request $r) {
        $q = Device::query();
        // apply filters if present
        foreach (['status','type','assigned_specialist'] as $f) if($r->filled($f)) $q->where($f, $r->$f);
        return response()->json($q->paginate(10), 200);
    }

    public function create()
    {
        //
    }

    /**
     * @OA\Post(
     *   path="/api/v1/devices",
     *   tags={"Devices"},
     *   summary="Create a new device",
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       required={"workplace_id","type","status"},
     *       @OA\Property(property="workplace_id", type="integer", example=1),
     *       @OA\Property(property="type", type="string", enum={"pc","printer","network","other"}, example="pc"),
     *       @OA\Property(property="status", type="string", enum={"active","inactive","maintenance"}, example="active"),
     *       @OA\Property(property="serial", type="string", example="SN-1234-XYZ")
     *     )
     *   ),
     *   @OA\Response(response=201, description="Created"),
     *   @OA\Response(response=422, description="Validation error"),
     *   @OA\Response(response=400, description="Bad payload")
     * )
     */
    public function store(Request $r) {
        $data = $r->validate([
    'workplace_id' => 'required|exists:workplaces,id',
    'type' => 'required|in:pc,printer,network,other',
    'status' => 'required|in:active,inactive,maintenance',
    'serial' => 'nullable|string'
]);
        $m = Device::create($data);
        return response()->json($m, 201);
    }

    /**
     * @OA\Get(
     *   path="/api/v1/devices/{id}",
     *   tags={"Devices"},
     *   summary="Get a device by ID",
     *   @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *   @OA\Response(response=200, description="Found"),
     *   @OA\Response(response=404, description="Not found")
     * )
     */
    public function show($id) {
        $m = Device::find($id);
        if(!$m) return response()->json(['error'=>'Not found'], 404);
        return response()->json($m, 200);
    }

    public function edit(Device $device)
    {
        //
    }

    /**
     * @OA\Put(
     *   path="/api/v1/devices/{id}",
     *   tags={"Devices"},
     *   summary="Update a device",
     *   @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       @OA\Property(property="type", type="string", enum={"pc","printer","network","other"}),
     *       @OA\Property(property="status", type="string", enum={"active","inactive","maintenance"}),
     *       @OA\Property(property="serial", type="string")
     *     )
     *   ),
     *   @OA\Response(response=200, description="Updated"),
     *   @OA\Response(response=404, description="Not found"),
     *   @OA\Response(response=422, description="Validation error")
     * )
     */
    public function update(Request $r, $id) {
        $m = Device::find($id);
        if(!$m) return response()->json(['error'=>'Not found'], 404);
        $data = $r->validate([/* rules per Device */]);
        $m->update($data);
        return response()->json($m, 200);
    }

    /**
     * @OA\Delete(
     *   path="/api/v1/devices/{id}",
     *   tags={"Devices"},
     *   summary="Delete a device",
     *   @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *   @OA\Response(response=204, description="Deleted"),
     *   @OA\Response(response=404, description="Not found")
     * )
     */
    public function destroy($id) {
        $m = Device::find($id);
        if(!$m) return response()->json(['error'=>'Not found'], 404);
        $m->delete();
        return response()->noContent(); // 204
    }
}
