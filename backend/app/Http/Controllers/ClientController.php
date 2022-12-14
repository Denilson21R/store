<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function getAllClients(Request $request){
        if(Auth::check()){
            $clients = Client::all();
            return response()->json(['status' => 'success', 'data' => $clients], 200);
        }else{
            return response()->json(['status' => 'fail'], 401);
        }
    }

    //TODO: get client by id

    //TODO: update client

    //TODO: delete client
}
