<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function getAllSales(Request $request) : JsonResponse {
        if(Auth::check()){
            $sales = Sale::all();
            return response()->json(['status' => 'success', 'data' => $sales], 200);
        }else{
            return response()->json(['status' => 'fail'], 401);
        }
    }

    public function getSaleById(Request $request, int $id) : JsonResponse {
        if(Auth::check()){
            $sale = Sale::where('id', $id)->first();
            if(!empty($sale)){
                return response()->json(['status' => 'success', 'data' => $sale->getAttributes()], 200);
            }else{
                return response()->json(['error' => 'sale not found'], 404);
            }
        }else{
            return response()->json(['status' => 'fail'], 401);
        }
    }

    public function addSale(Request $request) : JsonResponse {
        $this->validate($request, [
            'id_client' => 'required',
            'products' => 'required|array',
            'total_value' => 'required'
        ]);

        if(Auth::check()){
            $client = Client::where('id', $request->id_client)->first();
            if(!empty($client)){
                $sale = Sale::create($request->all());

                foreach ($request->products as $product){
                    DB::table('sale_product')->insert([
                        [
                            'id_product' => $product["id"],
                            'id_sale' => $sale->id
                        ]
                    ]);
                }

                if($sale->save()){
                    return response()->json($sale->getAttributes(), 201);
                }else{
                    return response()->json(['error' => 'an error occurred while save sale'], 500);
                }
            }else{
                return response()->json(['error' => 'sale not found'], 422);
            }
        }else{
            return response()->json(['status' => 'fail'], 401);
        }
    }

    public function deleteSale(Request $request, int $id) : JsonResponse {
        if(Auth::check()){
            $sale = Sale::where('id', $id)->first();
            if(!empty($sale)){
                $sale->delete();
                return response()->json([], 204);
            }else{
                return response()->json(['error' => 'sale not found'], 404);
            }
        }else{
            return response()->json(['status' => 'fail'], 401);
        }
    }
}
