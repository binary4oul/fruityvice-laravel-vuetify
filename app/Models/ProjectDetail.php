<?php

namespace App\Models;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class ProjectDetail extends Model
{
    //
  public function project()
  {
    return $this->belongsTo(Project::class);
  }
  public function projectDetailStyles()
  {
    return $this->hasMany(projectDetailStyle::class);
  }
}
