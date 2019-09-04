<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class iirups extends Model
{
    //  fillable in a form
    //  fillable in a form
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    //  fillable in a form
    protected $fillable = [
        'number','article', 'description', 'property_number','unit_of_measure','price','quantity','total_value','date','accountable_officer','remarks','account_name','service'
    ];
}
