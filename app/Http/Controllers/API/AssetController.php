<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use the App\Asset
use App\Asset;
use App\User;
use App\Disposal;
use \Auth;
use App\AccountCode;
use App\ArticleCategory;
use App\AccountOfficer;

class AssetController extends Controller
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
        if(\Gate::allows('isAdmin')){
        return Asset::where('status','LIKE',"%approved%")
            ->where('property_type','LIKE',"%PAR%")->latest()->paginate(50);
        }else{
            $createdBy = Auth::user()->id;
            return Asset::where('createdBy', $createdBy)
            ->where('status','LIKE',"%approved%")
            ->where('property_type','LIKE',"%PAR%")->latest()->paginate(50); //get or paginate?
          
        }
        // $total_assets = Asset::where('property_type', '=', 'PAR')->count();
        // $user = auth('api')->user();
        // $account_code = AccountCode::latest()->get();
        
        // if(\Gate::allows('isAdminOrUserOrAuthorOrEmployeeOrSupply') ){
        //     $article_category = ArticleCategory::latest()->get();
        // }
        // if(\Gate::allows('isAdminOrUserOrAuthorOrEmployeeOrSupply') ){
        //     $account_officer = AccountOfficer::latest()->get();
        // }

        // return response()->json([
        //     "asset" => $assets,
        //     "total_asset" => $total_assets,
        //     "user" => $user,
        //     "account_code" => $account_code,
        //     "article_category" => $article_category,
        //     "account_officer" => $account_officer,
        // ], 200);

            // if(\Gate::allows('isAdmin')){
            //     return Asset::where('status','LIKE',"%approved%")
            //     ->where('property_type','LIKE',"%PAR%")->latest()->paginate(50);
            // }
            // else{
            // $createdBy = Auth::user()->id;
            // return Asset::where('createdBy', $createdBy)
            // ->where('status','LIKE',"%approved%")
            // ->where('property_type','LIKE',"%PAR%")->latest()->paginate(50); //get or paginate?
            // }
        
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
            'transfer_to' => 'max:191', //13
            'received_from' => 'max:191', //13
            

            
        ]);
        // Insert the data into databse
        return Asset::create([
            
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function edit($id)
    // {
    //     $asset = Asset::whereId($id)->first();
    //     return response()->json([
    //         "asset" => $asset   
    //     ], 200);
    // }
    public function show($id)
    {
    //     // return auth('api')->asset();
        $asset = Asset::whereId($id)->first();
        return response()->json([
            "asset" => $asset   
        ], 200);
        // $asset = Asset::find($id);
        // return response()->json($asset);

        // $accountabilities = Asset::find($id);
        // return $accountabilities;

        // $asset = Asset::find($id);
        // return $asset;
        // $asset = Asset::with()
        // ->findOrFail($id);

        // return response()
        // ->json(['asset' => $asset]);

        // return Asset::latest()->paginate(5);

        // $accountabilities = Asset::find($id)->first();
        // return response()->json([
        //     "assets" => $accountabilities
        // ], 200);
        // if(\Gate::allows('isAdmin') || \Gate::allows('isAuthor') || \Gate::allows('isUser')){
        //     return Asset::latest()->paginate(5);
        // }

        // if(\Gate::allows('isAdmin') || \Gate::allows('isAuthor') || \Gate::allows('isUser')){
        //     return Asset::whereId($id)->paginate();
        // }

        // $asset = Asset::find($id)->paginate();
        // return $asset;
        
        // return Asset;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'number' => 'required|max:191', //1
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
        $asset = Asset::findOrFail($id);
        $asset->update($request->all());
        return ['message' => 'Updated the assets info'];
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $asset = Asset::findOrFail($id);
        $asset->delete();
        return ['message' => 'Asset Deleted'];
    
    }
    public function search(){

        $createdBy = Auth::user()->id;
        if ($search = \Request::get('q')) {
            $assets = Asset::where('createdBy', $createdBy)
            ->where('status','LIKE',"%approved%")
            ->where('property_type','LIKE',"%PAR%")
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
            $assets = Asset::where('createdBy', $createdBy)
            ->where('status','LIKE',"%approved%")
            ->where('property_type','LIKE',"%PAR%")->latest()->paginate(50);
        }

        return $assets;
        // return response()->json([
        //     "asset" => $assets,
        // ], 200);

    }
}
