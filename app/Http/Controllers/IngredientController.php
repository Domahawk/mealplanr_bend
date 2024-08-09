<?php

namespace App\Http\Controllers;

use App\Http\Requests\IngredientRequest;
use App\Http\Resources\IngredientResource;
use App\Models\Ingredient;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class IngredientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IngredientRequest $request): AnonymousResourceCollection
    {
        $validated = $request->validated();
        $dbQuery = Ingredient::query();

        foreach ($validated as $key => $value) {
            $dbQuery->where($key, 'like', "%$value%");
        }

        return IngredientResource::collection($dbQuery->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(IngredientRequest $request)
    {
        $validated = $request->validated();
        $ingredient = Ingredient::create($validated);

        return IngredientResource::make($ingredient);
    }

    /**
     * Display the specified resource.
     */
    public function show(Ingredient $ingredient): IngredientResource
    {
        return IngredientResource::make($ingredient);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(IngredientRequest $request, Ingredient $ingredient)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ingredient $ingredient)
    {
        //
    }
}
