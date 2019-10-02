<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// use the App\AccountOfficer
use App\AccountOfficer;
class AccountOfficerController extends Controller
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
        if(\Gate::allows('isAdminOrUserOrAuthorOrEmployeeOrSupply') ){
            return AccountOfficer::latest()->paginate(5);
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
            'name' => 'required|string|max:191|unique:account_officers,name', //1
            'designation' => 'required|string|max:191', //2
            'service' => 'required|string|max:191', //3
            
        ]);
        // Insert the data into databse
        return AccountOfficer::create([
            'name' => $request['name'], //1
            'designation' => $request['designation'], //1
            'service' => $request['service'], //1
        ]);
    }

    public function update(Request $request, $id)
    {
        //
        $this->validate($request, [
            'name' => 'required|string|max:191', //1
            'designation' => 'required|string|max:191', //2
            'service' => 'required|string|max:191', //3
            
        ]);
        $accountofficer = AccountOfficer::findOrFail($id);
        $accountofficer->update($request->all());
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
        $accountofficer = AccountOfficer::findOrFail($id);
        $accountofficer->delete();
        return ['message' => 'Accounts Deleted'];
    }
}
