<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMealRequest;
use App\Http\Requests\UpdateMealRequest;
use App\Http\Resources\MealCollection;
use App\Http\Resources\MealResource;
use App\Models\Meal;
use App\Services\CreateMealService;
use Illuminate\Http\Request;

class MealController extends Controller
{
    public function __construct(
        private readonly CreateMealService $createMealService
    ){}
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): MealCollection
    {
        $requestQuery = $request->query();
        $dbQuery = Meal::query();


        foreach ($requestQuery as $key => $value) {
            if ($key === 'page') {
                continue;
            }

            $dbQuery->where($key, 'like', "%$value%");
        }

        return MealCollection::make($dbQuery->paginate(3));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMealRequest $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'ingredients' => 'required|array',
            'ingredients.*.id' => 'required|exists:ingredients,id',
            'ingredients.*.grams' => 'required|integer',
        ]);

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
    public function update(UpdateMealRequest $request, Meal $meal)
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
