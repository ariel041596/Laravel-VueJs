<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use the App\User
use App\User;
// Use also the Hash in order to hash the password
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
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
        // This function will restrict all the functions only for those registered user type 
        // $this->authorize('isAdmin');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Restrict the url for the other user which is not allowed
        // $this->authorize('isAdmin');
        if(\Gate::allows('isAdmin') || \Gate::allows('isAuthor')){
            return User::latest()->paginate(5);
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
            // Validate the inputs in form
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users,email,',
            // 'email' => 'required|string|email|max:191|unique:users,email,'.$user->id.',user_id',
            // 'email' => 'unique:users,email_address,'.$user->id.',user_id'
            // 'email' => 'unique:users,email_address,'.$user->id
            'password' => 'sometimes|required|string|min:6',
            'type' => 'required|string|max:191',
        ]);
        // Insert the data into databse
        return User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'type' => $request['type'],
            'bio' => $request['bio'],
            'photo' => $request['photo'],
            'password' => Hash::make($request['password']),
        ]);
    }
    // Show public profile to the other user so they can follow you
    public function profile()
    {
        // When dealing with the API
        return auth('api')->user();
        // return Auth::user();
        
    }
    // Show public profile and insert and image using base64
    public function updateProfile(Request $request)
    {
        // When dealing with the API
        $user = auth('api')->user();

            // Validate the inputs in form
            $this->validate($request, [
                'name' => 'required|string|max:191',
                'email' => 'required|string|email|max:191|unique:users,email,'.$user->id,
                'password' => 'sometimes|required|string|min:6',
            ]);
        
        // return an info of the user
        // return ['message:' =>"Success"];
        // return $request->photo;
        // Install the php image uploader which is ----Intervention Image ---
        // Command 1: $php composer require intervention/image
        // Command 2: $php artisan vendor:publish --provider="Intervention\Image\ImageServiceProviderLaravel5" 
        $currentPhoto = $user->photo;
        if($request->photo!=$currentPhoto){
            $name = time().'.' . explode('/', explode(':', substr($request->photo, 0, strpos
            ($request->photo, ';')))[1])[1];

            \Image::make($request->photo)->save(public_path('img/profile/').$name);
            // $request->photo = $name; 
            $request->merge(['photo' => $name]);
            // Delete Photo if user change profile photo
            $userPhoto = public_path('img/profile/').$currentPhoto;
            if(file_exists($userPhoto)){
                @unlink($userPhoto);
            }
        }

        // Encrypt the password check the inputs and save to database 
        if(!empty($request->password)){
            $request->merge(['password' => Hash::make($request['password'])]);
        }

        $user->update($request->all());
        return ['message' => "Success"];
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
             // Validate the inputs in form
            //  $this->validate($request, [
            //     'password' => 'required|string|min:6',
            // ]);
            // Insert the data into databse
            // return User::create([
            //     'password' => Hash::make($request['password']),
            // ]);
        // //
        $user = User::findOrFail($id);

        // Validate the inputs in form
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users,email,'.$user->id,
            'password' => 'sometimes|required|string|min:6',
        ]);

        // Encrypt the password check the inputs and save to database 
        if(!empty($request->password)){
            $request->merge(['password' => Hash::make($request['password'])]);
        }

        $user->update($request->all());
        return ['message' => 'Updated the users info'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // only allowed user type can acces this function
        $this->authorize('isAdmin');
        //
        $user = User::findOrFail($id);
        $user->delete();
        return ['message' => 'User Deleted'];
    }

    public function search(){

        if ($search = \Request::get('q')) {
            $users = User::where(function($query) use ($search){
                $query->where('name','LIKE',"%$search%")
                        ->orWhere('email','LIKE',"%$search%");
                        // orWhere to use other search like for type or description
            })->paginate(20);
        }else{
            // if the users do not found any data after delete all search words
            $users = User::latest()->paginate(5);
        }

        return $users;

    }
}
