<?php

namespace App\Http\Controllers;

use App\Models\Workplace;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class WorkplaceController extends Controller
{
    /**
     * @OA\Get(
     *   path="/api/v1/workplaces",
     *   tags={"Workplaces"},
     *   summary="List all workplaces",
     *   @OA\Response(
     *     response=200,
     *     description="Successful list",
     *     @OA\JsonContent(
     *       type="array",
     *       @OA\Items(ref="#/components/schemas/Workplace")
     *     )
     *   )
     * )
     */
    public function index(Request $r) {
        $q = Workplace::query();
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
     *   path="/api/v1/workplaces",
     *   tags={"Workplaces"},
     *   summary="Create a new workplace",
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(ref="#/components/schemas/Workplace")
     *   ),
     *   @OA\Response(
     *     response=201,
     *     description="Created",
     *     @OA\JsonContent(ref="#/components/schemas/Workplace")
     *   ),
     *   @OA\Response(response=422, description="Validation error"),
     *   @OA\Response(response=400, description="Bad payload")
     * )
     */
    public function store(Request $r) {
        $data = $r->validate([
    'name' => 'required',
    'email' => 'required|email|unique:workplaces,email',
    'role' => 'in:user,admin'
]);
        $m = Workplace::create($data);
        return response()->json($m, 201);
    }

    /**
     * @OA\Get(
     *   path="/api/v1/workplaces/{id}",
     *   tags={"Workplaces"},
     *   summary="Get a workplace by ID",
     *   @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *   @OA\Response(
     *     response=200,
     *     description="Found",
     *     @OA\JsonContent(ref="#/components/schemas/Workplace")
     *   ),
     *   @OA\Response(response=404, description="Not found")
     * )
     */
    public function show($id) {
        $m = Workplace::find($id);
        if(!$m) return response()->json(['error'=>'Not found'], 404);
        return response()->json($m, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Workplace $workplace)
    {
        //
    }
    /**
     * @OA\Put(
     *   path="/api/v1/workplaces/{id}",
     *   tags={"Workplaces"},
     *   summary="Update a workplace",
     *   @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(ref="#/components/schemas/Workplace")
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Updated",
     *     @OA\JsonContent(ref="#/components/schemas/Workplace")
     *   ),
     *   @OA\Response(response=404, description="Not found"),
     *   @OA\Response(response=422, description="Validation error")
     * )
     */
    public function update(Request $r, $id) {
        $m = Workplace::find($id);
        if(!$m) return response()->json(['error'=>'Not found'], 404);
        $data = $r->validate([/* rules per Workplace */]);
        $m->update($data);
        return response()->json($m, 200);
    }

    /**
     * @OA\Delete(
     *   path="/api/v1/workplaces/{id}",
     *   tags={"Workplaces"},
     *   summary="Delete a workplace",
     *   @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *   @OA\Response(response=204, description="Deleted (no content)"),
     *   @OA\Response(response=404, description="Not found")
     * )
     */
    public function destroy($id) {
        $m = Workplace::find($id);
        if(!$m) return response()->json(['error'=>'Not found'], 404);
        $m->delete();
        return response()->noContent(); // 204
    }
}
