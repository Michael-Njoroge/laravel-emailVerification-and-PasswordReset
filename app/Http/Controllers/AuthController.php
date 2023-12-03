<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
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

        $user->save();
        
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

    /**
     * send verification mail
     */

    public function sendVerifyEmail($email)
    {
        if(auth()->user()){
            $user = User::where('email', $email)->get();

            if(count($user) > 0){
                $random = Str::random(40);
                $domain = URL::to('/');
                $url = $domain.'/verify-email/'.$random;

                $data['url'] = $url;
                $data['email'] = $email; 
                $data['title'] = "Email Verification"; 
                $data['body'] = "Please click the link below to verify your email"; 

                Mail::send('mail.verifyMail', ['data' => $data],function($message) use ($data){
                    $message->to($data['email']) -> subject($data['title']);
                });

                $user = User::find($user[0]['id']);
                $user->remember_token = $random;
                $user->save();

                return response()->json([
                    'status' => 'true',
                    'message' => 'Please check your email for verification'
                    ]);
            }
            else{
                return response()->json([
                'status' => 'false',
                'message' => 'User with the email is not Found'
                ]);
            }
        }
        else
        {
            return response()->json([
                'status' => 'false',
                'message' => 'Unauthorized'
            ]);
        }
    }
}
