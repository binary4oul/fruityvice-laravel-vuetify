<?php

namespace App\Models;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class Pattern extends Model
{
    //
    protected $fillable = [
        'id', 'name', 'created_by', 'updated_by', 'created_at', 'updated_at'
    ];
    public function ingredients()
    {
      return $this->belongsToMany(Ingredient::class, 'ingredient_pattern');
    }
}
