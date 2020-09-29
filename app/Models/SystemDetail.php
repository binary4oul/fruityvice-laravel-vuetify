<?php

namespace App\Models;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class SystemDetail extends Model
{
    //
    protected $fillable = [
        'id', 'systemid', 'ingredientid', 'purchaseprice', 'factor'
    ];
}
