<?php

namespace App\Models;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class ProjectDetailStyle extends Model
{
    //
    public function projectDetail()
    {
      return $this->belongsTo(ProjectDetail::class);
    }
}
