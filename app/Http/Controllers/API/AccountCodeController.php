<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// use the App\AccountCode
use App\AccountCode;
class AccountCodeController extends Controller
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
        if(\Gate::allows('isAdmin') || \Gate::allows('isAuthor') || \Gate::allows('isUser' ) || \Gate::allows('isSupply' )){
            return AccountCode::latest()->paginate(5);
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
            'account_code' => 'required|string|max:191', //1
            'account_name' => 'required|string|max:191', //2
            
        ]);
        // Insert the data into databse
        return AccountCode::create([
            'account_code' => $request['account_code'], //1
            'account_name' => $request['account_name'], //1
        ]);
    }

    public function update(Request $request, $id)
    {
        //
        $accountcode = AccountCode::findOrFail($id);
        $accountcode->update($request->all());
        return ['message' => 'Updated the Accounts info'];
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
        $accountcode = AccountCode::findOrFail($id);
        $accountcode->delete();
        return ['message' => 'Accounts Deleted'];
    }
}
