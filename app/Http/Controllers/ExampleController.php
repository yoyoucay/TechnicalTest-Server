<?php

namespace App\Http\Controllers;

class ExampleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function GenerateKey(){
        return str_random(32);
    }

    public function PostExample(){
        return 'Get data with POST Method';
    }

    //
}
