<?php

namespace App\Models;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class Project extends Model
{
    //
    public function projectDetails()
    {
      return $this->hasMany(ProjectDetail::class);
    }
    public function person()
    {
      return $this->hasOne(Person::class);
    }
}
