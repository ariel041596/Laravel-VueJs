<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountCode extends Model
{
    ///  fillable in a form
    protected $fillable = [
        'account_name'
    ];
}
