<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    //  fillable in a form
    protected $fillable = [
        'number', //1
        'article', //2
        'description', //3 
        'property_number', //4
        'unit_of_measure', //5
        'price', //6
        'quantity', //7
        'total_value', //8
        'date', //9
        'accountable_officer', //10
        'remarks', //11
        'account_name', //12
        'service', //13
        'createdBy', //14
        'status', //15
        'property_type',//16
        'received_from', //17
    ];
   

    
}
