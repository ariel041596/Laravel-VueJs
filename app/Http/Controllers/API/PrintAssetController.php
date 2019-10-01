<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Asset;
use App\User;
use App\Disposal;
use \Auth;

class PrintAssetController extends Controller
{
    /**
     * Create a new controller instance. - Cannot be seen by other unless they are authorized and login
     *
     * @return void
     */
    public function __construct()
    {
        // make an auth: to use the api passport
        $this->middleware('auth:api');
    }

    // public function index(){
    //     $asset = Asset::whereId($id)->first();
    //     return response()->json([
    //         "asset" => $asset   
    //     ], 200);
    // }

    // public function show($id)
    // {
    //     // // return auth('api')->asset();
    //     // $par = Asset::whereId($id)->first();
    //     // return response()->json([
    //     //     "par" => $par   
    //     // ], 200);
    // }
    public function edit($id)
    {
        $asset = Asset::whereId($id)->first();
        return response()->json([
            "asset" => $asset   
        ], 200);
    }
}
