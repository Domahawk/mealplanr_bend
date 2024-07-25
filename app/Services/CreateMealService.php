<?php

namespace App\Services;

use App\Models\Ingredient;
use App\Models\Meal;

class CreateMealService
{
    public function createMeals(array $data): Meal
    {
        return $this->createSingleMeal($data['name'], $data['ingredients']);
    }

    private function createSingleMeal(string $name, array $ingredients): Meal
    {
        $meal = Meal::create(['name' => $name]);
        $ingredientObjects = Ingredient::find(collect($ingredients)->pluck('id')->toArray());
        $saveData = collect($ingredients)->mapWithKeys(function (array $ingredient) {
            return [$ingredient['id'] => [
                'grams' => $ingredient['grams'],
            ]];
        })->toArray();

        foreach ($ingredientObjects as $ingredient) {
            $saveData[$ingredient->id]['calories'] = $this->calculateCalories(
                $ingredient,
                $saveData[$ingredient->id]['grams']
            );
        }

        $meal->ingredients()->attach($saveData);

        return $meal->load('ingredients');
    }

    private function calculateCalories(Ingredient $ingredient, int $grams): int
    {
        $ingredientCalories = $ingredient->calories;

        return round($ingredientCalories * ($grams / 100));
    }
}
