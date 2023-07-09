<?php

namespace App\Http\Controllers;
use \Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Hash;
use App\User;

class AuthController extends Controller
{   
    public function __construct()
    {
        # Middleware
        // $this->middleware('verify', ['except'=> ['GetRoomID']]);
    }

    public function Register(Request $request){

        #Pengambilan
        $fullname = $request->input('fullname');
        $email = $request->input('email');
        $password = Hash::make($request->input('password'));

        
        $register ::create([
            'name' => $name,
            'email' => $email,
            'password' => $password
        ]);

        if ($register) {
            return response()->json([
                'success' => true,
                'message' => 'Berhasil meregistrasi akun!',
                'data' => $register
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Gagal meregistrasi akun!',
                'data' => $register
            ], 400);
        }
        
    }

    public function Login(Request $request){
        
    }
}
