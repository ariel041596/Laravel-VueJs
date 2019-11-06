<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Asset;
use App\User;
use App\Disposal;
use \Auth;
use Excel;
use DB;
use Validator;
use Input;


class ImportDataController extends Controller
{
    public function index()
    {
        return view('import');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator);
        }
        $file = $request->file('file');
        $csvData = file_get_contents($file);
        $rows = array_map("str_getcsv", explode("\n", $csvData));
        // dd($csvData);
        $header = array_shift($rows);
        foreach($rows as $row){
            $row = array_combine($header, $row);

            Asset::create([
            'number' => $row['number'], //1
            'article' => $row['article'], //1
            'description' => $row['description'], //2
            'property_number' => $row['propertynumber'], //3
            'unit_of_measure' => $row['unit'], //4
            'price' => $row['price'], //5   
            'quantity' => $row['quantity'], //6
            'total_value' => $row['totalvalue'], //7
            'date' => $row['date'], //8 
            'accountable_officer' => $row['accountableofficer'], //9
            'remarks' => $row['remarks'], //10
            'account_name' => $row['accountname'], //11
            'service' => $row['service'], //12
            'property_type' => $row['propertytype'], //12
            'createdBy' => $row['createdBy'], //12
            'status' => $row['status'], //13
            'transfer_to' => $row['transferto'], //13
            'received_from' => $row['receivedfrom'], //13
            'transfer_to_designation' => $row['transfertodesignation'], //13
        ]);
        
        return redirect()->back();
    }
    }
}
