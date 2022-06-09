<?php

/* ==============================================================
| Author        : prabowoteguh
| Created at    : Tue, April 17 2021 23:49:20
| Modify at     : Tue, April 17 2021 23:49:20
| Location      : Unknown
| Description   : Post Controller Example CRUD
=================================================================*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Validator;
use DB;
use Crypt;
use Illuminate\Support\Facades\Mail;
use App\Libraries\Helpers;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['all']]);
    }

    /**
     * Display a first of page.
     * @return Response
     */

    /**
     * @OA\Get(
     *     path="/user",
     *     tags={"Users"},
     *     operationId="index",
     *     summary="Get all data users",
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
        $total_data         = User::count();
        eval(b_core());
        $status_code        = 200;
        $data["pagination"] = $pagination;
        $data["results"]    = User::limit($limit)->offset($offset)->get();
        $response           = b_json_response(true, $status_code, "Data User Successfully loaded!", $data);

    	return response()->json($response);
    }

    /**
     * @OA\Get(
     *     path="/user/all",
     *     tags={"Users"},
     *     operationId="all",
     *     summary="Get all data users",
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
    public function all(Request $request)
    {
        $data["results"]    = User::select(['id', 'relation_id', 'email', 'name', 'avatar'])->orderBy('name', 'ASC')->get();
        $response           = b_json_response(true, 200, "Data User Successfully loaded!", $data);

    	return response()->json($response);
    }

    /**
     * @OA\Get(
     *     path="/user/employee",
     *     tags={"Users"},
     *     operationId="employee",
     *     summary="Get all data of employee",
     *     description="",
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
     *     security={
     *       {"api_key": {"bearer token"}}
     *     }     
     * )
     */
    public function employee()
    {
        $data['result'] = User::where('role', 2)->paginate(10);
        return response()->json(b_json_response(true, 200, 'Data user showed successfully!', $data), 200);
    }

    /**
     * @OA\Get(
     *     path="/user/admin",
     *     tags={"Users"},
     *     operationId="admin",
     *     summary="Get all data of admin",
     *     description="",
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
     *         description="Unauthorize"
     *     ),
     *     security={
     *       {"api_key": {"bearer token"}}
     *     }
     * )
    */
    public function admin()
    {
        $data['result'] = User::where('role', 1)->paginate(10);
        return response()->json(b_json_response(true, 200, 'Data user showed successfully!', $data), 200);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */

    /**
     * @OA\Post(
     *     path="/user/create",
     *     tags={"Users"},
     *     operationId="store",
     *     summary="Add a new user to the store",
     *     description="",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/form-data",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="name",
     *                     description="Name of user",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     description="Email user",
     *                     type="string",
     *                     format="email",
     *                 ),
     *                 @OA\Property(
     *                     property="phone",
     *                     description="Phone number user",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="role",
     *                     description="Role of user (admin or employee)",
     *                     type="int"
     *                 ),
     *                 @OA\Property(
     *                     property="address",
     *                     description="Address user",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="position",
     *                     description="Position of user (Ex: Operator Produksi)",
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
			'name'     => 'required',
			'email'    => 'required|email|unique:users',
			'phone'    => 'required|unique:users',
			'role'     => 'required',
			'address'  => 'required',
			'position' => 'required',
	    ]);

        // if ($request->hasFile('avatar')) {
        //     #upload
        //     $request->file('avatar');
        // }

        /* ===== Your transaction goes here ===== */
        try {
            DB::beginTransaction();
            $data = [
				'name'     => $request->name,
				'email'    => $request->email,
				'phone'    => $request->phone,
				'role'     => $request->role,
				'address'  => $request->address,
				'avatar'   => $request->avatar,
				'position' => $request->position,
				'relation_id' => "REL".rand(1, 999),
            ];
            
			$create           = new User($data);
			$create->password = app('hash')->make('12345678');
            $create->save();

            if ($create) {
                DB::commit();
                return response()->json(b_json_response(true, 200, 'User Created Successfully!', $create), 200);
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
     * @OA\Get(
     *     path="/user/detail/{id}",
     *     tags={"Users"},
     *     operationId="show",
     *     summary="Get detail of user",
     *     description="",
     *     @OA\Parameter(
     *         description="user id to show detail",
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
    public function show(Request $request, $id)
    {
        return response()->json(b_json_response(true, 200, 'User Created Successfully Showing!', User::findOrfail($id)), 200);
    }

    /**
     * @OA\Put(
     *     path="/user/update/{id}",
     *     tags={"Users"},
     *     operationId="update",
     *     summary="Update an existing user",
     *     description="",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="name",
     *                     description="Name of user",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     description="Email user",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="phone",
     *                     description="Phone number user",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="role",
     *                     description="Role of user {admin or employee}",
     *                     type="int32"
     *                 ),
     *                 @OA\Property(
     *                     property="address",
     *                     description="Address user",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="position",
     *                     description="Position of user (Ex: Operator Produksi)",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="avatar",
     *                     description="Avatar of user",
     *                     type="string",
     *                     format="file",
     *                 ),
     *             )
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="user id to update",
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
    public function update(Request $request, $id)
    {
    	/* ===== Your Validation is Here ===== */
   		$this->validate($request, [
			'name'     => 'required',
			'email'    => 'required|email|unique:users,email,'. $id,
			'phone'    => 'required|unique:users,phone,'. $id,
			'role'     => 'required',
			'address'  => 'required',
			'position' => 'required',
	    ]);

        /* ===== Your transaction goes here ===== */
        try {
            DB::beginTransaction();
			$data = [
				'name'     => $request->name,
				'email'    => $request->email,
				'phone'    => $request->phone,
				'role'     => $request->role,
				'address'  => $request->address,
				'avatar'   => $request->avatar,
				'position' => $request->position,
            ];
            
            $user   = User::findOrfail($id);
            $update = $user->update($data);

            if ($update) {
                DB::commit();
                return response()->json(b_json_response(true, 200, 'User Updated Successfully!', $update), 200);
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
     * @OA\Delete(
     *     path="/user/delete/{id}",
     *     summary="Deletes a user by id",
     *     description="",
     *     operationId="destroy",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         description="user id to delete",
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
            $user   = User::findOrfail($id);
            $delete = $user->delete();

            if ($delete) {
                DB::commit();
                return response()->json(b_json_response(true, 200, 'User Deleted Successfully!', $delete), 200);
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