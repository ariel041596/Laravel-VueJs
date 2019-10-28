<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Asset;
use App\User;
use App\Disposal;
use \Auth;
use App\ForReissue;
class ApprovedTransferController extends Controller
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
            return ForReissue::where('status','LIKE',"%approved%")->latest()->paginate(10);
        }else{
            $createdBy = Auth::user()->name;
            return ForReissue::where('received_from', $createdBy)
            ->where('status','LIKE',"%approved%")->latest()->paginate(); //get or paginate?
        }
    }
}
