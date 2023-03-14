<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    public function add(Request $request)
    {
        $validator = Validator::make($request->all(),[
            "first_name" => 'required|string|regex:/^[a-zA-Z\s]*$/',
            "last_name" => 'required|string|regex:/^[a-zA-Z\s]*$/',
            "contact_num" => 'required|string',
            'address' => 'required|string',
        ]);
        if($validator->fails())
        {
            return response()->json([
                'Message' => 'Add client failed',
                'Errors' => $validator->errors(),
            ]);
        }
        $client = Client::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'contact_num' => $request->contact_num,
            'address' => $request->address
        ]);
        return response()->json([
            'Message' => 'Client added successfully.',
            'Data' => $client
        ]);
    }
    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(),[
            "first_name" => 'required|string|regex:/^[a-zA-Z\s]*$/',
            "last_name" => 'required|string|regex:/^[a-zA-Z\s]*$/',
            "contact_num" => 'required|string',
            'address' => 'required|string',
        ]);
        if($validator->fails())
        {
            return response()->json([
                'Message' => 'Add client failed',
                'Errors' => $validator->errors(),
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
        {   $client = Client::find($id);
            if($request->first_name == NULL)
            {
                $request->first_name = $client->first_name;
            }
            else
            {
                $client->first_name = $request->first_name;
            }
            if($request->last_name == NULL)
            {
                $request->last_name = $client->last_name;   
            }
            else
            {
                $client->last_name = $request->last_name;
            }
            if($request->contact_num == NULL)
            {
                $request->contact_num = $client->contact_num;   
            }
            else
            {
                $client->contact_num = $request->contact_num;
            }
            if($request->address == NULL)
            {
                $request->address = $client->address;    
            }
            else
            {
                $client->address = $request->address;
            }
            $client->saveQuietly();

            return response()->json([
                'Message' => 'client updated successfully',
                'Data' => $client,
            ]);            
        }
    }
    public function delete(Request $request)
    {
        $client = Client::find($request->input('query'));
        $deleted_client = $client;
        $client->delete();
        return response()->json([
            'Message' => 'Client deleted successfully.',
            'Deleted' => $deleted_client
        ]);
    }
    public function fetch(Request $request)
    {
        return Client::Where('id','=',$request->input('query'))->first();
    }
    public function all()
    {
        return Client::OrderBy('last_name')->get();
    }
}
