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
           return Disposal::where('status','LIKE',"%processing%")->latest()->paginate(10);
       }else{
           $createdBy = Auth::user()->id;
           return Disposal::where('createdBy', $createdBy)
           ->where('status','LIKE',"%processing%")->latest()->paginate(); //get or paginate?
       }
   }
   public function update(Request $request, $id)
    {
        $this->validate($request, [
            'number' => 'required|max:191', //1
            'article' => 'required|string|max:191', //1
            'description' => 'required|string', //2
            'property_number' => 'max:191', //3
            'unit_of_measure' => 'required|string|max:191', //4
            'price' => 'max:191', //5
            'quantity' => 'required|max:191', //6
            'total_value' => 'max:191', //7
            'date' => 'max:191', //8
            'accountable_officer' => 'required|string|max:191', //9
            'remarks' => 'max:191', //10
            'account_name' => 'required|string|max:191', //11
            'service' => 'required|string|max:191', //12 
            'property_type' => 'required|string|max:191', //12 
            'createdBy' => 'max:191', //12 
            'status' => 'max:191', //13
            

            
        ]);
        //
        $asset = Disposal::findOrFail($id);
        $asset->update($request->all());
        return ['message' => 'Updated the assets info'];
    }
}