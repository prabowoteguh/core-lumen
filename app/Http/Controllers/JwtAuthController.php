<?php

/* ==============================================================
| Author        : prabowoteguh
| Created at    : Tue, April 16 2021 23:49:20
| Modify at     : Tue, April 16 2021 23:49:20
| Location      : Unknown
| Description   : Authentication User
=================================================================*/

namespace App\Http\Controllers;

use DB;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Mail\OtpMail;
use App\Libraries\Helpers;

class JwtAuthController extends Controller
{
	/**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'forgot', 'otp', 'reset']]);
    }

    /**
     * @OA\Post(
     *     path="/logout",
     *     tags={"Auth"},
     *     operationId="logout",
     *     summary="Logout user",
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
    public function logout()
    {
        auth()->logout();
        // auth()->invalidate();
        return response()->json( b_json_response(true, 200, 'Successfully logged out', null));
    }

    /**
     * @OA\Post(
     *     path="/login",
     *     tags={"Auth"},
     *     operationId="login",
     *     summary="Login user",
     *     description="",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/form-data",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="email",
     *                     description="Email user",
     *                     type="string",
     *                     format="email",
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     description="Phone number user",
     *                     type="string"
     *                 ),
     *             )
     *         )
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
     * )
     */
    public function login(Request $request)
    {
		$email       = $request->email;
		$password    = $request->password;
        $success     = false;
        $status_code = 403;
        $message     = http_status_code($status_code);
        $data        = array();

        if (empty($email) or empty($password)) {
            $status_code = 400;
            $message     = "You must fill all the fields";
        } else {
            if (strlen($password) < 6) {
                $message = "Password should be min 6 character";
            } else {
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $credentials = request(['email', 'password']);
                } else {
                    $credentials = [
                        'phone'    => $email,
                        'password' => $password
                    ];
                }

                $token = auth()->attempt($credentials);

                if (!$token) {
                    $status_code = 401;
                    $message     = "User tidak ditemukan";
                } else {
                    $success       = true;
                    $status_code   = 200;
                    $message       = "Login Success!";
                    $data["user"]  = auth()->user();
                    $data["token"] = array(
                        "access"  => $token,
                        "type"    => "bearer",
                        "expires" => (int) auth()->factory()->getTTL(),
                    );
                }
            }
        }

