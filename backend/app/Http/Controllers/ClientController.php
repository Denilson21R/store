<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Sale;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function getAllClients(Request $request) : JsonResponse {
        if(Auth::check()){
            $clients = Client::orderBy('name')->get();
            return response()->json(['status' => 'success', 'data' => $clients], 200);
        }else{
            return response()->json(['status' => 'fail'], 401);
        }
    }

    public function addClient(Request $request) : JsonResponse {
        $this->validate($request, [
            'name' => 'required'
        ]);

        if(Auth::check()){
            $client = Client::create($request->all());
            if($client->save()){
                return response()->json($client->getAttributes(), 201);
            }else{
                return response()->json(['error' => 'an error occurred while save client'], 500);
            }
        }else{
            return response()->json(['status' => 'fail'], 401);
        }
    }

    public function getClientById(Request $request, int $id) : JsonResponse {
        if(Auth::check()){
            $client = Client::where('id', $id)->first();
            if(!empty($client)){
                return response()->json(['status' => 'success', 'data' => $client->getAttributes()], 200);
            }else{
                return response()->json(['error' => 'client not found'], 404);
            }
        }else{
            return response()->json(['status' => 'fail'], 401);
        }
    }

    public function updateClient(Request $request, int $id) : JsonResponse {
        $this->validate($request, [
            'name' => 'required'
        ]);

        if(Auth::check()){
            $client = Client::where('id', $id)->first();
            if(!empty($client)){
                $this->bindClientDataByRequestData($request, $client);
                if($client->save()){
                    return response()->json(['status' => 'success', 'data' => $client->getAttributes()], 200);
                }else{
                    return response()->json(['error' => 'an error occurred while update client'], 500);
                }
            }else{
                return response()->json(['error' => 'client not found'], 404);
            }
        }else{
            return response()->json(['status' => 'fail'], 401);
        }
    }

    public function deleteClient(Request $request, int $id) : JsonResponse {
        if(Auth::check()) {
            $client = Client::where('id', $id)->first();

            if (!empty($client)) {
                if($this->clientUsedInSales($id)){
                    return response()->json(['error' => 'product cant be deleted'], 200);
                }else{
                    $client->delete();
                    return response()->json([], 204);
                }
            } else {
                return response()->json(['error' => 'client not found'], 404);
            }
        }else{
            return response()->json(['status' => 'fail'], 401);
        }
    }

    public function getClientQty(Request $request){
        if(Auth::check()) {
            $qtdd = Client::all()->count();
            return response()->json(['quantity' => $qtdd], 200);
        }else{
            return response()->json(['status' => 'fail'], 401);
        }
    }

    public function clientUsedInSales(int $id)
    {
        $sales = Sale::where('id_client', $id)->get();

        if($sales->count() > 0){
            return true;
        }else{
            return false;
        }
    }

    public function bindClientDataByRequestData(Request $request, $client): void
    {
        $client->name = $request->name;
        $client->address = $request->address;
        $client->phone = $request->phone;
    }
}
