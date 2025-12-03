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
        return [
            'user_id' => $this->resource->user_id,
            'type' => $this->resource->type,
            'amount' => $this->resource->amount,
            'reference_no' => $this->resource->reference_no,
            'related_id' => $this->resource->related_id,
            'status' => $this->resource->status,
        ];
    }
}
