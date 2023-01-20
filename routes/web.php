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


Route::post('/addHoliday', 'App\Http\Controllers\HolidayController@create');

Route::get('/dashboard', function () {

    $user = auth()->user();
    
    if($user->hasRole('admin')){
        $pending = DB::table('holidays')
                    ->join('users', 'holidays.user_id', '=', 'users.id')
                    ->where('holidays.approval_status',null)
                    ->select('users.name','holidays.*')
                    ->get();
        $all = DB::table('holidays')->
                    join('users', 'holidays.user_id', '=', 'users.id')
                    ->where('holidays.approval_status',['pending','approved'])
                    ->select('users.name','holidays.*')
                    ->get();
        $data = array($pending, $all);
        
    }else{
        // $data=array('user');
        $data = DB::table('holidays')->where('user_id',$user->id)->get();
    }


    return view('dashboard',['data'=>$data]);
})->name('dashboard');

// MANAGER DASHBOARD
Route::get('/manager_dashboard', function () {
    return view('manager_dashboard');
})->name('manager_dashboard');

// ADMIN DASHBOARD
Route::get('/admin_dashboard', function () {
    return view('admin_dashboard');
})->name('admin_dashboard');


// require __DIR__.'/auth.php';

// // user protected routes
// Route::group(['middleware' => ['auth', 'user'], 'prefix' => 'user'], function () {
//     Route::get('/', 'HomeController@index')->name('user_dashboard');
//     Route::get('/list', 'UserController@list')->name('user_list');
// });

// // manager protected routes
// Route::group(['middleware' => ['auth', 'manager'], 'prefix' => 'manager'], function () {
//     Route::get('/', 'HomeController@index')->name('manager_dashboard');
//     Route::get('/list', 'UserController@list')->name('user_list');
// });

// // admin protected routes
// Route::group(['middleware' => ['auth', 'admin'], 'prefix' => 'admin'], function () {
//     Route::get('/', 'HomeController@index')->name('admin_dashboard');
//     Route::get('/users', 'AdminUserController@list')->name('admin_users');
// });

// // user protected routes
// Route::group(['middleware' => ['auth', 'user'], 'prefix' => 'user'], function () {
//     Route::get('/', 'UserController@index')->name('user_dashboard');
//     Route::get('/list', 'UserController@list')->name('user_list');
// });