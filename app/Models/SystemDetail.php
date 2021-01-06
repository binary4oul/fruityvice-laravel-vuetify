<?php

namespace App\Models;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class SystemDetail extends Model
{
  public function ingredient()
  {
    return $this->belongsTo(Ingredient::class);
  }
  public function system()
  {
    return $this->belongsTo(System::class);
  }
}
