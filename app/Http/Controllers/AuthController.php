<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Exception;
/*use Tymon\JWTAuth\Exceptions\JWTException;*/

class AuthController extends Controller
{
    /**
     * Creates a user with the returned fields, taking care of hashing the password before
     * 
     */
    public function register(Request $request)
    {
        $v = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'password'  => 'required|min:3|confirmed',
        ]);
        if ($v->fails())
        {
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors()
            ], 422);
        }
        $user = new User;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        return response()->json(['status' => 'success'], 200);
    }

    /**
     * Checks the provided credentials and returns generated token
     * in the headers of the response if success
     * 
     */
    public function login(Request $request)
    {
/*                $user = User::find(1);
        return response()->json([
            'status' => 'success',
            'data' => $user
        ]);*/
        $credentials = $request->only('username', 'password');
/*        dump($credentials);die();*/
        if ($token = $this->guard()->attempt($credentials)) {
            return response()->json(['status' => 'success'], 200)->header('Authorization', $token);
        }
        return response()->json(['error' => 'login_error'], 401);
    }

    /**
     * Disconnects users by disabling the token
     * 
     */
    public function logout()
    {
        $this->guard()->logout();
        return response()->json([
            'status' => 'success',
            'msg' => 'Logged out Successfully.'
        ], 200);
    }

    /**
     * Retrieves the logged user’s information and send it back to the response dataset
     */
    public function user(Request $request)
    {
        $user = User::find(Auth::user()->id);
        return response()->json([
            'status' => 'success',
            'data' => $user
        ]);
    }

    /**
     * Refreshes the token if it has expired. 
     * It is possible to define the duration of validity
     * of the token in the file ‘config / jwt.php’.
     */
    public function refresh()
    {
        $token = $this->guard()->refresh();
        try {
            if ($token = $this->guard()->refresh()) {
                return response()
                    ->json(['status' => 'successs'], 200)
                    ->header('Authorization', $token);
            }
            return response()->json(['error' => 'refresh_token_error'], 401);
        } catch (Exception /*JWTException*/ $e) {
            return response()->json(['error' => 'refresh_token_error'], 401);
        }
/*        if ($token = $this->guard()->refresh()) {
            return response()
                ->json(['status' => 'successs'], 200)
                ->header('Authorization', $token);
        }
        return response()->json(['error' => 'refresh_token_error'], 401);*/
    }

    /**
     * @inheritDoc
     */
    private function guard()
    {
        return Auth::guard();
    }
}
