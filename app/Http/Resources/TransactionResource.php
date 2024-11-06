<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'code' => $this->code,
            'type' => $this->type,
            'status' => $this->status,
            'student' => $this->user->student,
            'is_express' => $this->is_express,
            'lists' => $this->lists,
            'payment' => $this->payment,
            'attachments' => $this->attachments,
            'created_at' => $this->created_at
        ];
    }
}
