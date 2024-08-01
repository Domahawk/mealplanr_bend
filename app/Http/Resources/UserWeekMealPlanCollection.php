<?php

namespace App\Http\Resources;

use App\Models\Meal;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
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
        $today = Carbon::today();
        $dateRange = CarbonPeriod::create(
            $today->startOfWeek()->format('Y-m-d'),
            $today->endOfWeek()->format('Y-m-d')
        );
        $dateRangeGroup = [];

        $group = $this->collection->mapToGroups(function (UserWeekMealPlanResource $item) {
            return [
                $item['date'] => [
                    'consumed' => $item['consumed'],
                    'mealPlanId' => $item['id'],
                    'date' => $item['date'],
                    'meal' => $item['meal'],
                ]];
        });

        foreach ($dateRange as $date) {
            $dateKey = $date->format('Y-m-d');
            $dateRangeGroup[$dateKey] = $group[$dateKey] ?? [];
        }

        $data = [];

        foreach ($dateRangeGroup as $key => $dailyPlan) {
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
