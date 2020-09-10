<?php

namespace App\Models;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class System extends Model
{
    //
    protected $fillable = [
        'id', 'name', 'saleprice','active', 'share', 'created_by', 'updated_by'
    ];
}
