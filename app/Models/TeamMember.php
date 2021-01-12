<?php

namespace App\Models;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class TeamMember extends Model
{
    //
  public function system()
  {
    return $this->belongsTo(Team::class);
  }
}
