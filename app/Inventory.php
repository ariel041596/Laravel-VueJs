<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    //  fillable in a form
    protected $fillable = [
        'number','article', 'description', 'property_number','unit_of_measure','price','quantity','total_value','date','accountable_officer','remarks','account_name','service'
    ];
}
