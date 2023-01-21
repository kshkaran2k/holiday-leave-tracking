<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Holiday;
use Auth;
use DB;

class HolidayController extends Controller
{
    public function create(Request $request)
    {   
        // checks if the record for same user and same date already exist in the db. if not, create an entry
        $res = DB::table('holidays')->where('user_id',Auth::user()->id)->where('holiday_date',$request->holiday_date)->get();
        
        if(count($res)==0){
            $holiday = new Holiday;
            $holiday->user_id = Auth::user()->id;
            $holiday->holiday_date = $request->holiday_date;
            // $holiday->approved = '0';
            $holiday->save();
            return redirect('dashboard')->with('status', 'Holiday request has been submitted for approval');
        }
        else{
            return redirect('dashboard')->with('failure', 'The request for the same date is already raised earlier');
        }
        
    }

    public function approve(Request $request, $slug)
    {   
        $res = DB::table('holidays')->where('id',$slug)->update(['approval_status'=>'approved']);
        if($res == 1){
            return redirect('dashboard')->with('status', 'Record approved');
        }else{
            return redirect('dashboard')->with('failure', 'Due to some error, record is not approved');
        }
    }


    public function reject(Request $request, $slug)
    {   
        $reject = DB::table('holidays')->where('id',$slug)->update(['approval_status'=>'rejected']);
        if($reject == 1){
            return redirect('dashboard')->with('status', 'Record Rejected');
        }else{
            return redirect('dashboard')->with('failure', 'Due to some error, record is not rejected');
        }
    }

}
