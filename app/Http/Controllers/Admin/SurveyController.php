<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Survey;
use App\Models\Unit;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SurveyController extends Controller
{
    public function index() {
        $user_role = Auth::user()->role_as;
        $survey = new Survey();
        $unit = new Unit();
        $data_survey = $survey->getAllSurvey()->paginate(15);
        $data_unit = $unit->getAllUnit();
        return view('admin.survey',[
            'user_role' => $user_role,
            'data_survey' => $data_survey,
            'data_unit' => $data_unit
        ]);
    }
    public function storeSurvey(Request $request) {
        $user_id = Auth::user()->id;
        $price = $request->price;
        try {
            $request->validate([
                'product_name' => ['required'],
                'price' => ['required', 'numeric'],
                'unit_id' => ['required'],
                'survey_location' => ['required'],
            ]);
            $price = number_format($price,2);
            Survey::create([
                'user_id' => $user_id,
                'product_name' => $request->product_name,
                'survey_location' => $request->survey_location,
                'unit_id' => $request->unit_id,
                'price' => $price,

            ]);
            return redirect()->back()->with('success', 'Successfully inserted to Survey');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function updateSurvey(Request $request) {
        $user_id = Auth::user()->id;
        $price = $request->price;
        try {
            $request->validate([
                'product_name' => ['required'],
                'price' => ['required', 'numeric'],
                'unit_id' => ['required'],
                'survey_location' => ['required']
            ]);
            $price = number_format($price,2);
            Survey::where('id', $request->id)->update([
                'user_id' => $user_id,
                'product_name' => $request->product_name,
                'survey_location' => $request->survey_location,
                'unit_id' => $request->unit_id,
                'price' => $price,

            ]);
            return redirect()->back()->with('success', 'Successfully updated to Survey');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function deleteSurvey(Request $request) {
        try {
            $request->validate([
                'id' => 'required',
            ]);
            Survey::where('id', $request->id)->delete();
            return redirect()->back()->with('error', 'Successfully deleted from Survey');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function searchSurvey(Request $request) {
        $unit = new Unit();
        $survey = new Survey();
        $user_role = Auth::user()->role_as;
        $search_input = $request->searchInput;
        $data_survey = $survey->searchSurvey($search_input);
        $data_unit = $unit->getAllUnit();
        return view('admin.survey',[
            'data_survey' => $data_survey, 
            'user_role' => $user_role,
            'data_unit' => $data_unit
        ]);

    }

    public function searchSurveyAjax(Request $request) {
        $survey = new Survey();
        $product_name = $request->product_name;
        $data_avg = $survey->searchSurveyAvg($product_name);
        $data_low = $survey->searchLowest($product_name);
        $data_high = $survey->searchHighest($product_name);
        return response()->json([$data_low,$data_avg,$data_high]);
    }
}
