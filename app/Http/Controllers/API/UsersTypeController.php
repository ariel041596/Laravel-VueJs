<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\UsersType;

class UsersTypeController extends Controller
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
        if(\Gate::allows('isAdmin') || \Gate::allows('isAuthor')){
            return UsersType::latest()->paginate(5);
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
            'users_type' => 'required|string|max:191|unique:users_types,users_type,', //1
        ]);
        // Insert the data into databse
        return UsersType::create([
            'users_type' => $request['users_type'], //1
        ]);
    }

    public function update(Request $request, $id)
    {
        //
        $users_type = UsersType::findOrFail($id);
        $users_type->update($request->all());
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
        $users_type = UsersType::findOrFail($id);
        $users_type->delete();
        return ['message' => 'Accounts Deleted'];
    }
}
