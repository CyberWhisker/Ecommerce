<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Calendar;
use App\Models\Scheduler;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    public function index(){
        $user_role = Auth::user()->role_as;
        $calendar =  Calendar::all();
        $events = [];
        foreach($calendar as $data){
            $events[] = [
                'title' => $data->title,
                'start' => $data->start_date,
                'end' => $data->end_date,
            ];
        }
        if ($events) {
            # code...
        }
        return view('admin.calendar',[
            'user_role' => $user_role,
            'events' => $events
        ]);
    }
    public function storeCalendar(Request $request) {
        $start_date = Carbon::parse($request->start_date)->setTime(7, 0, 0);
        $end_date = Carbon::parse($request->end_date)->setTime(7, 0, 0);
        try {
            $request->validate([
                'title' => ['required'],
                'start_date' => ['required'],
                'end_date' => ['required'],
            ]);
            Calendar::create([
                'title' => $request->title,
                'start_date' => $start_date,
                'end_date' => $end_date,
            ]);
            return redirect()->back()->with('success', 'Successfully inserted data');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
