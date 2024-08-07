<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MealRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
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
        return [
            'name' => 'string'
        ];
    }

    private function store(): array
    {
        return [
            'name' => 'required|string',
            'ingredients' => 'required|array',
            'ingredients.*.id' => 'required|exists:ingredients,id',
            'ingredients.*.grams' => 'required|integer',
        ];
    }

    private function update(): array
    {
        return [];
    }

    private function destroy(): array
    {
        return [];
    }
}
