<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function index() {
        $user = new User();
        $user_role = Auth::user()->role_as;
        $getAllUsers = $user->getAllUsers()->paginate(8);
        return view('admin.users',[
            'getAllUsers' => $getAllUsers, 
            'user_role' => $user_role   
        ]);
    }
    
    public function storeUser(Request $request)
    {
        try {
            $validation = $request->validate([
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'middle_name' => ['required', 'string', 'max:255'],
                'address' => ['required', 'string', 'max:255'],
                'phone_number' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
                'password' => ['required'],
            ]);
            if (!$validation) {
                return redirect()->back()->with('error', 'Please fill in form');
            };
            $user = User::create([
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name,
                'last_name' => $request->last_name,
                'address' => $request->address,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'password' => Hash::make($request->password),
            ]);
            return redirect()->back()->with('success', 'Successfully added user');
        } catch (Exception $e) {
            dd($e);
        }
    }
    function updateRole(Request $request){
        User::where('id', $request->user_id)
            ->update([
                'role_as' => $request->role_as
            ]);
        return redirect()->back()->with('success', 'Successfully updated role');
    }
}
