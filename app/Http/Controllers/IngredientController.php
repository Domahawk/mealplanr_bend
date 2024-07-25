<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIngredientRequest;
use App\Http\Requests\UpdateIngredientRequest;
use App\Http\Resources\IngredientResource;
use App\Models\Ingredient;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Validation\Rules\In;

class IngredientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $requestQuery = $request->query();
        $dbQuery = Ingredient::query();

        foreach ($requestQuery as $key => $value) {
            if ($key === 'page') {
                continue;
            }

            $dbQuery->where($key, 'like', "%$value%");
        }


        return IngredientResource::collection($dbQuery->paginate(3));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreIngredientRequest $request)
    {
        $valideted = $request->validate([
            'name' => 'required|string|max:255',
            'calories' => 'required|numeric',
        ]);

        $ingredient = Ingredient::create($valideted);

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
    public function update(UpdateIngredientRequest $request, Ingredient $ingredient)
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
