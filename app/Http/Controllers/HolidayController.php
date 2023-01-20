<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Holiday;
use Auth;

class HolidayController extends Controller
{
    public function create(Request $request)
    {
        $holiday = new Holiday;
        $holiday->user_id = Auth::user()->id;
        $holiday->holiday_date = $request->holiday_date;
        // $holiday->approved = '0';
        $holiday->save();
        return redirect('dashboard')->with('status', 'Holiday request has been submitted for approval');
    }
}
