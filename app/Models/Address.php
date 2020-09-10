<?php

namespace App\Models;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class Address extends Model
{
    //
    protected $fillable = [
        'id', 'personid', 'address1', 'address2', 'city', 'state', 'type', 'zip', 'primary'
    ];
}
