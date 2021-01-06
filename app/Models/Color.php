<?php

namespace App\Models;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class Color extends Model
{
    //
  public function ingredients()
  {
    return $this->belongsToMany(Ingredient::class, 'ingredient_color');
  }

}
