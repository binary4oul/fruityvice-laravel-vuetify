<?php

namespace App\Models;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class Team extends Model
{
    //
    public function teamMembers()
    {
      return $this->hasMany(TeamMember::class);
    }
}
