<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DocumentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'name_id' => $this->name_id,
            'type_id' => $this->type_id,
            'name' => $this->name->name,
            'type' => $this->type->name,
            'is_perpage' => $this->is_perpage,
            'fees' => $this->fees,
            'addons' => $this->addons
        ];
    }
}
