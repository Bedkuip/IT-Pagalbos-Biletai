<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class TicketController extends Controller
{
    /**
     * @OA\Get(
     *   path="/api/v1/tickets",
     *   tags={"Tickets"},
     *   summary="List all tickets (with optional filters)",
     *   @OA\Parameter(name="status", in="query", required=false, @OA\Schema(type="string", enum={"open","in_progress","resolved"})),
     *   @OA\Parameter(name="assigned", in="query", required=false, @OA\Schema(type="string")),
     *   @OA\Response(
     *     response=200,
     *     description="Successful list",
     *     @OA\JsonContent(
     *       type="array",
     *       @OA\Items(ref="#/components/schemas/Ticket")
     *     )
     *   )
     * )
     */
    public function index(Request $r) {
        $q = Ticket::query();
        // apply filters if present
        foreach (['status','type','assigned_specialist'] as $f) if($r->filled($f)) $q->where($f, $r->$f);
        return response()->json($q->paginate(10), 200);
    }


    /**
     * @OA\Get(
     *   path="/api/v1/workplaces/{id}/tickets",
     *   tags={"Workplaces"},
     *   summary="Get all tickets for a workplace",
     *   @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *   @OA\Response(response=200, description="List of tickets", @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Ticket")))
     * )
     */
    public function ticketsByWorkplace($id) {
        $tickets = Ticket::where('workplace_id', $id)->get();
        return response()->json($tickets, 200);
    }


    public function create()
    {
        //
    }

    /**
     * @OA\Post(
     *   path="/api/v1/tickets",
     *   tags={"Tickets"},
     *   summary="Create a new ticket",
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(ref="#/components/schemas/Ticket")
     *   ),
     *   @OA\Response(
     *     response=201,
     *     description="Created",
     *     @OA\JsonContent(ref="#/components/schemas/Ticket")
     *   ),
     *   @OA\Response(response=422, description="Validation error"),
     *   @OA\Response(response=400, description="Bad payload")
     * )
     */
    public function store(Request $r) {
        // Only users can create
        if ($r->get('role') !== 'user') {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        $data = $r->validate([
            'workplace_id' => 'required|exists:workplaces,id',
            'device_id' => 'required|exists:devices,id',
            'status' => 'required|in:open,in_progress,resolved',
            'priority' => 'required|in:low,medium,high',
            'description' => 'required|min:5',
            'assigned_specialist' => 'nullable|string'
        ]);

        $m = Ticket::create($data);
        return response()->json($m, 201);
    }

    /**
     * @OA\Get(
     *   path="/api/v1/tickets/{id}",
     *   tags={"Tickets"},
     *   summary="Get a ticket by ID",
     *   @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *   @OA\Response(
     *     response=200,
     *     description="Found",
     *     @OA\JsonContent(ref="#/components/schemas/Ticket")
     *   ),
     *   @OA\Response(response=404, description="Not found")
     * )
     */
    public function show($id) {
        $m = Ticket::find($id);
        if(!$m) return response()->json(['error'=>'Not found'], 404);
        return response()->json($m, 200);
    }
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * @OA\Put(
     *   path="/api/v1/tickets/{id}",
     *   tags={"Tickets"},
     *   summary="Update a ticket",
     *   @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(ref="#/components/schemas/Ticket")
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Updated",
     *     @OA\JsonContent(ref="#/components/schemas/Ticket")
     *   ),
     *   @OA\Response(response=404, description="Not found"),
     *   @OA\Response(response=422, description="Validation error")
     * )
     */
    public function update(Request $r, $id) {
        // Only users can update
        /*
        if ($r->get('role') !== 'user') {
            return response()->json(['error' => 'Forbidden'], 403);
        }
        */
        \Log::info('Role found: ' . $r->attributes->get('role'));

        $role = $r->attributes->get('role');
        if ($role !== 'user') {
            return response()->json(['error' => 'Forbidden'], 403);
        }
        $m = Ticket::find($id);
        if (!$m) return response()->json(['error' => 'Not found'], 404);

        $data = $r->validate([
            'status' => 'in:open,in_progress,resolved',
            'priority' => 'in:low,medium,high',
            'description' => 'min:5',
            'assigned_specialist' => 'nullable|string'
        ]);

        $m->update($data);
        return response()->json($m, 200);
    }
    /**
     * @OA\Delete(
     *   path="/api/v1/tickets/{id}",
     *   tags={"Tickets"},
     *   summary="Delete a ticket",
     *   @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *   @OA\Response(response=204, description="Deleted (no content)"),
     *   @OA\Response(response=404, description="Not found")
     * )
     */
    public function destroy(Request $r, $id) {
        // Only admins can delete
        if ($r->get('role') !== 'admin') {
            return response()->json(['error' => 'You Cant'], 403);
        }

        $m = Ticket::find($id);
        if (!$m) return response()->json(['error' => 'Not found'], 404);

        $m->delete();
        return response()->noContent(); // 204
    }
}
