<?php

namespace App\Http\Resources;

use App\Models\Meal;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserWeekMealPlanCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $group = $this->collection->mapToGroups(function (UserWeekMealPlanResource $item) {
            return [
                $item['date'] => [
                    'consumed' => $item['consumed'],
                    'mealPlanId' => $item['id'],
                    'date' => $item['date'],
                    'meal' => $item['meal'],
                ]];
        });

        $data = [];

        foreach ($group as $key => $dailyPlan) {
            $data[] = [
                'date' => $key,
                'meals' => collect($dailyPlan)->map(function ($item) {
                    $item['meal'] = MealResource::make($item['meal']);

                    return $item;
                }),
            ];
        }

        return [
            'data' => $data
        ];
    }
}
