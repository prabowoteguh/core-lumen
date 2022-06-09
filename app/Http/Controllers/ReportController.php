<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * @OA\Get(
     *     path="/report",
     *     tags={"Report"},
     *     operationId="index",
     *     summary="Get Report",
     *     description="",
     *     @OA\SecurityScheme(
     *        securityScheme="bearerAuth",
     *        type="http",
     *        scheme="bearer"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\Schema(
     *             type="array",
     *             @OA\Items(ref="example")
     *         ),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorize",
     *     ),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function index(Request $request)
    {
       //
    }
}
