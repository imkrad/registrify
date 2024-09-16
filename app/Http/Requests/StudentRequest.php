<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'firstname' => 'required|string',
            'middlename' => 'required|string',
            'lastname' => 'required|string',
            'suffix' => 'nullable|string',
            'email' => 'required|email|unique:students,email,'.$this->id,
            'contact_no' => 'required|string',
            'sex' => 'required|string',
            'id_number' => 'required|max:20|unique:students,id_number,'.$this->id,
        ];
    }
}
