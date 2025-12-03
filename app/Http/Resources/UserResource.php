<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\EncryptedValue;
use Illuminate\Support\Facades\Storage;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Fetch all encrypted fields for this user
        $encryptedData = EncryptedValue::where('user_id', $this->id)
            ->pluck('value', 'key'); // key_name => value_encrypted

        // Decrypt safely
        $nrcNumber = $encryptedData->has('nrc_number') ? decrypt($encryptedData['nrc_number']) : null;
        $address = $encryptedData->has('address') ? decrypt($encryptedData['address']) : null;
        $nrcFrontImage = $encryptedData->has('nrc_front_image') ? decrypt($encryptedData['nrc_front_image']) : null;
        $nrcBackImage = $encryptedData->has('nrc_back_image') ? decrypt($encryptedData['nrc_back_image']) : null;

        // If images stored in private disk, generate secure temporary URLs
        $nrcFrontUrl = $nrcFrontImage ? Storage::disk('private')->url($nrcFrontImage) : null;
        $nrcBackUrl = $nrcBackImage ? Storage::disk('private')->url($nrcBackImage) : null;

        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'balance' => $this->balance,
            'is_merchant' => $this->is_merchant,
            'nrc_number' => $nrcNumber,
            'address' => $address,
            'nrc_front_image' => $nrcFrontUrl,
            'nrc_back_image' => $nrcBackUrl,
        ];
    }
}
