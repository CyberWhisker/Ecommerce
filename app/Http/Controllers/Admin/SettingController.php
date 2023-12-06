<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationData;

class SettingController extends Controller
{
    public function index(){
        $unit = new Unit();
        $user_role = Auth::user()->role_as;
        $data_unit = $unit->getAllUnit();
        return view('admin.setting',[
            'user_role' => $user_role,
            'data_unit' => $data_unit,
        ]);
    }

    public function storeUnit(Request $request){
        try {
            $request->validate([
                'unit' => ['required', 'unique:units,unit'],
            ]);
            Unit::create([
                'unit' => $request->unit
            ]);
            return redirect()->back()->with('success', 'Successfully inserted unit');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function updateUnit(Request $request){
        try {
            $request->validate([
                'id' => ['required'],
                'unit' => ['required'],
            ]);
            Unit::where('id',$request->id)->update([
                'unit' => $request->unit
            ]);
            return redirect()->back()->with('success', 'Successfully updated unit');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function deleteUnit(Request $request){
        try {
            $request->validate([
                'id' => ['required'],
            ]);
            Unit::where('id',$request->id)->delete();
            return redirect()->back()->with('success', 'Successfully deleted unit');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
