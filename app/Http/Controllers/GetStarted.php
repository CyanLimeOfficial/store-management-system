<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\StoreInfo;

class GetStarted extends Controller
{
    public function store(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'store_name'   => 'required|string|max:255',
            'address'      => 'nullable|string|max:255',
            'description'  => 'nullable|string',
            'logo'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            // If logo is uploaded
            if ($request->hasFile('logo')) {
                $logoContent = file_get_contents($request->file('logo')->getRealPath());
            } else {
                // Fallback to default image
                $defaultPath = public_path('assets/default/default-logo.png'); 
                $logoContent = file_get_contents($defaultPath);
            }

            // Save store info
            StoreInfo::create([
                'user_id'     => auth()->id(),
                'store_name'  => $request->store_name,
                'logo'        => $logoContent,
                'address'     => $request->address,
                'description' => $request->description,
            ]);

            return redirect('/home')->with('success', 'Store info saved successfully!');
        } catch (\Exception $e) {
            \Log::error('Store Info Save Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to save store info.')->withInput();
        }
    }
}
