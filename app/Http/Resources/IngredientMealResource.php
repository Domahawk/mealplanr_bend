<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IngredientMealResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->ingredient->id,
            'name' => $this->ingredient->name,
            'calories' => $this->calories,
            'caloriesPerHun' => $this->ingredient->calories,
            'grams' => $this->grams,
        ];
    }
}
