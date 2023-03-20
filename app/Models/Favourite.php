<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    protected $table = "favourites";
    protected $fillable = ["user_id", "fruit_id", "is_fav"];
    //
}
