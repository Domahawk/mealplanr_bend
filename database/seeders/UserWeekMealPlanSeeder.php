<?php

namespace Database\Seeders;

use App\Models\Meal;
use App\Models\User;
use App\Models\UserWeekMealPlan;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UserWeekMealPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::find(1);
        $meals = Meal::all();
        $dates = collect();
        $i = 0;

        while ($i < 14) {
            $dates->push(Carbon::create(now("UTC"))->addDay($i));
            $i++;
        }

        $dates->each(function ($date) use ($user, $meals) {
            UserWeekMealPlan::factory(3)->create([
                'user_id' => $user->id,
                'meal_id' => $meals->random()->id,
                'date' => $date->format('Y-m-d'),
                'consumed' => false
            ]);
        });
    }
}
