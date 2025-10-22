<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class PingController extends Controller
{
    /**
     * @OA\Get(
     *   path="/api/v1/ping",
     *   tags={"Test"},
     *   summary="Ping endpoint",
     *   @OA\Response(response=200, description="pong")
     * )
     */
    public function ping(Request $r) {
        return response()->json(['pong' => true]);
    }
}
