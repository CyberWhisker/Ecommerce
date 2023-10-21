<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    public function createOrUpdateStore(Request $request) {
        $user_id = Auth::user()->id;
        try {
            $request->validate([
                'street' => ['required'],
                'barangay' => ['required'],
                'city' => ['required'],
                'province' => ['required']
            ]);
            Store::updateOrInsert(
                [
                    'user_id' => $user_id
                ],
                [
                    'street' => $request->street,
                    'barangay' => $request->barangay,
                    'city' => $request->city,
                    'province' => $request->province,
                ]
            );
            return redirect()->back()->with('status_store', 'profile-updated');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error, Insertion Failed!');
        }
    }
}
