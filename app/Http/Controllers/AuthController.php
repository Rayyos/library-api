<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT token via given credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function login(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|email',
                'password' => 'required|string|min:6',
            ]
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $token_validity = (24 * 60);

        $this->guard()->factory()->setTTL($token_validity);

        if (!$token = $this->guard()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);

    }

    public function register(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'firstname' => 'required|string',
                'lastname' => 'required|string',
                'mobile' => 'required|unique:users|integer|digits:10',
                'email' => 'required|email|unique:users',
                'password' => 'required|confirmed|min:6',
                'age' => 'required|integer',
                'gender' => 'required',
                'city' => 'required',

            ]
        );

        if ($validator->fails()) {
            return response()->json(
                [$validator->errors()],
                422
            );
        }

        $user = User::create(
            array_merge(
                $validator->validated(),
                ['password' => bcrypt($request->password)]
            )
        );

        return response()->json(['message' => 'User created successfully', 'user' => $user]);

    } //end register()

    public function logout()
    {
        $this->guard()->logout();

        return response()->json(['message' => 'User logged out successfully']);

    } //end logout()

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());

    } //end refresh()

    protected function respondWithToken($token)
    {
        return response()->json(
            [
                'token' => $token,
                'token_type' => 'bearer',
                'expires_in' => ($this->guard()->factory()->getTTL() * 60),
            ]
        );

    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard();
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile()
    {
        return response()->json(auth()->user());
    }

    public function profileUpdate(Request $request)
    {

        $user =User::find(1);
       // return response()->json($user);
        $validator = Validator::make(
            $request->all(),
            [
                'firstname' => 'required|string',
                'lastname' => 'required|string',
                'mobile' => 'required|integer|digits:10|',
                'email' => 'required|email|',
                'password' => 'required|confirmed|min:6',
                'age' => 'required|integer',
                'gender' => 'required',
                'city' => 'required',

            ]
        );

        if ($validator->fails()) {
            return response()->json(
                [$validator->errors()],
                422
            );
        }

        $user = $user->update(
            array_merge(
                $validator->validated(),
                ['password' => bcrypt($request->password)]
            )
        );

        return response()->json(['message' => 'User Updated successfully', 'user' => $user]);
    }

}
