<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    public function sign_up(Request $request)
    {
        $validator = Validator::make($request->all(),[
            "first_name" => 'required|string|regex:/^[a-zA-Z\s]*$/',
            "last_name" => 'required|string|regex:/^[a-zA-Z\s]*$/',
            "email" => 'required|unique:users|email',
            "password" => 'required|min:8|',
            "contact_num" => 'string|nullable',
            "address" => 'string|nullable',
            "profile_image" => 'file|max:10000|nullable',
        ]);
        if($validator->fails())
        {
            return response()->json([
                'Message' => 'Sign-up failed.',
                'Error' => $validator->errors(),
            ]);
        }
        if(User::count()== 0)
        {
            $user_id = User::create([
                'is_admin' => true,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ])->id;
        }
        else
        {
            $user_id = User::create([
                'is_admin' => false,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ])->id;
        }
        if(is_null($request->profile_image))
        {
            $upload_path = NULL;    
        }
        else
        {
            $upload_path = $request->profile_image->store('public/uploads');
        }
        $new_account = Account::create([
            'user_id' => $user_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'contact_num' => $request->contact_num,
            'address' => $request->address,
            'profile_image' => $upload_path,
        ]);
 
        event(new Registered(User::Where('id','=',$user_id)->first()));
        return response()->json([
            'Message' => 'Sign=-up successful.',
            'Email' => $request->email,
            'User' => $new_account,
        ]);
    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);
        if($validator->fails())
        {
            return response()->json([
                'Message' => 'Login Failed',
                'Errors' => $validator->errors(),
            ],401);
        }
        $user = User::Where('email','=',$request->email)->first();
        if(is_NULL($user))
        {
            return response()->json([
                'Message' => 'Login failed',
                'Error' => 'Email not registered.',    
            ],401);     
        }
        $isadmin = User::Where('id','=',$user->id)->pluck('is_admin')->first();
        if($isadmin)
        {
            if($user)
            {
                if(Hash::check($request->password,$user->password))
                {
                    $token = $user->createToken('Bearer Token',['admin'])->accessToken;
                    return response()->json([
                        'Message' => 'Login success',
                        'Access Token' => $token,
                        'withScope' => $isadmin
                    ]);
                }
                else
                {
                    return response()->json([
                        "Message" => 'Login failed',
                        "Error" => 'Invalid credentials'
                    ],401);
                }
            }
            else
            {
                return response()->json([
                    'Message' => 'Login failed',
                    "Error" => 'Email not found'
                ]);
            }
        }
        else
        {
            if($user)
            {
                if(Hash::check($request->password,$user->password))
                {
                    $token = $user->createToken('Bearer Token')->accessToken;
                    return response()->json([
                        'Message' => 'Login success',
                        'Access Token' => $token,
                        'withScope' => $isadmin
                    ]);
                }
                else
                {
                    return response()->json([
                        "Message" => 'Login failed',
                        "Error" => 'Invalid credentials'
                    ],401);
                }
            }
            else
            {
                return response()->json([
                    'Message' => 'Login failed',
                    "Error" => 'Email not found'
                ]);
            }    
        }
    }
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'Data' => 'Access token revoked',
            'Message' => 'You have been successfully logged out.'
        ]);
    }

    public function verify_email($id, $hash)
    {
        //use this for email verification for api, code on laravel documenation does not work when using api
        $account = User::find($id);
        abort_if(!$account, 403);
        abort_if(!hash_equals(sha1($account->getEmailForVerification()), $hash), 403);
        if (!$account->hasVerifiedEmail()) {
            $account->markEmailAsVerified();
            event(new Verified($account));
        }
        return response()->json(['message' => 'Email Verified', 'verified' => true]);
        //return view('verified-account');
    }   
}
