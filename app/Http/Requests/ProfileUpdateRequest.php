<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            //'name' => ['required', 'string', 'max:255'],
            'email' => ['required_without:firstName', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'firstName' => ['required_without:email', 'string', 'max:63'],
            'lastName' => ['required_without:email', 'string', 'max:63'],
            'patronymic' => ['nullable', 'string', 'max:63'],
            'city' => ['nullable', 'string', 'max:63'],
            'street-address' => ['nullable', 'string', 'max:255'],
            'telephone' => ['required_without:email', 'string', 'max:15'],
            'about' => ['nullable', 'string', 'max:255'],
            ];
    }
}
