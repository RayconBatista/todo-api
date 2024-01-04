<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class AuthRegisterRequest extends FormRequest
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
     * @return array<string, Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'first_name'    => ['required', 'string'],
            'last_name'     => ['required', 'string'],
            'email'         => ['required', 'email'],
            'password'      => ['required', 'string', 'min:8', 'max:30', $this->validationPassword()]
        ];
    }

    // The regex provided appears to be used to validate passwords and has the following requirements:
    private function validationPassword()
    {
        // At least one capital letter ((?=.*[A-Z])).
        // At least one lowercase letter ((?=.*[a-z])).
        // At least one digit ((?=.*\d)).
        return 'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).+$/';
    }
}
