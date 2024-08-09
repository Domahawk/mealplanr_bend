<?php

namespace App\Http\Controllers;

use App\Http\Requests\MealRequest;
use App\Http\Resources\MealCollection;
use App\Http\Resources\MealResource;
use App\Models\Meal;
use App\Services\CreateMealService;

class MealController extends Controller
{
    public function __construct(
        private readonly CreateMealService $createMealService
    ){}
    /**
     * Display a listing of the resource.
     */
    public function index(MealRequest $request): MealCollection
    {
        $validated = $request->validated();
        $dbQuery = Meal::query();

        foreach ($validated as $key => $value) {
            $dbQuery->where($key, 'like', "%$value%");
        }

        return MealCollection::make($dbQuery->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MealRequest $request)
    {
        $validated = $request->validated();

        return $this->createMealService->createMeals($validated);
    }

    /**
     * Display the specified resource.
     */
    public function show(Meal $meal): MealResource
    {
        return MealResource::make($meal);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MealRequest $request, Meal $meal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Meal $meal)
    {
        //
    }
}
