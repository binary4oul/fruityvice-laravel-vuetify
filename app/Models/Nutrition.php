<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nutrition extends Model
{
    protected $table = "nutritions";
    protected $fillable = ["carbohydrates",
        "protein",
        "fat",
        "calories",
        "sugar"
    ];
    //
}
