<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use App\Models\Meal;
use Illuminate\Database\Seeder;

class IngredientMealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $meals = Meal::all();
        $ingredients = Ingredient::all();

        foreach ($meals as $meal) {
            $ingredientsOfMeal = $ingredients->random(3, true);

            foreach ($ingredientsOfMeal as $ingredient) {
                $grams = rand(1, 1000);
                $calories = ($ingredient->calories / 100) * $grams;

                $meal->ingredients()->attach($ingredient->id, ['grams' => $grams, 'calories' => $calories]);
            }
        }
    }
}
