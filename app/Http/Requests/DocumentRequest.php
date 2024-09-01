<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {   
        if($this->option == 'addon'){
            return [];
        }else{
            return [
                'name_id' => 'required|integer',
                'type_id' => 'required|integer',
                'is_perpage' => 'required'
            ];
        }
    }
}
