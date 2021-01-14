<?php

namespace App\Models;
use App\User;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class TeamMember extends Model
{
    //
  public function team()
  {
    return $this->belongsTo(Team::class);
  }
  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
