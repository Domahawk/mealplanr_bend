<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        return [
            'name' => 'string'
        ];
    }

    private function store(): array
    {
        return [
            'name' => 'required | string | max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed',
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
