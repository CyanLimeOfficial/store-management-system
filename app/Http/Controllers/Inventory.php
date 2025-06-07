<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Inventory extends Controller
{
    // In your ProductController or similar
    public function updateStock(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0'
        ]);

        $product = Product::findOrFail($id);
        $product->quantity = $request->quantity;
        $product->save();

        return response()->json(['message' => 'Stock updated successfully']);
    }
}
