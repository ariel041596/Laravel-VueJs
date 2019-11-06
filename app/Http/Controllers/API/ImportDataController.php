<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
    public function __construct()
    {
        // make an auth: to use the api passport
        $this->middleware('auth:api');
    }
    // Get Method
    public function index()
    {
       
    }
    // Post Method
    public function store(Request $request)
    {   
        $this->validate($request, [
            'file' => 'required',
        ]);
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
        }

        // $validator = Validator::make($request->all(), [
        //     'file' => 'required',
        // ]);
        // if ($validator->fails()) {
        //     return redirect()
        //         ->back()
        //         ->withErrors($validator);
        // }
        // $file = $request->file('file');
        // $csvData = file_get_contents($file);
        // $rows = array_map("str_getcsv", explode("\n", $csvData));
        // $header = array_shift($rows);
     
        // foreach($rows as $row){
        //     $row = array_combine($header, $row);

        //     Asset::create([
        //     'number' => $row['number'], //1
        //     'article' => $row['article'], //1
        //     'description' => $row['description'], //2
        //     'property_number' => $row['propertynumber'], //3
        //     'unit_of_measure' => $row['unit'], //4
        //     'price' => $row['price'], //5   
        //     'quantity' => $row['quantity'], //6
        //     'total_value' => $row['totalvalue'], //7
        //     'date' => $row['date'], //8 
        //     'accountable_officer' => $row['accountableofficer'], //9
        //     'remarks' => $row['remarks'], //10
        //     'account_name' => $row['accountname'], //11
        //     'service' => $row['service'], //12
        //     'property_type' => $row['propertytype'], //12
        //     'createdBy' => $row['createdBy'], //12
        //     'status' => $row['status'], //13
        //     'transfer_to' => $row['transferto'], //13
        //     'received_from' => $row['receivedfrom'], //13
        //     'transfer_to_designation' => $row['transfertodesignation'], //13
        //     ]);
        // }

        // $path = $request->file->getRealPath();
        //     $data = Excel::load($path)->get();
            
        //     foreach($data as $value){
        //         $arr[] = [
        //             'number' => $value->number,
        //             'article' => $value->article, 
        //             'description' => $value->description,
        //             'property_number' => $value->propertynumber,
        //             'unit_of_measure' => $value->unit, 
        //             'price' => $value->price, 
        //             'quantity' => $value->quantity, 
        //             'total_value' => $value->totalvalue,
        //             'date' => $value->date, 
        //             'accountable_officer' => $value->accountableofficer, 
        //             'remarks' => $value->remarks,
        //             'account_name' => $value->accountname,
        //             'service' => $value->service,
        //             'property_type' => $value->propertytype,
        //             'createdBy' => $value->createdBy,
        //             'status' => $value->status,
        //             'transfer_to' => $value->transferto,
        //             'received_from' => $value->receivedfrom,
        //             'transfer_to_designation' => $value->transfertodesignation,
        //         ];
        //     }
        //     if(!empty($data)){
        //         DB::table('assets')->insert($arr);
        //         echo "data inserted";
        //     }    


        // if (empty(file('file')->getRealPath())) {
        //     return back()->with('success','No file selected');
        // }else {
        //     $path = file('file')->getRealPath();
        //     $inserts = [];
        //     Excel::load($path,function($reader) use (&$inserts)
        //     {
        //         foreach ($reader->toArray() as $rows){
        //             foreach($rows as $row){
        //                 $inserts[] = [
        //                     'number' => $row['number'], 
        //                     'article' => $row['article'], 
        //                     'description' => $row['description'], 
        //                     'property_number' => $row['propertynumber'], 
        //                     'unit_of_measure' => $row['unit'], 
        //                     'price' => $row['price'],
        //                     'quantity' => $row['quantity'],
        //                     'total_value' => $row['totalvalue'],
        //                     'date' => $row['date'],
        //                     'accountable_officer' => $row['accountableofficer'],
        //                     'remarks' => $row['remarks'],
        //                     'account_name' => $row['account_name'],
        //                     'service' => $row['service'],
        //                     'property_type' => $row['propertytype'],
        //                     'createdBy' => $row['createdBy'],
        //                     'status' => $row['status'],
        //                     'transfer_to' => $row['transferto'],
        //                     'received_from' => $row['receivedfrom'],
        //                     'transfer_to_designation' => $row['transfertodesignation'],];
                        
        //             }
        //         }
        //     });
        //     if (!empty($inserts)) {
        //         DB::table('assets')->insert($inserts);
        //         return back()->with('success','Inserted Record successfully');                  
        //     }
            
        //     return back();
        // }


    }



}
