<?php

use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\HolidayController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});



Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// USER DASHBOARD

Route::middleware(['auth'])->group(function () {

    // for create a new holiday request
    Route::post('/addHoliday', 'App\Http\Controllers\HolidayController@create');

    Route::get('/approveHoliday/{slug}', 'App\Http\Controllers\HolidayController@approve')->name('holiday.approve');
    Route::get('/rejectHoliday/{slug}', 'App\Http\Controllers\HolidayController@reject')->name('holiday.reject');

    // for rendering the dashboard
    Route::get('/dashboard', function () {

        $user = auth()->user();
        
        if($user->hasRole('admin')){
            $pending = DB::table('holidays')
                        ->join('users', 'holidays.user_id', '=', 'users.id')
                        ->where('holidays.approval_status',null)
                        ->select('users.name','holidays.*')
                        ->get();
            $all = DB::table('holidays')
                        ->join('users', 'holidays.user_id', '=', 'users.id')
                        ->whereIn('holidays.approval_status',array('rejected','approved'))
                        ->select('users.name','holidays.*')
                        ->get();
            $data = array($pending, $all);
            
        }else{
            // $data=array('user');
            $data = DB::table('holidays')->where('user_id',$user->id)->get();
        }

        return view('dashboard',['data'=>$data]);
    })->name('dashboard');
});
