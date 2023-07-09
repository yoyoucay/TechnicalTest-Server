<?php

namespace App\Http\Controllers;
use \Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class ExampleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        # Middleware
        // $this->middleware('verify', ['except'=> ['GetRoomID']]);
    }

    public function GenerateKey(){
        return str_random(32);
    }

    public function PostExample(){
        return 'Get data with POST Method';
    }

    public function GetRoomID($pi_ID){
        return 'Room ID : '.$pi_ID;
    }

    public function GetRoomCat($pi_ID, $pi_Category){
        return 'Room ID : '.$pi_ID.' | Category : '.$pi_Category;
    }

    public function fooBar(Request $request){
        if ($request->is('foobar')) {
            return 'Success. Method '. $request->method();
        }else{
            return 'Fail. Method '. $request->method();
        }
        // return $request->path();
    }

    public function GetUser(Request $request) {

        # Menampilkan jenis Method yang di gunakan
        // return $request->method();
        
        #Return beberapa data
        // $dataUser['username'] = $request->username;
        // $dataUser['email'] = $request->email;

        #Validasi Request untuk check user sudah terverifikasi atau belum
        if ($request->has('verify')) {
            if ($request->verify <> 1) {
                return 'Anda belum melakukan verifikasi';
            }           
        }
        
        #Return Semua data yang di terima        
        return $request->all();
    }

    //
}
