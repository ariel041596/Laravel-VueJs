<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestAsset extends Model
{
    //  fillable in a form
    protected $fillable = [
        'entity_name', //1
        'service', //2
        'request_number', //3
        'unit_of_measure', //4
        'description', //5
        'quantity', //6
        'status', //7
        'remarks', //8
        'purpose', //9
        'accountable_officer', //10
        'issued_by', //11
        'received_by', //12
        'createdBy', //13
    ];
}
