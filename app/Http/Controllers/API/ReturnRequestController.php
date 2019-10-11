<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Asset;
use App\User;
use App\Disposal;
use \Auth;

class ReturnRequestController extends Controller
{
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
       if(\Gate::allows('isAdminOrUser')){
           // return Asset::latest()->paginate(10);
           return Disposal::where('status','LIKE',"%Pending%")->latest()->paginate(1);
       }else{
           $createdBy = Auth::user()->id;
           return Disposal::where('createdBy', $createdBy)
           ->where('status','LIKE',"%Pending%")->latest()->paginate(); //get or paginate?
       }
   }
}
