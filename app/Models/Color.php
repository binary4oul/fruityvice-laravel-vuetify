<?php

namespace App\Models;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class Color extends Model
{
    //
    protected $fillable = [
        'id', 'name', 'created_by', 'updated_by', 'created_at', 'updated_at'
    ];
}
