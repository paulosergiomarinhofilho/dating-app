<?php

namespace App\Http\Controllers;

use Laravel\Passport\HasApiTokens;
use Illuminate\Http\Request;


use App\Models\User;
use App\Models\DeviceInformation;

class AuthController extends Controller
{

    public function __construct()
    {
    }

    public function login(Request $request)
    {

        $loginData = request()->validate([
            'password'  =>  'required',
            'email'     =>  'required|email'
        ]);

        if (!auth()->attempt($loginData)) {
            $response = ['status'=> false, 'message' => 'Credenciais inválidas'];
            return $response;
        }
        

       
        if (!auth()->user()->active) {
             $response = ['status'=> false, 'message' => 'Usuário desativado'];
             return $response;
        }
        
        $user  = User::find(auth()->user()->id);

        if (!$request->keep_other_devices_logged) {
            $user->tokens()->where('tokenable_id', $user->id)->delete();
        }
        

        $access_token = $user->createToken('authToken')->plainTextToken;


        $response = ['status' => true, 'data' => $user, 'access_token' => $access_token];
        return $response;

    }
    public function logout(Request $request)
    {
        $request->user()->tokens()->where('tokenable_id', $request->user()->id)->delete();
        DeviceInformation::where('user_id', $request->user()->id)->delete();
        return ['status' => true];
    }

}
