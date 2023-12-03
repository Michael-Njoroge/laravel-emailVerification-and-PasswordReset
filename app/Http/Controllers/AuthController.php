<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Register User
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|min:2|max:200',
            'email' => 'required|string|email|max:200|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'User Created Successfully',
            'user' => $user
        ]);
    }

    /**
     * Login user
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        if(!$token = auth()->attempt($validator->validated())){
            return response()->json([
                'status' => 'false',
                'message'=>'Wrong credentials'
            ]);
        }
        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'status' => 'success',
            'token' => $token,
            'authorization' => 'bearer',
            'expires_in' => auth()->factory()->getTTL()*60,
        ]);
    }

    /**
     * logout user.
     */
    public function logout()
    {
        try
        {
        auth()->logout();
         return response()->json([
            'status' => 'true',
            'message' => 'User Logged out Successfully'
         ]);
        }
        catch(\Exception $e){
            return response()->json([
                'status' => 'false',
                'message' => $e->getMessage(),
             ]);
        }
    }

    /**
     * user profile
     */
    public function profile()
    {
        try {
            return response()->json([
                'status' => 'true',
                'data' => auth()->user(),
             ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'false',
                'message' => $e->getMessage(),
             ]);
        }
    }

    /**
     * update user profile
     */
    public function profileUpdate(Request $request)
    {
        if(auth()->user()){
        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
            'email' => 'required|string|email'
        ]);

        if($validator -> fails()){
            return response()->json($validator->errors());
        }

        $user = auth()->user();
        $user -> name = $request->name;
        $user ->email = $request->email;

        $user -> save();
        
        return response()->json([
            'status'=> 'true',
            'data' => $user,
            'message' => 'User Data Updated Successfully'
        ]);
    }
    else{
        return response()->json([
            'status' => 'false',
            'message' => 'Unauthorized'
        ]);
    }
    }
}
