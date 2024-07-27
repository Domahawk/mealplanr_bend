<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserWeekMealPlanRequest;
use App\Http\Requests\UpdateUserWeekMealPlanRequest;
use App\Http\Resources\UserWeekMealPlanCollection;
use App\Models\User;
use App\Models\UserWeekMealPlan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class UserWeekMealPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): UserWeekMealPlanCollection
    {
        /** @var User $user */
        $user = Auth::user();
        // Carbon->weekday counts from Sunday (0) to Saturday (6)
        // We get current day (0-6)
        // To start counting from Monday to Sunday we subtract 1 from weekday
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserWeekMealPlanRequest $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'meals' => 'required|array',
            'meals.*' => 'required|exists:meals,id',
        ]);

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

    /**
     * Display the specified resource.
     */
    public function show(UserWeekMealPlan $userWeekMealPlan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserWeekMealPlanRequest $request, UserWeekMealPlan $userWeekMealPlan)
    {
        $validated = $request->validate([
            'consumed' => 'boolean',
            'meal_id' => 'exists:meals,id',
            'user_id' => 'prohibited',
        ]);

        foreach ($validated as $key => $value) {
            $userWeekMealPlan->{$key} = $value;
        }

        $userWeekMealPlan->save();

        return [
            'message' => 'User Week Meal Plan updated successfully.',
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserWeekMealPlan $userWeekMealPlan)
    {
        $userWeekMealPlan->delete();

        return [
            'message' => 'User Week Meal Plan deleted successfully.',
        ];
    }
}
