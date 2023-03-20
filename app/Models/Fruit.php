<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasOne;

class Fruit extends Model
{
    // use HasFactory;
    protected $fillable = [
        "genus",
        "name",
        "id",
        "family",
        "order",
        // "nutritions"
    ];

    public function nutritions(): HasOne
    {
        return $this->hasOne(Nutrition::class);
    }
}
