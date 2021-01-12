<?php

namespace App\Models;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class Phone extends Model
{
    //
    protected $fillable = [
        'id', 'person_id', 'number', 'type', 'primary'
    ];
    public function person()
    {
      return $this->belongsTo(Person::class);
    }
}
