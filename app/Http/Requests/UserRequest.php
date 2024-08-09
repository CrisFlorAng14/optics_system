<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule;
use Carbon\Carbon;

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $currentYear = Carbon::now()->year;
        $minYear = $currentYear - 100;
        
        return [
			'name' => 'required|string|max:50',
			'first_lastname' => 'required|string|max:50',
			'second_lastname' => 'nullable|string|max:50',
			'day' => 'required|integer|between:1,31',
            'month' => 'required|integer|between:1,12',
            'year' => 'required|integer|between:' . $minYear . ',' . $currentYear,
			'phone' => 'required|string|max:15',
			'photo' => 'nullable|string',
			'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($this->route('id')),
            ],
        ];
    }
}
