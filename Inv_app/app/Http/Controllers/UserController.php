<?php

namespace App\Http\Controllers;
use App\Helper\JWTToken;
use App\Mail\OTPMail;
use App\Models\user;
use ErrorException;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Psy\CodeCleaner\ReturnTypePass;

class UserController extends Controller
{
                //Pages
    function RegistrationPage(Request $request){
        return view('pages.auth.registration-page');
    }

    function LoginPage(Request $request){
        return view('pages.auth.login-page');
    }

    function SendOtpPage(Request $request){
        return view('pages.auth.send-otp-page');
    }

    function VerifyOTPPage(Request $request){
        return view('pages.auth.verify-otp-page');
    }

    function ResetPasswordPage(Request $request){
        return view('pages.auth.reset-password-page');
    }

    function ProfilePage(Request $request){
        return view('pages.dashboard.profile-page');
    }

                //Backend & API Method
    function UserRegistration(Request $request){
        try{
            user::create([
                'firstName'=>$request->input('firstName'),
                'lastName'=>$request->input('lastName'),
                'email'=>$request->input('email'),
                'mobile'=>$request->input('mobile'),
                'password'=>$request->input('password')
            ]);
            return response()->json([
                'status'=>'success',
                'message'=>'user registration successful',
            ],status:200);
        }catch(Exception $e){
            return response()->json([
                'status'=>'fail',
                'message'=>'user registration fail'
            ],status:401);
        }

    }

    function userLogin(Request $request){
        $count= user::where('email',$request->input('email'))
                    ->where('password',$request->input('password'))
                    ->select('id')->first();
        if($count!==null){
            $token= JWTToken::CreateToken($request->input('email'),$count->id);
            return response()->json([
                'status'=>'success',
                'message'=>'user login successful'
                // 'token'=>$token
            ],status:200)->cookie('token',$token,60*24*30);
        }
                //me:Extra cn added
        else if( user::where('password','!=',$count)){
            return response()->json([
                'message'=>'Invalid password',
            ]);
        }
                //extra cn end
        else{
            return response()->json([
                'status'=>'failed',
                'message'=>'unauthorized'
            ],401);
        }
    }

    function SendOTPCode(Request $request){
        $email= $request->input('email');
        $otp=rand(1900,5433);
        $count= user::where('email','=',$email)->count();

        if($count==1){
           Mail::to($email)->send(new OTPMail($otp));
           user::where('email','=',$email)->update(['otp'=>$otp]);
           return response()->json([
            'status'=>'success',
            'message'=>'4 Digit otp code has been send to your email'
           ],status:200);
        }
        else{
            return response()->json([
                'status'=>'failed',
                'message'=>'unauthorized'
            ],status:401);
        }

    }

    
    function VerifyOTP(Request $request){
        $email= $request->input('email');
        $otp= $request->input('otp');
        $count= user::where('email','=',$email)
            ->where('otp','=',$otp)
            ->count();

        if($count==1){
            user::where('email','=',$email)->update(['otp'=>'0']);
            $token= JWTToken::CreateTokenForSetPaassword($request->input('email'));
            return response()->json([
                'status'=>'success',
                'message'=>'Otp Verification successful',
                // 'token'=>$token
            ],status:200)->cookie('token',$token,60*24*30);

        }
        else{
            return response()->json([
                'status'=>'failed',
                'message'=>'unauthorized'
            ],status:401);
        }
    }

    function ResetPassword(Request $request){
       try{
            $email= $request->header('email');
            $password= $request->input('password');
            user::where('email','=',$email)->update(['password'=>$password]);
            return response()->json([
                'status'=>'success',
                'message'=>'Request successful'
            ],status:200);
        }
        catch(Exception $e){
            return response()->json([
                'status'=>'fail',
                'message'=>'something went wrong'
            ],status:401);
        }
    }

             //logout
    function UserLogout(Request $request){
        return redirect('/userLogin')->cookie('token','',-1);
    }
            //profile
    function UserProfile(Request $request){
        $email= $request->header('email');
        $user= user::where('email','=',$email)->first();
        return response()->json([
            'status'=>'success',
            'message'=>'Request successful',
            'data'=>$user
        ],status:200);
    }

    function UserUpdate(Request $request){
        $email= $request->header('email');
        user::where('email','=',$email)->update([
            'firstName'=>$request->input('firstName'),
            'lastName'=>$request->input('lastName'),
            'mobile'=>$request->input('mobile'),
            'password'=>$request->input('password')
        ]);
        return response()->json([
            'status'=>'success',
            'message'=>'request successful'
        ],status:200);
    }
}
