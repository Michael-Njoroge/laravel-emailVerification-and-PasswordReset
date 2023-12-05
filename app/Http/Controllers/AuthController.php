<?php

namespace App\Http\Controllers;

use App\Models\PasswordReset;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Nette\Utils\Random;

use function Laravel\Prompts\password;

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
      if(auth()->user()){
            return response()->json([
                'status' => 'true',
                'data' => auth()->user(),
             ]);
        } else{
            return response()->json([
                'status' => 'false',
                'message' => 'Unauthorized',
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
                    'status' => true,
                    'message' => 'Please check your email for verification'
                    ]);
            }
            else{
                return response()->json([
                'status' => 'false',
                'message' => 'User with this email is not Found'
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

    // Verify Email
    public function verifyEmail($token)
    {
        $user = User::where('remember_token', $token)->get();

        if(count($user)>0){
            $dateTime = Carbon::now()->format('Y-M-d H:i:s');
            $user = User::find($user[0]['id']);
            $user->remember_token = '';
            $user->is_verified = 1;
            $user->email_verified_at = $dateTime;
            $user -> save();

            return view('mail.verified');

        }
        else{
            return view('404');
        }
    }

    // Refresh Token
    public function refreshToken()
    {
        if(auth()->user())
        {
            return $this -> respondWithToken(auth()->refresh());
        }
        else{
            return response()->json([
                'status' => 'false',
                'message' => 'Unauthorized'
            ]);
        }
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

    //reset forgot password
    public function forgetPassword(Request $request)
    {
        if(auth()->user()){
            $validator = Validator::make($request->only('email'),[
                'email' => 'required|string|email',
             ]);
    
            if($validator->fails()){
                return response()->json($validator->errors());
            }
            $email = $request->email;

            $user = User::where('email',$email)->get();

            if(count($user)>0){
                $token = Str::random(40);
                $domain = URL::to('/');
                $url = $domain.'/reset-password?token='.$token;

                $data['url'] = $url;
                $data['email'] = $email;
                $data['title'] = 'Password Reset';
                $data['body'] = 'Please click the link below to reset your password';

                Mail::send('mail.forgotPasswordMail',['data'=>$data],function($message) use ($data){
                    $message->to($data['email'])->subject($data['title']);
                });

                $dateTime = Carbon::now()->format('Y-m-d H:i:s');

                PasswordReset::updateOrCreate(
                [
                    'email' => $email
                ],
                [
                    'email' => $email,
                    'token' => $token,
                    'created_at' => $dateTime
                ]);

                return response()->json([
                    'status' => 'true',
                    'message' => 'Please check your mail for the reset password email'
                ]);

            }
            else{
                return response()->json([
                    'status' => 'false',
                    'message' => 'user with this email is not found'
                ]);
            }
        }
        else{
            return response()->json([
                'status' => 'false',
                'message' => 'Unauthorized'
            ]);
        }
    }

    //reset password view load

    public function resetPasswordLoad(Request $request)
    {
        $resetData = PasswordReset::where('token',$request->token)->get();

        if(isset($request->token) && count($resetData)>0){
            $user = User::where('email',$resetData[0]['email']) ->get();
            return view('password.resetPassword',compact('user'));

        }
        else{
            return view('404');
        }
    }

    //password reset functionality
    
    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::find($request->id);
        $user->password = Hash::make($request->password);
        $user->save();

        PasswordReset::where('email',$user->email)->delete();

        return view('password.password_is_reset');
    }

}
