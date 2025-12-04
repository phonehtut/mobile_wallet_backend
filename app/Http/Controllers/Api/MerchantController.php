<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MerchantSubmitRequest;
use App\Http\Resources\MerchantResource;
use App\Repository\MerchantRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;

class MerchantController extends BaseController
{
    public function __construct(
        private readonly MerchantRepositoryInterface $merchantRepository
    ){}

    public function submit(MerchantSubmitRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();

            $user = \Auth::user();

            $data['user_id'] = $user->id;

            $merchant = $this->merchantRepository->create($data, $request);

            $user->is_merchant = true;
            $user->save();

            return $this->success('Merchant submitted successfully.', ['merchant' => MerchantResource::make($merchant)]);
        } catch (\Exception $e){
            return $this->serverError($e->getMessage());
        }
    }
}
