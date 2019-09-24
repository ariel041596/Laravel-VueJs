<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Asset;
use App\User;
use App\Disposal;
use App\RequestAsset;
use \Auth;

class RequestPropertyController extends Controller
{
   public function __construct()
   {
       $this->middleware('auth:api');
   }
   
   public function index()
   {
        if(\Gate::allows('isAdmin')){
            return RequestAsset::where('status','LIKE',"%pending%")->latest()->paginate();
        }
        else{
            if(\Gate::allows('isEmployee')){
                $createdBy = Auth::user()->id;
                return RequestAsset::where('createdBy', $createdBy)->latest()->paginate(); //get or paginate?
            }else{
                if(\Gate::allows('isSupply')){
                    return RequestAsset::where('status','LIKE',"%pending%")
                    ->orWhere('status','LIKE',"%unavailable%")->latest()->paginate();
                }
            }
        }
   }

   public function store(Request $request)
   {
   
       $this->validate($request, [
           'entity_name' => 'required|string|max:191', //1
           'service' => 'required|string|max:191', //2
           'request_number' => 'required|string|max:191', //3
           'unit_of_measure' => 'required|string|max:191', //4
           'description' => 'required|string|max:191', //5
           'quantity' => 'required|string|max:191', //6
           'status' => 'required|string|max:191', //7
           'remarks' => 'max:191', //8
           'purpose' => 'required|string|max:191', //9
           'accountable_officer' => 'required|string|max:191', //10
           'issued_by' => 'max:191', //11
           'received_by' => 'max:191', //12 
           'createdBy' => 'required|max:191', //13 
          
       ]);
       // Insert the data into databse
       return RequestAsset::create([

           'entity_name' => $request['entity_name'], //1
           'service' => $request['service'], //2
           'request_number' => $request['request_number'], //3
           'unit_of_measure' => $request['unit_of_measure'], //4
           'description' => $request['description'], //5
           'quantity' => $request['quantity'], //6
           'status' => $request['status'], //7
           'remarks' => $request['remarks'], //8
           'purpose' => $request['purpose'],//9
           'accountable_officer' => $request['accountable_officer'], //10
           'issued_by' => $request['issued_by'], //11
           'received_by' => $request['received_by'],//12
           'createdBy' => $request['createdBy'],//13
       ]);
   }

   public function show($id)
   {
       $asset = RequestAsset::whereId($id)->first();
       return response()->json([
           "asset" => $asset   
       ], 200);

   }
   public function update(Request $request, $id)
   {
       if(\Gate::allows('isSupply')){
            $this->validate($request, [
                'entity_name' => 'required|string|max:191', //1
                'service' => 'required|string|max:191', //2
                'request_number' => 'required|string|max:191', //3
                'unit_of_measure' => 'required|string|max:191', //4
                'description' => 'required|string|max:191', //5
                'quantity' => 'required|string|max:191', //6
                'status' => 'required|string|max:191', //7
                'remarks' => 'required|string|max:191', //8
                'purpose' => 'required|string|max:191', //9
                'accountable_officer' => 'required|string|max:191', //10
                'issued_by' => 'required|string|max:191', //11
                'received_by' => 'required|string|max:191', //12
            ]);
        }else{
            if(\Gate::allows('isEmployee')){
                $this->validate($request, [
                    'entity_name' => 'required|string|max:191', //1
                    'service' => 'required|string|max:191', //2
                    'request_number' => 'required|string|max:191', //3
                    'unit_of_measure' => 'required|string|max:191', //4
                    'description' => 'required|string|max:191', //5
                    'quantity' => 'required|string|max:191', //6
                    'status' => 'required|string|max:191', //7
                    'remarks' => 'max:191', //8
                    'purpose' => 'required|string|max:191', //9
                    'accountable_officer' => 'required|string|max:191', //10
                    'issued_by' => 'max:191', //11
                    'received_by' => 'max:191', //12 
                    'createdBy' => 'required|max:191', //13 
                   
                ]);
            }
        }
       $asset = RequestAsset::findOrFail($id);
       $asset->update($request->all());
       return ['message' => 'Updated the assets info'];
   }

   public function destroy($id)
   {
       $asset = RequestAsset::findOrFail($id);
       $asset->delete();
       return ['message' => 'Asset Deleted'];
   
   }
}
