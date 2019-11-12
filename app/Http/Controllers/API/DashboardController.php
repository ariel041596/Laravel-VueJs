<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Asset;
use App\User;
use App\Disposal;
use \Auth;
class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        // $dashboard = [
        //     [
        //         'title'=>'All PAR',
        //         'type'=>'value',
        //         'value'=> 
        //     ]
        // ]

    //    $asset = Asset::where('status', 'approved')->get();
    //    return $asset->sum->total_value;

       $land = Asset::where('status', 'approved')
       ->where('property_type', 'PAR')
       ->where('account_name', 'LAND')->get();
       $LAND = $land->sum->total_value;

       $building = Asset::where('status', 'approved')
       ->where('property_type', 'PAR')
       ->where('account_name', 'BUILDINGS')->get();
       $BUILDINGS = $building->sum->total_value;

       $office = Asset::where('status', 'approved')
       ->where('property_type', 'PAR')
       ->where('account_name', 'OFFICE EQUIPMENT')->get();
       $OFFICE_EQUIPMENT = $office->sum->total_value;

       $ict = Asset::where('status', 'approved')
       ->where('property_type', 'PAR')
       ->where('account_name', 'ICT EQUIPMENT')->get();
       $ICT_EQUIPMENT = $ict->sum->total_value;

       $communication = Asset::where('status', 'approved')
       ->where('property_type', 'PAR')
       ->where('account_name', 'COMMUNICATION EQUIPMENT')->get();
       $COMMUNICATION_EQUIPMENT = $communication->sum->total_value;

       $drre = Asset::where('status', 'approved')
       ->where('property_type', 'PAR')
       ->where('account_name', 'DISASTER RESPONSE AND RESCUE EQUIPMENT')->get();
       $DISASTER_RESPONSE_AND_RESCUE_EQUIPMENT = $drre->sum->total_value;

       $medical = Asset::where('status', 'approved')
       ->where('property_type', 'PAR')
       ->where('account_name', 'MEDICAL EQUIPMENT')->get();
       $MEDICAL_EQUIPMENT = $medical->sum->total_value;

       $techsci = Asset::where('status', 'approved')
       ->where('property_type', 'PAR')
       ->where('account_name', 'TECHNICAL AND SCIENTIFIC EQUIPMENT')->get();
       $TECHNICAL_AND_SCIENTIFIC_EQUIPMENT = $techsci->sum->total_value;

       $othermachine = Asset::where('status', 'approved')
       ->where('property_type', 'PAR')
       ->where('account_name', 'OTHER MACHINERY AND EQUIPMENT')->get();
       $OTHER_MACHINERY_AND_EQUIPMENT = $othermachine->sum->total_value;

       $mv = Asset::where('status', 'approved')
       ->where('property_type', 'PAR')
       ->where('account_name', 'MOTOR VEHICLES')->get();
       $MOTOR_VEHICLES = $mv->sum->total_value;

       $ff = Asset::where('status', 'approved')
       ->where('property_type', 'PAR')
       ->where('account_name', 'FURNITURE AND FIXTURES')->get();
       $FURNITURE_FIXTURES = $ff->sum->total_value;

       $books = Asset::where('status', 'approved')
       ->where('property_type', 'PAR')
       ->where('account_name', 'BOOKS')->get();
       $BOOKS = $books->sum->total_value;

       $software = Asset::where('status', 'approved')
       ->where('property_type', 'PAR')
       ->where('account_name', 'COMPUTER SOFTWARE')->get();
       $COMPUTER_SOFTWARE = $software->sum->total_value;

       $otherPPE = Asset::where('status', 'approved')
       ->where('property_type', 'PAR')
       ->where('account_name', 'OTHER PROPERTY, PLANT AND EQUIPMENT')->get();
       $OTHER_PPE = $otherPPE->sum->total_value;

       $otherTranspo = Asset::where('status', 'approved')
       ->where('property_type', 'PAR')
       ->where('account_name', 'OTHER TRANSPORTATION EQUIPMENT')->get();
       $OTHER_TRANSPORTATION_EQUIPMENT = $otherTranspo->sum->total_value;

       $machinery = Asset::where('status', 'approved')
       ->where('property_type', 'PAR')
       ->where('account_name', 'MACHINERY')->get();
       $MACHINERY = $machinery->sum->total_value;

       $otherSupplies = Asset::where('status', 'approved')
       ->where('property_type', 'PAR')
       ->where('account_name', 'OTHER SUPPLIES AND MATERIAL EXPENSES')->get();
       $OTHER_SUPPLIES_MATERIAL_EXPENSES = $otherSupplies->sum->total_value;

       $officeSupply = Asset::where('status', 'approved')
       ->where('property_type', 'PAR')
       ->where('account_name', 'OFFICE SUPPLIES INVENTORY')->get();
       $OFFICE_SUPPLIES_INVENTORY = $officeSupply->sum->total_value;

       $grandTotal = collect([
           $LAND, 
           $BUILDINGS, 
           $OFFICE_EQUIPMENT, 
           $ICT_EQUIPMENT, 
           $COMMUNICATION_EQUIPMENT,
           $DISASTER_RESPONSE_AND_RESCUE_EQUIPMENT,
           $MEDICAL_EQUIPMENT,
           $TECHNICAL_AND_SCIENTIFIC_EQUIPMENT,
           $OTHER_MACHINERY_AND_EQUIPMENT,
           $MOTOR_VEHICLES,
           $FURNITURE_FIXTURES,
           $BOOKS,
           $COMPUTER_SOFTWARE,
           $OTHER_PPE,
           $OTHER_TRANSPORTATION_EQUIPMENT,
           $MACHINERY,
           $OTHER_SUPPLIES_MATERIAL_EXPENSES,
           $OFFICE_SUPPLIES_INVENTORY
        ])->sum();

    //    $total = Asset::where('account_name', 'LAND')
    //    ->orWhere('account_name', 'BUILDINGS')
    //    ->orWhere('account_name', 'OFFICE EQUIPMENT')
    //    ->orWhere('account_name', 'ICT EQUIPMENT')
    //    ->orWhere('account_name', 'COMMUNICATION EQUIPMENT')
    //    ->orWhere('account_name', 'DISASTER RESPONSE AND RESCUE EQUIPMENT')
    //    ->orWhere('account_name', 'MEDICAL EQUIPMENT')
    //    ->orWhere('account_name', 'TECHNICAL AND SCIENTIFIC EQUIPMENT')
    //    ->orWhere('account_name', 'OTHER MACHINERY AND EQUIPMENT')
    //    ->orWhere('account_name', 'MOTOR VEHICLES')
    //    ->orWhere('account_name', 'FURNITURE & FIXTURES')
    //    ->orWhere('account_name', 'BOOKS')
    //    ->orWhere('account_name', 'COMPUTER SOFTWARE')
    //    ->orWhere('account_name', 'OTHER PROPERTY, PLANT AND EQUIPMENT')
    //    ->orWhere('account_name', 'OTHER TRANSPORTATION EQUIPMENT')
    //    ->orWhere('account_name', 'MACHINERY')
    //    ->orWhere('account_name', 'OTHER SUPPLIES AND MATERIAL EXPENSES')
    //    ->orWhere('account_name', 'OFFICE SUPPLIES INVENTORY')
    //    ->where('property_type', 'PAR')->get();
        // $grandTotal = $officeSupply->$otherSupplies->sum->total_value;

        $pending = Asset::where('status', 'pending')->count();
        $return_request = Disposal::where('status', 'processing')->count();
        $transfer_request = ForReissue::where('status', 'ForTransfer')->count();
        $for_reissue = Asset::where('status', 'forReissue')->count();
        

       return response()->json([
           "LAND" => $LAND,
           "BUILDINGS" => $BUILDINGS,
           "OFFICE_EQUIPMENT" => $OFFICE_EQUIPMENT,
           "ICT_EQUIPMENT" => $ICT_EQUIPMENT,
           "COMMUNICATION_EQUIPMENT" => $COMMUNICATION_EQUIPMENT,
           "DISASTER_RESPONSE_AND_RESCUE_EQUIPMENT" => $DISASTER_RESPONSE_AND_RESCUE_EQUIPMENT,
           "MEDICAL_EQUIPMENT" => $MEDICAL_EQUIPMENT,
           "TECHNICAL_AND_SCIENTIFIC_EQUIPMENT" => $TECHNICAL_AND_SCIENTIFIC_EQUIPMENT,
           "OTHER_MACHINERY_AND_EQUIPMENT" => $OTHER_MACHINERY_AND_EQUIPMENT,
           "MOTOR_VEHICLES" => $MOTOR_VEHICLES,
           "FURNITURE_FIXTURES" => $FURNITURE_FIXTURES,
           "BOOKS" => $BOOKS,
           "COMPUTER_SOFTWARE" => $COMPUTER_SOFTWARE,
           "OTHER_PPE" => $OTHER_PPE,
           "OTHER_TRANSPORTATION_EQUIPMENT" => $OTHER_TRANSPORTATION_EQUIPMENT,
           "MACHINERY" => $MACHINERY,
           "OTHER_SUPPLIES_MATERIAL_EXPENSES" => $OTHER_SUPPLIES_MATERIAL_EXPENSES,
           "OFFICE_SUPPLIES_INVENTORY" => $OFFICE_SUPPLIES_INVENTORY,
           "GRAND_TOTAL" => $grandTotal,
           "Pending" => $pending,
           "Return_Request" => $return_request,
           "Transfer_Request" => $transfer_request,
           "For_Reissue" => $for_reissue,
       ], 200);

    }
}
