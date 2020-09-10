<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemDetail extends Model
{
    //
    protected $fillable = [
        'id', 'systemid', 'ingredientid', 'price', 'factor', 'extra'
    ];
}
