<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserCustomerListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->customer->first_name,
            'last_name' => $this->customer->last_name,
            // 'email' => $this->email,
            // 'phone' => $this->customer->phone,
        ];
    }
}
