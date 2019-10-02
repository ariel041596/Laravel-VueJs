<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticleCategory extends Model
{
    //  fillable in a form
    protected $fillable = [
        'article','account_name','account_code',
    ];
}
