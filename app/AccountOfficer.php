<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountOfficer extends Model
{
      //  fillable in a form
      protected $fillable = [
        'name','designation','service',
    ];
}
