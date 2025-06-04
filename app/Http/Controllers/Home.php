<?php

namespace App\Http\Controllers;

use App\Models\StoreInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Home extends Controller
{
    public function updateStoreName(Request $request)
    {
        $request->validate([
            'new_store_name' => 'required|string|max:255|min:3'
        ]);

        $store = StoreInfo::where('user_id', auth()->id())->first();

        if (!$store) {
            return response()->json([
                'success' => false,
                'message' => 'Store not found.'
            ], 404);
        }

        if ($store->store_name === $request->new_store_name) {
            return response()->json([
                'success' => false,
                'message' => 'New store name is the same as the current name.'
            ]);
        }

        $store->store_name = $request->new_store_name;
        $store->save();

        return response()->json([
            'success' => true,
            'message' => 'Store name updated successfully.',
            'new_store_name' => $store->store_name
        ]);
    }
}
