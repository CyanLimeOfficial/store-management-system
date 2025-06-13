<?php

namespace App\Http\Controllers;

use App\Models\StoreInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product_Inventory;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Support\Facades\DB;

class Home extends Controller
{
    /**
     * ADD THIS METHOD
     *
     * This will handle the initial page load for your dashboard,
     * fetch all the data, and pass it to the view.
     */
    public function index()
    {
        // Get all the dashboard data from your helper function
        $data = $this->getDashboardData();

        // Pass the data to your dashboard view
        return view('dashboard.index', $data);
    }

    public function DebtsList()
    {
        $store = StoreInfo::where('user_id', Auth::id())->first();
        if (!$store) {
            return response()->json([]);
        }

        // 1. Fetch recent transactions and eager-load all necessary related data
        $transactions = Transaction::with(['store', 'items.product'])
            ->where('costumer_store_id', $store->id)
            ->where('transaction_class', 'debt')
            ->latest()
            ->take(10) // Limit to 10 transactions to keep the modal from getting too long
            ->get();

        // 2. Format the response. This is the crucial part.
        $formattedTransactions = $transactions->map(function ($transaction) {
            return [
                'id' => $transaction->id,
                'customer_name' => optional($transaction->store)->store_name ? mb_convert_encoding(optional($transaction->store)->store_name, 'UTF-8', 'UTF-8') : 'N/A',
                'total_amount' => $transaction->orig_price,
                'transaction_date' => $transaction->created_at->toDateTimeString(),
                
                // 3. Create a nested array of items for this specific transaction
                'items' => $transaction->items->map(function ($item) {
                    return [
                        'quantity' => $item->quantity,
                        'product_name' => optional($item->product)->product_name ? mb_convert_encoding(optional($item->product)->product_name, 'UTF-8', 'UTF-8') : 'Product Deleted',
                    ];
                })
            ];
        });

        return response()->json(['data' => $formattedTransactions]);
    }

    /**
     * This method is for your AJAX auto-refresh and is already correct.
     */
    public function data()
    {
        // Return data as JSON
        return response()->json($this->getDashboardData());
    }

    public function updateStoreName(Request $request)
    {
        // ... this method is fine, no changes needed
    }

    /**
     * This helper function is already correct.
     */
    private function getDashboardData()
    {
        // Calculate total amounts for purchase and debt transactions
        $purchaseTotal = Transaction::where('transaction_class', 'purchase')->sum('orig_price');
        $debtTotal = Transaction::where('transaction_class', 'debt')->sum('orig_price');

        // Total Earning is the sum of all transactions
        $totalEarning = $purchaseTotal + $debtTotal;

        // Get counts for the report cards
        $debtCount = Transaction::where('transaction_class', 'debt')->count();
        $purchaseCount = Transaction::where('transaction_class', 'purchase')->count();
        $transactionCount = $debtCount + $purchaseCount;

        // Get total product quantity from inventory
        $totalQuantity = Product_Inventory::sum('quantity');

        return [
            'totalEarning' => $totalEarning,
            'purchaseTotal' => $purchaseTotal,
            'debtTotal' => $debtTotal,
            'debtCount' => $debtCount,
            'purchaseCount' => $purchaseCount,
            'transactionCount' => $transactionCount,
            'totalQuantity' => $totalQuantity,
        ];
    }
}