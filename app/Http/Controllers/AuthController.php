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

        
        $register = User::create([
            'fullname' => $fullname,
            'email' => $email,
            'password' => $password,
            'verify' => 0,
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
        $email = $request->input('email');
        $password = $request->input('password');

        $user = User::where('email', $email)->first();

        if(Hash::check($password, $user->password)){
            $apiToken = base64_encode(str_random(40));

            $user->update([
                'api_token' => $apiToken
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Berhasil login',
                'data' => [
                    'user' => $user,
                    'api_token' => $apiToken
                ]
            ], 201);
        }else {
            return response()->json([
                'success' => false,
                'message' => 'Gagal login',
                'data' => ''
            ], 400);
        }
    }
}
