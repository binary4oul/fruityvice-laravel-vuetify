<?php

namespace App\Models;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class IngredientPattern extends Model
{
    //
    protected $fillable = [
        'id', 'ingredientid', 'patternid'
    ];
}
