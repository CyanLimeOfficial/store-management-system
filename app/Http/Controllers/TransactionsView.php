<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\StoreInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionsView extends Controller
{
    /**
     * Display the main transactions view page.
     */
    public function index()
    {
        $store = StoreInfo::where('user_id', auth()->id())->first();
        return view('dashboard.transactions', compact('store'));
    }

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
            ->with('store') // Eager load store to get the name efficiently
            ->latest() // Order by the newest transactions first
            ->get();

        // We manually format the data to include the store name for the table
        $formattedTransactions = $transactions->map(function ($transaction) {
            return [
                'id'                => $transaction->id,
                'store_name'        => optional($transaction->store)->store_name,
                'orig_price'        => $transaction->orig_price,
                'transaction_class' => $transaction->transaction_class,
                'created_at'        => $transaction->created_at->toDateTimeString(),
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

        // Security check: ensure the requested transaction belongs to the user's store
        if (!$store || $transaction->costumer_store_id !== $store->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Eager load all necessary relationships for the detail view
        $transaction->load(['store', 'items.product']);

        return response()->json($transaction);
    }
}