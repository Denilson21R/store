<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function getAllProducts(Request $request) : JsonResponse {
        if(Auth::check()){
            $products = Product::all();
            return response()->json(['status' => 'success', 'data' => $products], 200);
        }else{
            return response()->json(['status' => 'fail'], 401);
        }
    }

    public function getProductById(Request $request, int $id) : JsonResponse {
        if(Auth::check()){
            $product = Product::where('id', $id)->first();
            if(!empty($product)){
                return response()->json(['status' => 'success', 'data' => $product->getAttributes()], 200);
            }else{
                return response()->json(['error' => 'product not found'], 404);
            }
        }else{
            return response()->json(['status' => 'fail'], 401);
        }
    }

    public function addProduct(Request $request) : JsonResponse {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'value' => 'required'
        ]);

        if(Auth::check()){
            $product = Product::create($request->all());
            if($product->save()){
                return response()->json($product->getAttributes(), 201);
            }else{
                return response()->json(['error' => 'an error occurred while save product'], 500);
            }
        }else{
            return response()->json(['status' => 'fail'], 401);
        }
    }

    public function updateProduct(Request $request, int $id) : JsonResponse {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'value' => 'required'
        ]);

        if(Auth::check()){
            $product = Product::where('id', $id)->first();
            if(!empty($product)){
                $product->name = $request->name;
                $product->description = $request->description;
                $product->value = $request->value;
                if($product->save()){
                    return response()->json(['status' => 'success', 'data' => $product->getAttributes()], 200);
                }else{
                    return response()->json(['error' => 'an error occurred while update product'], 500);
                }
            }else{
                return response()->json(['error' => 'product not found'], 404);
            }
        }else{
            return response()->json(['status' => 'fail'], 401);
        }
    }

    public function deleteProduct(Request $request, int $id) : JsonResponse {
        if(Auth::check()) {
            $product = Product::where('id', $id)->first();

            if (!empty($product)) {
                if($this->productUsedInSales($id)){
                    return response()->json(['error' => 'product cant be deleted'], 200);
                }else{
                    $product->delete();
                    return response()->json([], 204);
                }
            } else {
                return response()->json(['error' => 'product not found'], 404);
            }
        }else{
            return response()->json(['status' => 'fail'], 401);
        }
    }

    public function getProductQty(Request $request){
        if(Auth::check()) {
            $qtdd = Product::all()->count();
            return response()->json(['quantity' => $qtdd], 200);
        }else{
            return response()->json(['status' => 'fail'], 401);
        }
    }

    public function productUsedInSales(int $id)
    {
        $products = DB::table("sale_product")
            ->where('id_product', $id)
            ->get();

        if($products->count() > 0){
            return true;
        }else{
            return false;
        }
    }
}


