<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function auth(Request $request){
        $this->validate($request, [
            'login' => 'required',
            'password' => 'required'
        ]);

        $credentials = $request->only('login', 'password');

        $user = DB::table('user')
            ->where('login', $credentials['login'])
            ->first();

        if(Hash::check($request->input('password'), $user->password)){
            $apikey = base64_encode(Str::random(40));

            DB::table('user')
                ->where('login', $credentials['login'])
                ->update(['api_key' => $apikey]);

            return response()->json(['status' => 'success','api_key' => $apikey]);
        }else{
            return response()->json(['status' => 'fail'],401);
        }
    }

    public function signUp(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'login' => 'required',
            'password' => 'required'
        ]);

        $user_data = $request->all();
        $user_data["password"] = Hash::make($user_data["password"]);

        $user = User::create($user_data);

        if($user->save()){
            return response()->json($user->getAttributes(), 200);
        }else{
            return response()->json(['error' => 'an error occurred while save user'], 500);
        }
    }

    //TODO: update user data

    //TODO: delete user
}
