<?php

namespace App\Models;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class Person extends Model
{
    //
    protected $table = 'person';
    protected $fillable = [
        'firstname', 'lastname', 'company'
    ];
}
