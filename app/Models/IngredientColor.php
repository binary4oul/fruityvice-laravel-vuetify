<?php

namespace App\Models;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class IngredientColor extends Model
{
    //
    protected $fillable = [
        'id', 'ingredientid', 'colorid'
    ];
}
