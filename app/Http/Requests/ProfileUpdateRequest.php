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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'phone' => ['nullable','string','max:50'],
            'dob' => ['nullable','date'],
            'sport' => ['nullable','in:basketball,volleyball'],
            'position' => ['nullable','string','max:255'],
            'height' => ['nullable','numeric','min:0','max:400'],
            'weight' => ['nullable','numeric','min:0','max:1000'],
            'experience' => ['nullable','integer','min:0','max:100'],
            'emergency_contact' => ['nullable','string','max:255'],
            'jersey_number' => ['nullable','integer','min:0','max:9999'],
            'profile_photo' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
        ];
    }
}
