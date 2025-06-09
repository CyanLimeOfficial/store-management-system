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
    /**
     * Store a newly created transaction in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // 1. VALIDATE THE INCOMING DATA
        $request->validate([
            'orig_price'        => 'required|numeric|min:0',
            'transaction_class' => ['required', Rule::in(['purchase', 'debt'])],
            'items'             => 'required|array|min:1',
            'items.*.id'        => 'required|integer|exists:products_inventory,id', // Make sure this matches your products table name
            'items.*.quantity'  => 'required|integer|min:1',
            'items.*.price'     => 'required|numeric|min:0',
        ]);

        try {
            // 2. GET AUTHENTICATED USER'S STORE
            $user = Auth::user();
            $storeInfo = StoreInfo::where('user_id', $user->id)->firstOrFail();

            // 3. USE A DATABASE TRANSACTION
            $transaction = DB::transaction(function () use ($request, $storeInfo) {
                
                // Create the main transaction record
                $newTransaction = Transaction::create([
                    'costumer_store_id' => $storeInfo->id,
                    'orig_price'        => $request->orig_price,
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
                    
                    // (Optional but Recommended) Decrement stock from inventory
                    $product = Product_Inventory::find($item['id']);
                    if ($product) {
                        $product->decrement('quantity', $item['quantity']);
                    }
                }

                return $newTransaction;
            });
            
            // 4. RETURN A SUCCESS RESPONSE
            return response()->json([
                'message'        => 'Transaction completed successfully!',
                'transaction_id' => 'TRX-' . $transaction->id // Return a formatted ID for the receipt
            ], 201); // 201 Created

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'User store not found.'], 404);
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Transaction failed: ' . $e->getMessage());
            // Return a generic error message
            return response()->json(['message' => 'Transaction could not be processed.'], 500);
        }
    }
}