        $response = b_json_response($success, $status_code, $message, $data);
        return response()->json($response);
    }

    public function login_desktop(Request $request)
    {
		$email       = $request->email;
		$password    = $request->password;
        $success     = false;
        $status_code = 403;
        $message     = http_status_code($status_code);
        $data        = array();

        if (empty($email) or empty($password)) {
            $status_code = 400;
            $message     = "You must fill all the fields";
        } else {
            if (strlen($password) < 6) {
                $message = "Password should be min 6 character";
            } else {
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $credentials = request(['email', 'password']);
                } else {
                    $credentials = [
                        'phone'    => $email,
                        'password' => $password
                    ];
                }

                $token = auth()->attempt($credentials);

                if (!$token) {
                    $status_code = 401;
                    $message     = "User tidak ditemukan";
                } else {
                    $success       = true;
                    $status_code   = 200;
                    $message       = "Login Success!";
                    $data["user"]  = auth()->user();
                    $data["token"] = array(
                        "access"  => $token,
                        "type"    => "bearer",
                        "expires" => (int) auth()->factory()->getTTL(),
                    );
                }
            }
        }

        $response = b_json_response($success, $status_code, $message, $data);
        return response()->json($response);
    }

    protected function respondWithToken($token)
    {
        $success       = true;
        $status_code   = 200;
        $message       = "Login Success!";
        $data["user"]  = auth()->user();
        $data["token"] = array(
            "access"  => $token,
            "type"    => "bearer",
            "expires" => (int) auth()->factory()->getTTL(),
        );
        $response = b_json_response($success, $status_code, $message, $data);

        return response()->json($response, $status_code);
    }

    /**
     * @OA\Post(
     *     path="/me",
     *     tags={"Auth"},
     *     operationId="me",
     *     summary="Get auth user",
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
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * @OA\Post(
     *     path="/refresh",
     *     tags={"Auth"},
     *     operationId="refresh",
     *     summary="Refresh a token",
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
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * @OA\Post(
     *     path="/password",
     *     tags={"Auth"},
     *     operationId="password",
     *     summary="Change password",
     *     description="",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/form-data",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="old_password",
     *                     description="Old password user",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="new_password",
     *                     description="New password",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="new_confirm_password",
     *                     description="password confirm",
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
    public function password(Request $request)
    {
        /* ===== Your Validation is Here ===== */
        $this->validate($request, [
            'old_password'         => 'required',
            'new_password'         => 'required|min:8',
            'new_confirm_password' => 'required||same:new_password'
        ]);

        /* ===== Your transaction goes here ===== */
        try {
            DB::beginTransaction();
            $user   = Auth::user();

            if (Hash::check($request->new_password, $user->password)) {
                DB::rollback();
                return response()->json([
                    'success'      => false,
                    'status'       => 422,
                    'new_password' => 'New password must be different from old password',
                    'message'      => 'Password baru tidak boleh sama dengan password sebelumnya',
                ], 422);
            }

            $user->password = app('hash')->make($request->new_password);
            $user->save();


            if ($user) {
                DB::commit();
                return response()->json(b_json_response(true, 200, 'Password berhasil diupdate!', $user), 200);
            } else {
                DB::rollback();
                return response()->json(b_json_response(false, 400, 'Oops! Terjadi Kesalahan', $user), 400);
            }
        } catch (\Exception $th) {
            DB::rollback();
            return response()->json(b_json_response(false, 405, $th->getMessage(), null), 405);
        }
    }

    /**
     * @OA\Post(
     *     path="/forgot",
     *     tags={"Auth"},
     *     operationId="forgot",
     *     summary="Forgot password",
     *     description="",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/form-data",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="email",
     *                     description="Email user",
     *                     type="string",
     *                     format="email",
     *                 ),
     *             )
     *         )
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
     * )
     */
    public function forgot(Request $request)
    {
        /* ===== Your Validation is Here ===== */
        $this->validate($request, [
            'email' => 'required',
        ]);
        /* ===== Your transaction goes here ===== */
        try {
            DB::beginTransaction();
            $otp  = $this->generateNumericOTP(6);
            $user = User::where('email', $request->email)->first();

            if ($user) {
                $user->otp         = $otp;
                $user->otp_expired = Carbon::now()->addHours(2);
                $user->save();
                Mail::to($user)->send(new OtpMail($user->toArray()));

                DB::commit();
                return response()->json(b_json_response(true, 200, 'OTP berhasil dikirim!', $user), 200);
            } else {
                DB::rollback();
                return response()->json(b_json_response(false, 404, 'Maaf, email yang anda masukan tidak terdaftar pada sistem kami.', null), 404);
            }
        } catch (\Exception $th) {
            DB::rollback();
            return response()->json(b_json_response(false, 405, $th->getMessage(), null), 405);
        }
    }

    function generateNumericOTP($n) {
        $generator = "1357902468";
        $result    = "";
        for ($i = 1; $i <= $n; $i++) {
            $result .= substr($generator, (rand()%(strlen($generator))), 1);
        }
        return $result;
    }

    /**
     * @OA\Post(
     *     path="/otp",
     *     tags={"Auth"},
     *     operationId="otp",
     *     summary="Validation one time password",
     *     description="",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/form-data",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="otp",
     *                     description="OTP",
     *                     type="string",
     *                 ),
     *             )
     *         )
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
     * )
     */
    public function otp(Request $request)
    {
        /* ===== Your Validation is Here ===== */
        $this->validate($request, [
            'otp' => 'required',
        ]);
        /* ===== Your transaction goes here ===== */
        try {
            DB::beginTransaction();
            $user = User::where(['otp' => $request->otp])->first();

            if ($user) {
                $isExpired = Carbon::now()->gt($user->otp_expired);
                if ($isExpired) {
                    return response()->json(b_json_response(false, 408, 'OTP kadaluarsa', null), 408);
                }

                DB::commit();
                return response()->json(b_json_response(true, 200, 'OTP Accepted!', $user), 200);
            } else {
                DB::rollback();
                return response()->json(b_json_response(false, 404, 'Maaf, otp yang anda masukan tidak cocok.', null), 404);
            }
        } catch (\Exception $th) {
            DB::rollback();
            return response()->json(b_json_response(false, 405, $th->getMessage(), null), 405);
        }
    }

    /**
     * @OA\Post(
     *     path="/reset",
     *     tags={"Auth"},
     *     operationId="reset",
     *     summary="Reset password",
     *     description="",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/form-data",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="email",
     *                     description="Email",
     *                     type="string",
     *                     format="email",
     *                 ),
     *                 @OA\Property(
     *                     property="otp",
     *                     description="OTP",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="new_password",
     *                     description="New password",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="new_confirm_password",
     *                     description="Password Confirm",
     *                     type="string",
     *                 ),
     *             )
     *         )
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
     * )
     */
    public function reset(Request $request)
    {
        /* ===== Your Validation is Here ===== */
        $this->validate($request, [
            'email'                => 'required',
            'otp'                  => 'required',
            'new_password'         => 'required|min:8',
            'new_confirm_password' => 'required||same:new_password'
        ]);

        /* ===== Your transaction goes here ===== */
        try {
            DB::beginTransaction();
            $user = User::where(['otp' => $request->otp, 'email' => $request->email])->first();

            if ($user) {
                $isExpired = Carbon::now()->gt($user->otp_expired);
                if ($isExpired) {
                    return response()->json(b_json_response(false, 408, 'OTP kadaluarsa', null), 408);
                }

                $user->otp         = null;
                $user->otp_expired = null;
                $user->password    = app('hash')->make($request->new_password);
                $user->save();
                DB::commit();
                return response()->json(b_json_response(true, 200, 'Password berhasil diubah', $user), 200);
            } else {
                DB::rollback();
                return response()->json(b_json_response(false, 404, 'Maaf, otp yang anda masukan tidak cocok.', null), 404);
            }
        } catch (\Exception $th) {
            DB::rollback();
            return response()->json(b_json_response(false, 405, $th->getMessage(), null), 405);
        }
    }
}
