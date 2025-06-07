<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Product_Inventory;

class Products_Inventory extends Controller
{
    public function add_product(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'price'         => 'required|numeric|max:255',
            'product_name'  => 'required|string|max:255',
            'category'      => 'required|string|max:255',
            'store_id'      => 'required|exists:store_info,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $exists = Product_Inventory::where('product_name', $request->product_name)
            ->where('category', $request->category)
            ->where('store_id', $request->store_id)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'A product with this name and category already exists in this store.')->withInput();
        }

        try {
            $product = Product_Inventory::create([
                'store_id'     => $request->store_id,
                'product_name' => $request->product_name,
                'category'     => $request->category,
                'price'        => $request->price,
            ]);

            return redirect('/home')->with('success', 'Product added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to add product.')->withInput();
        }
    }

    public function update_stock(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0'
        ]);

        $product = Product_Inventory::findOrFail($id);
        $product->quantity = $request->quantity;
        $product->save();

        return response()->json(['message' => 'Stock updated successfully']);
    }
}
