<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Domagoj Bišćan',
            'email' => 'podjedankod2@gmail.com',
        ]);

        $this->call([
            IngredientSeeder::class,
            MealSeeder::class,
            IngredientMealSeeder::class,
            UserWeekMealPlanSeeder::class,
        ]);
    }
}
