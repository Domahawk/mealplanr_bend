<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'calories',
    ];

    public function meals(): BelongsToMany
    {
        return $this->belongsToMany(Meal::class, 'ingredient_meal', 'ingredient_id', 'meal_id');
    }
}
