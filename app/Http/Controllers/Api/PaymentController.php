<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransferRequest;
use App\Http\Resources\TransactionResource;
use App\Models\User;
use App\Repository\PaymentRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaymentController extends BaseController
{
    public function __construct(
        private PaymentRepositoryInterface $paymentRepository
    )
    {}

    public function transfer(TransferRequest $request): JsonResponse
    {
        \DB::beginTransaction();
        try {
            $data = $request->validated();

            $user = \Auth::user();

            $receiver = User::find($data['receiver_id']);

            if (!$receiver) {
                return $this->notFound("Receiver not found.");
            }

            $transaction = $this->paymentRepository->transfer($data, $user);

            \DB::commit();

            return $this->success("Transfer success.", [
                'sender' => $user->name,
                'receiver' => $receiver->name,
                'note' => $data['note'],
                'transaction' => TransactionResource::make($transaction)->resolve(),
            ]);

        } catch (\Exception $e){
            \DB::rollBack();
            return $this->serverError($e->getMessage());
        }
    }
}
