<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

//TODO: implement JWT in update and delete endpoints
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

            return response()->json(['status' => 'success','api_key' => $apikey], 200);
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
            return response()->json($user->getAttributes(), 201);
        }else{
            return response()->json(['error' => 'an error occurred while save user'], 500);
        }
    }


    public function updateUser(Request $request, int $id){
        $this->validate($request, [
            'name' => 'required',
            'login' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('id', $id)->first();

        if(!empty($user)){
            $user->name = $request->name;
            $user->login = $request->login;
            $user->password = Hash::make($request->password);

            if($user->save()){
                return response()->json(['status' => 'success', 'data' => $user->getAttributes()], 200);
            }else{
                return response()->json(['error' => 'an error occurred while update user'], 500);
            }
        }else{
            return response()->json(['error' => 'user not found'], 404);
        }

    }

    public function deleteUser(Request $request, int $id){
        $user = User::where('id', $id)->first();

        if(!empty($user)){
            $user->delete();
            return response()->json([], 204);
        }else{
            return response()->json(['error' => 'user not found'], 404);
        }
    }
}
