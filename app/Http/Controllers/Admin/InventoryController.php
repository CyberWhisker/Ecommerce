<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class InventoryController extends Controller
{
    public function index(){
        $inventory = new Inventory();
        $user_role = Auth::user()->role_as;
        $data_inventory = $inventory->getAllInventory()->paginate(15);
        return view('admin.inventory', [
            'data_inventory' => $data_inventory,
            'user_role' => $user_role,
        ]);
    }
    public function storeInventory(Request $request) {
        $user_id = Auth::user()->id;
        $unit = $request->unit;
        $price = $request->price;
        try {
            $request->validate([
                'product_name' => ['required'],
                'quantity' => ['required', 'integer'],
                'price' => ['required', 'numeric'],
                'unit' => ['required', 'numeric'],
                'survey_location' => ['required'],
            ]);
            $unit = number_format($unit,2);
            $price = number_format($price,2);
            Inventory::create([
                'user_id' => $user_id,
                'product_name' => $request->product_name,
                'quantity' => $request->quantity,
                'survey_location' => $request->survey_location,
                'unit' => $unit,
                'price' => $price,

            ]);
            return redirect()->back()->with('success', 'Successfully inserted to inventory');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function updateInventory(Request $request) {
        $user_id = Auth::user()->id;
        $unit = $request->unit;
        $price = $request->price;
        try {
            $request->validate([
                'product_name' => ['required'],
                'quantity' => ['required', 'integer'],
                'price' => ['required', 'numeric'],
                'unit' => ['required', 'numeric'],
                'survey_location' => ['required'],
            ]);
            $unit = number_format($unit,2);
            $price = number_format($price,2);
            Inventory::where('id', $request->id)->update([
                'user_id' => $user_id,
                'product_name' => $request->product_name,
                'quantity' => $request->quantity,
                'survey_location' => $request->survey_location,
                'unit' => $unit,
                'price' => $price,

            ]);
            return redirect()->back()->with('success', 'Successfully updated to inventory');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function deleteInventory(Request $request) {
        try {
            $request->validate([
                'id' => 'required',
            ]);
            Inventory::where('id', $request->id)->delete();
            return redirect()->back()->with('success', 'Successfully deleted from inventory');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
