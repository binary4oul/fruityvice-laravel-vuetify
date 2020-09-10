<?php

namespace App\Models;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class Person extends Model
{
    //
    protected $table = 'person';
    protected $fillable = [
        'id', 'firstname', 'lastname', 'company', 'created_by', 'updated_by'
    ];
}
