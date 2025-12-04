<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MerchantResource extends JsonResource
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
            'shop_name' => $this->resource->shop_name,
            'shop_url' => $this->resource->shop_url,
            'shop_logo' => $this->resource->shop_logo,
            'category' => $this->resource->category,
            'address' => $this->resource->address,
            'qr_code' => $this->resource->qr_code,
        ];
    }
}
