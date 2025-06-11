<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\StoreInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionsView extends Controller
{
    /**
     * Provide a list of transactions for the DataTable,
     * filtered for the authenticated user's store.
     */
    public function list()
    {
        // Find the store associated with the logged-in user
        $store = StoreInfo::where('user_id', Auth::id())->first();

        // If no store is found, return an empty dataset
        if (!$store) {
            return response()->json(['data' => []]);
        }

        // Fetch transactions belonging only to this store and eager load the relationship
        $transactions = Transaction::where('costumer_store_id', $store->id)
            ->with('store') 
            ->latest() 
            ->get();

    
        $formattedTransactions = $transactions->map(function ($transaction) {
            return [
                'id'                  => $transaction->id,
                'store_name'          => optional($transaction->store)->store_name,
                'orig_price'          => $transaction->orig_price,
                'transaction_class'   => $transaction->transaction_class,
                'created_at'          => $transaction->created_at->toDateTimeString(),
            ];
        });

        return response()->json(['data' => $formattedTransactions]);
    }

    /**
     * Show the details for a single transaction.
     * Includes a check to ensure the requested transaction belongs to the user's store.
     */
    public function show(Transaction $transaction)
    {
        $store = StoreInfo::where('user_id', Auth::id())->first();
        $userId = Auth::id();

        if (!$store || $transaction->costumer_store_id !== $store->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $transaction->load(['store', 'items.product']);

        try {
            $responseData = [
                'id' => $transaction->id,
                'costumer_store_id' => $transaction->costumer_store_id,
                'orig_price' => $transaction->orig_price,
                'orig_change' => $transaction->orig_change,
                'transaction_class' => $transaction->transaction_class,
                'created_at' => $transaction->created_at->toIso8601String(),
                'updated_at' => $transaction->updated_at->toIso8601String(),
                
                'store' => $transaction->store ? [
                    'id' => $transaction->store->id,
                    'store_name' => mb_convert_encoding($transaction->store->store_name, 'UTF-8', 'UTF-8'),
                ] : null,

                'items' => $transaction->items->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'quantity' => $item->quantity,
                        'price' => $item->price,
                        'product' => $item->product ? [
                            'id' => $item->product->id,
                            'product_name' => mb_convert_encoding($item->product->product_name, 'UTF-8', 'UTF-8'),
                            'category' => mb_convert_encoding($item->product->category, 'UTF-8', 'UTF-8'),
                            'price' => $item->product->price,
                        ] : null,
                    ];
                }),
            ];

            return response()->json($responseData);

        } catch (\Exception $e) {
            // Return a generic error to the frontend
            return response()->json(['error' => 'An internal error occurred while processing transaction details.'], 500);
        }
    }
}