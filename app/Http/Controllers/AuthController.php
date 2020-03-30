<?php

namespace App\Http\Controllers;

use JWTAuth;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
     /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function register (Request $request) {
        $v = Validator::make($request->all(), [
            'username' => 'unique:users',
            'email' => 'unique:users',
        ]);

        if ($v->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors()
            ], 422);
        }

        $user = new User;
        $user->name = $request->name;
        $user->surname = $request->surname;
        $user->username = $request->username;
        $user->gender = $request->gender;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json(['status' => 'success'], 200);
    }

    public function login (Request $request) {
        try{
            $credentials = $request->only('email', 'password');
            if (!($token = JWTAuth::attempt($credentials))) {
                $credentials = $request->only('username', 'password');
                if (!($token = JWTAuth::attempt($credentials))){
                    return response()->json([
                        'error' => 'login_error'
                    ], 401);
                }
            } 
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        $user = Auth::user();
        return response([
            'data' => $user
        ])
        ->header('Authorization', 'Bearer '.$token);
    }

    public function logout () {
        JWTAuth::invalidate();

        return response()->json([
            'status' => 'success',
            'msg' => 'Logged out successfully'
        ], 200);
    }

    public function user (Request $request) {
        $user = User::find(Auth::user()->id);
        return response()->json([
            'status' => 'success',
            'data' => $user
        ]);
    }

    public function refresh (Request $request) {
        $token = $request->header('Authorization');
        if ($token = $this->guard()->refresh()) {
            return response()->json(['status' => 'success'], 200)->header('Authorization', $token);
        }

        return response()->json(['error' => 'refresh_token_error'], 401);
    }

    private function guard() {
        return Auth::guard();
    }
}
