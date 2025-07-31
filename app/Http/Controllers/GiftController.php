<?php

    namespace App\Http\Controllers;
    
    use App\Models\Form;
    use Illuminate\Http\Request; 
    use App\Models\Category; 
    use App\Models\GiftTransaction;
    use App\Services\WalletService;


    class GiftController extends Controller
    {
        
        public function send(Request $request)
        {
            $request->validate([
                'receiver_id' => 'required|exists:users,id',
                'gift_category_id' => 'required|exists:categories,id',
                'post_id' => 'nullable|exists:posts,id'
            ]);
        
            $gift = Category::findOrFail($request->gift_category_id);
            $sender = auth()->user();
            $receiverId = $request->receiver_id;
            $postId = $request->post_id;
            $price = $gift->price_list['value'] ?? 0;
        
            try {
                // Use WalletService to deduct and record the transaction
                WalletService::charge(
                    $sender->id,
                    $price,
                    'gift',
                    'Sent gift to user #' . $receiverId,
                    $receiverId,
                    $postId
                );
        
                // Record gift transaction
                GiftTransaction::create([
                    'sender_id' => $sender->id,
                    'receiver_id' => $receiverId,
                    'post_id' => $postId,
                    'gift_category_id' => $gift->id,
                    'price' => $price,
                ]);
        
                return response()->json(['success' => true]);
        
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage() ?: 'Something went wrong.'
                ], 422);
            }
        }

        public function convertGiftToCoins($userId, $giftCategoryId, $quantity)
        {
            $gift = Category::findOrFail($giftCategoryId);
            $userGift = UserGift::where('user_id', $userId)
                ->where('gift_category_id', $giftCategoryId)->first();
        
            if (!$userGift || $userGift->quantity < $quantity) {
                throw new \Exception("Not enough gifts to convert.");
            }
        
            $conversionRate = $gift->price_list['conversion_rate'] ?? 0;
            $value = $gift->price_list['value'] ?? 0;
            $totalCoins = $value * $quantity * $conversionRate;
        
            DB::transaction(function () use ($userGift, $quantity, $userId, $totalCoins) {
                $userGift->decrement('quantity', $quantity);
                WalletService::credit($userId, $totalCoins, 'gift_conversion', 'Converted gifts to coins');
            });
        
            return $totalCoins;
        }


    }