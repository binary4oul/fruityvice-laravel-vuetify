<?php

namespace App\Models;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class Ingredient extends Model
{
    //
    protected $fillable = [
        'id', 'name', 'coverage', 'purchaseprice', 'created_by', 'updated_by'
    ];

    public function colors()
    {
        return $this->belongsToMany(Color::class, 'ingredient_color');
    }
    public function patterns()
    {
        return $this->belongsToMany(Pattern::class, 'ingredient_pattern');
    }
    public function systemDetails()
    {
      return $this->hasMany(SystemDetail::class);
    }

}
