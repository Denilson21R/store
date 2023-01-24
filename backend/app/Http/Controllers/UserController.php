<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function auth(Request $request) : JsonResponse {
        $this->validate($request, [
            'login' => 'required',
            'password' => 'required'
        ]);

        $credentials = $request->only('login', 'password');

        $user = $this->getFirstUserByLogin($credentials['login']);

        if($this->checkPasswordOfUser($request, $user)){
            $apikey = base64_encode(Str::random(40));

            $this->updateUserApiKeyByLogin($credentials['login'], $apikey);

            return response()->json([
                'status' => 'success',
                'api_key' => $apikey,
                'id' => $user->id,
                'name' => $user->name
            ],
                200);
        }else{
            return response()->json(['status' => 'fail'],401);
        }
    }

    public function signUp(Request $request) : JsonResponse {
        $this->validate($request, [
            'name' => 'required',
            'login' => 'required',
            'password' => 'required'
        ]);

        $user_data = $request->all();
        $user_data["password"] = $this->hashUserPassword($user_data["password"]);

        $user = User::create($user_data);

        if($user->save()){
            return response()->json($user->getAttributes(), 201);
        }else{
            return response()->json(['error' => 'an error occurred while save user'], 500);
        }
    }


    public function updateUser(Request $request, int $id) : JsonResponse {
        $this->validate($request, [
            'name' => 'required',
            'login' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('id', $id)->first();

        if(!empty($user)){
            $this->bindUserDataByRequestData($request, $user);

            if($user->save()){
                return response()->json(['status' => 'success', 'data' => $user->getAttributes()], 200);
            }else{
                return response()->json(['error' => 'an error occurred while update user'], 500);
            }
        }else{
            return response()->json(['error' => 'user not found'], 404);
        }
    }

    public function deleteUser(Request $request, int $id) : JsonResponse {
        $user = User::where('id', $id)->first();

        if(!empty($user)){
            $user->delete();
            return response()->json([], 204);
        }else{
            return response()->json(['error' => 'user not found'], 404);
        }
    }

    public function getFirstUserByLogin($login): object|null {
        return DB::table('user')
            ->where('login', $login)
            ->first();
    }

    public function checkPasswordOfUser(Request $request, ?object $user): bool {
        return Hash::check($request->input('password'), $user->password);
    }

    public function updateUserApiKeyByLogin($login, string $apikey): void {
        DB::table('user')
            ->where('login', $login)
            ->update(['api_key' => $apikey]);
    }

    public function hashUserPassword($password): string {
        return Hash::make($password);
    }

    public function bindUserDataByRequestData(Request $request, $user): void {
        $user->name = $request->name;
        $user->login = $request->login;
        $user->password = Hash::make($request->password);
    }
}
