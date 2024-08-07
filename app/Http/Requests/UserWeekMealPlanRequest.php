<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UserWeekMealPlanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return match ($this->method()) {
            'POST' => $this->store(),
            'PUT' => $this->update(),
            'DELETE' => $this->destroy(),
            default => $this->index()
        };
    }

    private function index(): array
    {
        return [];
    }

    private function store(): array
    {
        return [
            'date' => 'required|date',
            'meals' => 'required|array',
            'meals.*' => 'required|exists:meals,id',
        ];
    }

    private function update(): array
    {
        return [
            'consumed' => 'boolean',
            'meal_id' => 'exists:meals,id',
            'user_id' => 'prohibited',
        ];
    }

    private function destroy(): array
    {
        return [];
    }
}
