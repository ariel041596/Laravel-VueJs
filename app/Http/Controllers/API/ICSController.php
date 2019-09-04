<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\ICS;
class ICSController extends Controller
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
        

        if(\Gate::allows('isAdmin') || \Gate::allows('isAuthor') || \Gate::allows('isUser')){
            return ICS::latest()->paginate(5);
        }
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
            'number' => 'required|string|max:191', //1
            'article' => 'required|string|max:191', //1
            'description' => 'required|string|max:191', //2
            'property_number' => 'max:191', //3
            'unit_of_measure' => 'required|string|max:191', //4
            'price' => 'max:191', //5
            'quantity' => 'required|max:191', //6
            'total_value' => 'max:191', //7
            'date' => 'max:191', //8
            'accountable_officer' => 'required|string|max:191', //9
            'remarks' => 'max:191', //10
            'account_name' => 'required|string|max:191', //11
            'service' => 'string|max:191', //12
            

            
        ]);
        // Insert the data into databse
        return ICS::create([
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
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ics = ICS::whereId($id)->first();
        return response()->json([
            "ics" => $ics   
        ], 200);

        
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
        //
        $ics = ICS::findOrFail($id);
        $ics->update($request->all());
        return ['message' => 'Updated the ics info'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $ics = ICS::findOrFail($id);
        $ics->delete();
        return ['message' => 'ICS Deleted'];
    }
}
