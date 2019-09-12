<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Asset;
use App\User;
use App\Disposal;
use \Auth;

class AssetPendingController extends Controller
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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $pending = Asset::asset()->status->pending;
        return Asset::where('status','LIKE',"%pending%")->latest()->paginate(); //get or paginate? 
    }


}
