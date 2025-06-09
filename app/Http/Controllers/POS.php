<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\StoreInfo;
use App\Models\Product_Inventory;

class POS extends Controller
{
    public function store(Request $request)
    {
        // 1. ADD VALIDATION FOR THE NEW FIELD
        $request->validate([
            'orig_price'        => 'required|numeric|min:0',
            'orig_change'       => 'required|numeric|min:0',
            'transaction_class' => ['required', Rule::in(['purchase', 'debt'])],
            'items'             => 'required|array|min:1',
            'items.*.id'        => 'required|integer|exists:products_inventory,id',
            'items.*.quantity'  => 'required|integer|min:1',
            'items.*.price'     => 'required|numeric|min:0',
        ]);

        try {
            // 2. GET AUTHENTICATED USER'S STORE
            $user = Auth::user();
            $storeInfo = StoreInfo::where('user_id', $user->id)->firstOrFail();

            // 3. USE A DATABASE TRANSACTION
            $transaction = DB::transaction(function () use ($request, $storeInfo) {
                
                // 4. ADD THE NEW FIELD TO THE CREATE() METHOD
                $newTransaction = Transaction::create([
                    'costumer_store_id' => $storeInfo->id,
                    'orig_price'        => $request->orig_price,
                    'orig_change'       => $request->orig_change,
                    'transaction_class' => $request->transaction_class,
                ]);

                // Create each transaction item and update product stock
                foreach ($request->items as $item) {
                    TransactionItem::create([
                        'transaction_id' => $newTransaction->id,
                        'product_id'     => $item['id'],
                        'quantity'       => $item['quantity'],
                        'price'          => $item['price'],
                    ]);
                    
                    $product = Product_Inventory::find($item['id']);
                    if ($product) {
                        $product->decrement('quantity', $item['quantity']);
                    }
                }

                return $newTransaction;
            });
            
            // 5. RETURN A SUCCESS RESPONSE
            return response()->json([
                'message'        => 'Transaction completed successfully!',
                'transaction_id' => 'TRX-' . $transaction->id
            ], 201);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'User store not found.'], 404);
        } catch (\Exception $e) {
            \Log::error('Transaction failed: ' . $e->getMessage());
            return response()->json(['message' => 'Transaction could not be processed.'], 500);
        }
    }
}