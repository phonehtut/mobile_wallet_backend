<?php

namespace App\Repository;

use App\Models\Transaction;
use App\Models\Transfer;
use App\Models\User;

class PaymentRepository implements PaymentRepositoryInterface
{
    public function transfer(array $data, User $user): Transaction
    {
        $receiver = User::find($data['receiver_id']);
        if (!$receiver) {
            throw new \Exception("Receiver not found.");
        }

        if ($user->balance < $data['amount']) {
            throw new \Exception("Insufficient balance.");
        }

        $transferData = Transfer::create([
            'sender_id' => $user->id,
            'receiver_id' => $receiver->id,
            'amount' => $data['amount'],
            'note' => $data['note'],
        ]);

        $transaction = Transaction::create([
            'user_id' => $transferData->sender_id,
            'type' => "transfer",
            'amount' => $transferData->amount,
            'reference_no' => bin2hex(random_bytes(16)),
            'related_id' => $transferData->id,
            'status' => "pending",
        ]);

        // Update balances
        $user->balance -= $data['amount'];
        $user->save();

        $receiver->balance += $data['amount'];
        $receiver->save();

        // Mark transaction as success
        $transaction->status = "success";
        $transaction->save();

        return $transaction;
    }

}
