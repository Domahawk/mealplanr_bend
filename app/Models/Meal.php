<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Meal extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(
            Ingredient::class,
            'ingredient_meal',
            'meal_id',
            'ingredient_id'
        )->withPivot('calories', 'grams');
    }

    public function ingredientMeal(): HasMany
    {
        return $this->hasMany(IngredientMeal::class, 'meal_id', 'id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_week_meal_plans', 'meal_id', 'user_id');
    }
}
