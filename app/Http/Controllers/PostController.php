<?php

/* ==============================================================
| Author        : prabowoteguh
| Created at    : Tue, April 06 2021 23:49:20
| Modify at     : Tue, April 06 2021 23:49:20
| Location      : Unknown
| Description   : Post Controller Example CRUD
=================================================================*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use DB;

class PostController extends Controller
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
     * Display a first of page.
     * @return Response
     */
    /**
     * @OA\Get(
     *     path="/post",
     *     tags={"post"},
     *     operationId="index",
     *     summary="Get all data post",
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
    public function index()
    {
        return response()->json([
            'code'    => 200,
            'status'  => 'Ok',
            'message' => 'Show data successfully',
            'data'    => Post::all()
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */

    /**
     * @OA\Post(
     *     path="/post/create",
     *     tags={"post"},
     *     operationId="store",
     *     summary="Add a new post to the store",
     *     description="",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/form-data",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="title",
     *                     description="title of post",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="body",
     *                     description="body of post",
     *                     type="string"
     *                 ),
     *             )
     *         )
     *     ),
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
    public function store(Request $request)
    {
    	/* ===== Your Validation is Here ===== */
        $this->validate($request, [
            'title' => 'required',
            'body'  => 'required'
        ]);

        /* ===== Your transaction goes here ===== */
        try {
            DB::beginTransaction();
            $data = [
				'title' => $request->title,
				'body'  => $request->body,
            ];
            
            $create = Post::create($data);

            if ($create) {
                DB::commit();
                return response()->json(b_json_response(true, 200, 'Post Created Successfully!', $create), 200);
            } else {
                DB::rollback();
                return response()->json(b_json_response(false, 400, 'Oops! Something went wrong', null), 405);
            }
        } catch (\Exception $th) {
            DB::rollback();
            return response()->json(b_json_response(false, 405, $th->getMessage(), null), 405);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */

    /**
     * @OA\Put(
     *     path="/post/update/{id}",
     *     tags={"post"},
     *     operationId="update",
     *     summary="Update an existing post",
     *     description="",
     *     @OA\Parameter(
     *         description="Post id to delete",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/form-data",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="title",
     *                     description="title of post",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="body",
     *                     description="body of post",
     *                     type="string"
     *                 ),
     *             )
     *         )
     *     ),
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
    public function update(Request $request, $id)
    {
        /* ===== Your Validation is Here ===== */
        $this->validate($request, [
            'title' => 'required',
            'body'  => 'required'
        ]);

        /* ===== Your transaction goes here ===== */
        try {
            DB::beginTransaction();
			$data = [
				'title' => $request->title,
				'body'  => $request->body,
            ];
            
            $post   = Post::findOrfail($id);
            $update = $post->update($data);

            if ($update) {
                DB::commit();
                return response()->json(b_json_response(true, 200, 'Post Created Successfully!', $update), 200);
            } else {
                DB::rollback();
                return response()->json(b_json_response(false, 400, 'Oops! Something went wrong', null), 405);
            }
        } catch (\Exception $th) {
            DB::rollback();
            return response()->json(b_json_response(false, 405, $th->getMessage(), null), 405);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */

    /**
     * @OA\Delete(
     *     path="/post/delete/{id}",
     *     summary="Deletes a post",
     *     description="",
     *     operationId="destroy",
     *     tags={"post"},
     *     @OA\Parameter(
     *         description="Post id to delete",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
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
    public function destroy(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $post   = Post::findOrfail($id);
            $delete = $post->delete();

            if ($delete) {
                DB::commit();
                return response()->json(b_json_response(true, 200, 'Post Created Successfully!', $delete), 200);
            } else {
                DB::rollback();
                return response()->json(b_json_response(false, 400, 'Oops! Something went wrong', null), 405);
            }
        } catch (\Exception $th) {
            DB::rollback();
            return response()->json(b_json_response(false, 405, $th->getMessage(), null), 405);
        }
    }
}
