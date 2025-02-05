<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
        return [
            'firstname' => 'required|string',
            'middlename' => 'sometimes|required|string',
            'lastname' => 'required|string',
            'suffix' => 'nullable|string',
            'email' => 'required|email|unique:students,email,'.$this->id,
            'contact_no' => 'required|string',
            'sex' => 'required|string',
            'id_number' => 'required|max:20|unique:students,id_number,'.$this->id,
            'password' => 'sometimes|required|confirmed|min:6',
        ];
    }
}
