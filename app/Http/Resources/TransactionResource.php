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
            'name' => $this->user->student->lastname.', '.$this->user->student->firstname.' '.$this->user->student->middlename.'.',
            'is_express' => $this->is_express,
            'lists' => $this->lists,
            'payment' => $this->payment,
            'comments' => $this->comments,
            'log' => $this->log,
            'attachments' => $this->attachments,
            'authorization' => $this->authorization,
            'purpose' => $this->purpose,
            'due_at' => $this->due_at,
            'claimed_at' => $this->claimed_at,
            'created_at' => $this->created_at
        ];
    }
}
