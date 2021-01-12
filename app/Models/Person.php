<?php

namespace App\Models;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class Person extends Model
{
    //
  protected $table = 'person';
  public function project()
  {
    return $this->belongsTo(Project::class);
  }
  public function phones()
  {
    return $this->hasMany(Phone::class);
  }
  public function addresses()
  {
    return $this->hasMany(Address::class);
  }
}
