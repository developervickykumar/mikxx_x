<?php

namespace App\Services;

use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;

class WalletService
{
    public static function charge($userId, $amount, $purpose, $note = null, $relatedUserId = null, $refId = null)
    {
        $wallet = Wallet::for($userId);

        if ($wallet->balance < $amount) {
            throw new \Exception('Insufficient funds');
        }

        DB::transaction(function () use ($wallet, $amount, $userId, $purpose, $note, $relatedUserId, $refId) {
            $wallet->decrement('balance', $amount);

            WalletTransaction::create([
                'user_id' => $userId,
                'type' => 'debit',
                'purpose' => $purpose,
                'amount' => $amount,
                'related_user_id' => $relatedUserId,
                'reference_id' => $refId,
                'note' => $note
            ]);
        });
    }

    public static function credit($userId, $amount, $purpose, $note = null, $relatedUserId = null, $refId = null)
    {
        $wallet = Wallet::for($userId);

        DB::transaction(function () use ($wallet, $amount, $userId, $purpose, $note, $relatedUserId, $refId) {
            $wallet->increment('balance', $amount);

            WalletTransaction::create([
                'user_id' => $userId,
                'type' => 'credit',
                'purpose' => $purpose,
                'amount' => $amount,
                'related_user_id' => $relatedUserId,
                'reference_id' => $refId,
                'note' => $note
            ]);
        });
    }
}
