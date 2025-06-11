<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\StoreInfo;

class StoreDetails extends Controller
{
    /**
     * Show the form for editing store and user details.
     */
    public function edit()
    {
        $user = Auth::user();
        // Eager load the store information to avoid an extra query
        $store = StoreInfo::where('user_id', $user->id)->first();

        // Pass the user and store data to the view
        return view('dashboard.store-details', compact('user', 'store'));
    }

    /**
     * Update the store and user details in the database.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $store = StoreInfo::where('user_id', $user->id)->first();

        // Validate the incoming request data
        $validatedData = $request->validate([
            'store_name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
            'name' => 'required|string|max:255',
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users')->ignore($user->id), // Ensure username is unique, ignoring the current user
            ],
            'password' => 'nullable|string|min:8|confirmed', // Must match password_confirmation
        ]);

        // Update Store Information
        if ($store) {
            $store->update([
                'store_name' => $validatedData['store_name'],
                'address' => $validatedData['address'],
                'description' => $validatedData['description'],
            ]);

            // Handle the logo upload if a new one is provided
            if ($request->hasFile('logo')) {
                $store->logo = file_get_contents($request->file('logo')->getRealPath());
                $store->save();
            }
        }

        // Update User Information
        $user->name = $validatedData['name'];
        $user->username = $validatedData['username'];
        
        // Only update the password if a new one was entered
        if ($request->filled('password')) {
            $user->password = Hash::make($validatedData['password']);
        }
        $user->save();

        return redirect()->route('store-details.edit')->with('success', 'Details updated successfully!');
    }
}