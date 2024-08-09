<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserWeekMealPlanRequest;
use App\Http\Resources\UserWeekMealPlanCollection;
use App\Models\User;
use App\Models\UserWeekMealPlan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class UserWeekMealPlanController extends Controller
{
    public function index(): UserWeekMealPlanCollection
    {
        /** @var User $user */
        $user = Auth::user();
        $today = Carbon::today('GMT+2');
        $startDate = $today->startOfWeek()->format('Y-m-d');
        $endDate = $today->endOfWeek()->format('Y-m-d');

        return UserWeekMealPlanCollection::make(
            UserWeekMealPlan::where(
                'user_id',
                $user->id
            )->whereBetween(
                'date',
                [$startDate, $endDate]
            )->with([
                'meal.ingredientMeal',
                'user'
            ])->orderBy(
                'date'
            )->get());
    }

    public function store(UserWeekMealPlanRequest $request)
    {
        $validated = $request->validated();

        /** @var User $user */
        $user = Auth::user();
        $meals = collect();

        foreach ($validated['meals'] as $mealId) {
            $meals->push(
                UserWeekMealPlan::create([
                    'meal_id' => $mealId,
                    'date' => $validated['date'],
                    'consumed' => false,
                    'user_id' => $user->id,
                ])
            );
        }

        $meals->each(fn (UserWeekMealPlan $meal) => $meal->save());

        return [
            'message' => 'Meals added successfully',
        ];
    }

    public function show(UserWeekMealPlan $userWeekMealPlan)
    {
        //
    }

    public function update(UserWeekMealPlanRequest $request, UserWeekMealPlan $userWeekMealPlan)
    {
        $validated = $request->validated();

        foreach ($validated as $key => $value) {
            $userWeekMealPlan->{$key} = $value;
        }

        $userWeekMealPlan->save();

        return [
            'message' => 'User Week Meal Plan updated successfully.',
        ];
    }

    public function destroy(UserWeekMealPlan $userWeekMealPlan)
    {
        $userWeekMealPlan->delete();

        return [
            'message' => 'User Week Meal Plan deleted successfully.',
        ];
    }
}
