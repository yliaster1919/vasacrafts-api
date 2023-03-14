<?php

namespace App\Http\Controllers;

use App\Mail\MailNotify;
use App\Models\Account;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(),[
            'first_name' => 'string|max:255|regex:/^[a-zA-Z\s]*$/|nullable',
            'last_name' => 'string|max:255|regex:/^[a-zA-Z\s]*$/|nullable',
            'contact_num' => 'string|nullable',
            'address' => 'string|nullable',
            'profile_image' => 'image|max:10000|nullable',
        ]);
        if($validator->fails())
        {
            return response()->json([
                'Message' => 'Update failed.',
                'Error' => $validator->errors()
            ]);
        }
        if(is_Null($request->all()))
        {
            return response()->json([
                'Message' => 'Update failed.',
                'Error' => 'Must update at least one field.'        
            ]);
        }
        else
        {   $account = Account::Where('id','=',$id)->first();
            if($request->first_name == NULL)
            {
                $request->first_name = $account->first_name;
            }
            else
            {
                $account->first_name = $request->first_name;
            }
            if($request->last_name == NULL)
            {
                $request->last_name = $account->last_name;   
            }
            else
            {
                $account->last_name = $request->last_name;
            }
            if($request->contact_num == NULL)
            {
                $request->contact_num = $account->contact_num;   
            }
            else
            {
                $account->contact_num = $request->contact_num;
            }
            if($request->address == NULL)
            {
                $request->address = $account->address;    
            }
            else
            {
                $account->address = $request->address;
            }
            if($request->profile_image == NULL)
            {
                $request->profile_image = $account->profile_image;    
            }
            else
            {
                $account->profile_image = $request->profile_image->store('public/uploads');
            }
            $account->saveQuietly();
            $user = User::Where('id','=',$account->user_id)->first();
            // Mail::to($user->email)
            //     ->send(new MailNotify());
            return response()->json([
                'Message' => 'Account updated successfully',
                'Data' => $account,
            ]);            
        }
        

    }
}
