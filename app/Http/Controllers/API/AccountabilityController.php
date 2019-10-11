<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Asset;
use App\User;
use \Auth;

class AccountabilityController extends Controller
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
            $employeename = Auth::user()->name;
            return Asset::where('accountable_officer',$employeename)
            ->where('status','LIKE',"%approved%")
            ->orWhere('status','LIKE',"%For Returned%")->paginate();
       
        
    }
}
