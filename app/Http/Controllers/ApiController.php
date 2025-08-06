<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function status()
    {
        return response()->json(
            [
                'status' => 'OK',
                'message' => 'API is running OK!',
                'data' => [],
            ],
            200
        );        
    }

    public function clients()
    {
        $clients = Client::paginate(10);

        return response()->json(
            [
                'status' => 'OK',
                'message' => 'success',
                'data' => $clients
            ],
            200
        );
    }

    public function clientByID($id)
    {
        $client = Client::find($id);

        return response()->json(
            [
                'status' => 'OK',
                'message' => 'success',
                'data' => $client
            ],
            200
        );
    }

    public function client(Request $request)
    {
        if(!$request->id) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Client ID is required',
                ],
                400
            );
        }

        $client = Client::find($request->id);

        return response()->json(
            [
                'status' => 'OK',
                'message' => 'success',
                'data' => $client
            ],
            200
        );
    }
    
    public function addClient(Request $request)
    {
        $client = new Client();
        $client->name = $request->name;
        $client->email = $request->email;
        $client->save();

        return response()->json(
            [
                'status' => 'OK',
                'message' => 'success',
                'data' => $client
            ],
            201
        );
    }

    public function updateClient (Request $request)
    {
        if(!$request) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Client ID is required'
                ],
                400
            );
        }

        $client = Client::find($request->id);
        $client->name = $request->name;
        $client->email = $request->email;
        $client->save();

        return response()->json(
            [
                'status' => 'OK',
                'message' => 'success',
                'data' => $client
            ],
            200
        );
    }

    public function deleteClient($id)
    {
        $client = Client::find($id);
        $client->delete();

        return response()->json(
            [
                'status' => 'OK',
                'message' => 'success',
            ],
            200
        );
    }
}