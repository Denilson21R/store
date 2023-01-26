<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Sale;
use App\Models\User;
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
            $this->fillDataOfSales($sales);
            return response()->json(['status' => 'success', 'data' => $sales], 200);
        }else{
            return response()->json(['status' => 'fail'], 401);
        }
    }

    public function getSaleById(Request $request, int $id) : JsonResponse {
        if(Auth::check()){
            $sale = Sale::where('id', $id)->first();
            $this->getClientAndPhoneDataOfSale($sale);
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
            'id_user' => 'required',
            'products' => 'required|array',
            'total_value' => 'required'
        ]);

        if(Auth::check()){
            $client = Client::where('id', $request->id_client)->first();
            if(!empty($client)){
                $sale = Sale::create($request->all());

                foreach ($request->products as $product){
                    $this->insertProductSalesTable($product["id"], $sale);
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
                $this->deleteProductsOfSaleBySaleId($id);
                $sale->delete();
                return response()->json([], 204);
            }else{
                return response()->json(['error' => 'sale not found'], 404);
            }
        }else{
            return response()->json(['status' => 'fail'], 401);
        }
    }

    public function deleteProductsOfSaleBySaleId(int $id): void
    {
        DB::table("sale_product")
            ->where('id_sale', $id)
            ->delete();
    }

    public function getSaleStats(Request $request): JsonResponse{
        if(Auth::check()) {
            $total_amount = $this->getTotalAmountOfSalesArray();
            $qtdd = Sale::all()->count();
            return response()->json([
                'total_amount' => $total_amount,
                'quantity' => $qtdd
            ], 200);
        }else{
            return response()->json(['status' => 'fail'], 401);
        }
    }

    public function getTotalAmountOfSalesArray(): float
    {
        $sales = Sale::all();
        $total_amount = 0;
        foreach ($sales as $sale) {
            $total_amount += $sale->total_value;
        }
        return $total_amount;
    }

    public function fillDataOfSales($sales): void
    {
        foreach ($sales as $sale) {
            $this->getClientAndPhoneDataOfSale($sale);
            $sale->user = User::where('id', $sale->id_user)->get(["id", "name"]);
            unset($sale->id_client);
            unset($sale->id_user);
        }
    }

    public function getClientAndPhoneDataOfSale($sale): void
    {
        $sale->products = $sale->products()->get();
        $sale->client = Client::where('id', $sale->id_client)->get(["id", "name", "address", "phone"]);
    }

    public function insertProductSalesTable($id, $sale): void
    {
        DB::table('sale_product')->insert([
            [
                'id_product' => $id,
                'id_sale' => $sale->id
            ]
        ]);
    }
}
