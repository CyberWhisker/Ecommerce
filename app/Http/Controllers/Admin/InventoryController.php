<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Unit;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class InventoryController extends Controller
{
    public function index(){
        $unit = new Unit();
        $user_role = Auth::user()->role_as;
        $data_inventory = Inventory::with('unit')->get();
        $data_unit = $unit->getAllUnit();
        return view('admin.inventory', [
            'data_inventory' => $data_inventory,
            'user_role' => $user_role,
            'data_unit' => $data_unit
        ]);
    }
    public function storeInventory(Request $request) {
        $user_id = Auth::user()->id;
        $price = $request->price;
        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('imgProduct','public');
        }
        try {
            $request->validate([
                'product_name' => ['required'],
                'quantity' => ['required', 'integer'],
                'price' => ['required', 'numeric'],
                'unit_id' => ['required'],
            ]);
            $price = number_format($price,2);
            Inventory::create([
                'user_id' => $user_id,
                'product_name' => $request->product_name,
                'quantity' => $request->quantity,
                'unit_id' => $request->unit_id,
                'price' => $price,
                'image' => $path
            ]);
            return redirect()->back()->with('success', 'Successfully inserted to inventory');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function updateInventory(Request $request) {
        $user_id = Auth::user()->id;
        $price = $request->price;
        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('imgProduct','public');
        }
        try {
            $request->validate([
                'product_name' => ['required'],
                'quantity' => ['required', 'integer'],
                'price' => ['required', 'numeric'],
                'unit_id' => ['required'],
            ]);
            $price = number_format($price,2);
            Inventory::where('id', $request->id)->update([
                'user_id' => $user_id,
                'product_name' => $request->product_name,
                'quantity' => $request->quantity,
                'unit_id' => $request->unit_id,
                'price' => $price,
                'image' => $path
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
            return redirect()->back()->with('error', 'Successfully deleted from inventory');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function searchInventory(Request $request) {
        $unit = new Unit();
        $inventory = new Inventory();
        $user_role = Auth::user()->role_as;
        $search_input = $request->searchInput;
        $data_inventory = $inventory->searchInventory($search_input);
        $data_unit = $unit->getAllUnit();
        return view('admin.inventory',[
            'data_inventory' => $data_inventory, 
            'user_role' => $user_role,
            'data_unit' => $data_unit
        ]);
    }
}
