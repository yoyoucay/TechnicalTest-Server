<?php

namespace App\Http\Controllers;
use \Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\User;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        # Middleware
         $this->middleware('auth');
    }

    public function Show($pi_id){
        $user = User::find($pi_id);

        if($user){
            return response()->json([
                'success' => true,
                'message' => 'User ditemukan!',
                'data' => $user
            ], 200);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan!',
                'data' => ''
            ], 404);
        }
    }

    //
}
