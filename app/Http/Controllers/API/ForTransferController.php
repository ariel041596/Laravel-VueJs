<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Asset;
use App\User;
use App\Disposal;
use \Auth;
use App\ForReissue;

class ForTransferController extends Controller
{
    public function __construct()
    {
        // make an auth: to use the api passport
        $this->middleware('auth:api');
    }
    public function index()
    {
        
        if(\Gate::allows('isAdminOrUser')){
            // return Asset::latest()->paginate(10);
            return ForReissue::where('status','LIKE',"%ForTransfer%")->latest()->paginate(10);
        }else{
            $createdBy = Auth::user()->id;
            return ForReissue::where('createdBy', $createdBy)
            ->where('status','LIKE',"%ForTransfer%")->latest()->paginate(); //get or paginate?
        }
    }
    public function store(Request $request)
    {
    
        // 'article', 'description', 'property_number','unit_of_measure','price','quantity','total_value','date','accountable_officer','remarks','service'
            // Validate the inputs in form
        $this->validate($request, [
            // 'number' => 'required|string|max:191|unique:assets,number', //1
            'number' => 'required|string|max:191', //1
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
            'transfer_to' => 'required|max:191', //13
            'received_from' => 'max:191', //13
            'transfer_to_designation' => 'required|max:191', //13
            

            
        ]);
        // Insert the data into databse
        return ForReissue::create([
            
            'number' => $request['number'], //1
            'article' => $request['article'], //1
            'description' => $request['description'], //2
            'property_number' => $request['property_number'], //3
            'unit_of_measure' => $request['unit_of_measure'], //4
            'price' => $request['price'], //5
            'quantity' => $request['quantity'], //6
            'total_value' => $request['total_value'], //7
            'date' => $request['date'], //8 
            'accountable_officer' => $request['accountable_officer'], //9
            'remarks' => $request['remarks'], //10
            'account_name' => $request['account_name'], //11
            'service' => $request['service'], //12
            'property_type' => $request['property_type'], //12
            'createdBy' => $request['createdBy'], //12
            'status' => $request['status'], //13
            'transfer_to' => $request['transfer_to'], //13
            'received_from' => $request['received_from'], //13
            'transfer_to_designation' => $request['transfer_to_designation'], //13
        ]);
    }
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'number' => 'required|string|max:191', //1
            'article' => 'required|string', //1
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
            'transfer_to' => 'max:191', //13
            'received_from' => 'max:191', //13
            

            
        ]);
        //
        $asset = ForReissue::findOrFail($id);
        $asset->update($request->all());
        return ['message' => 'Updated the assets info'];
    }
    public function search(){

        if ($search = \Request::get('q')) {
            $pendings = ForReissue::where('status','LIKE',"%ForTransfer%")
            ->where(function($query) use ($search){
                $query->where('article','LIKE',"%$search%")
                        ->orWhere('description','LIKE',"%$search%")
                        ->orWhere('property_number','LIKE',"%$search%")
                        ->orWhere('price','LIKE',"%$search%")
                        ->orWhere('accountable_officer','LIKE',"%$search%")
                        ->orWhere('remarks','LIKE',"%$search%")
                        ->orWhere('account_name','LIKE',"%$search%");
                        // orWhere to use other search like for type or description
            })->paginate(20);
        }else{
            // if the users do not found any data after delete all search words
            $pendings = ForReissue::where('status','LIKE',"%ForTransfer%")->latest()->paginate();
        }

        return $pendings;

    }
}
