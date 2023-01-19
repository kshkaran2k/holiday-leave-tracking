<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'user'])->name('dashboard');

// MANAGER DASHBOARD
Route::get('/manager_dashboard', function () {
    return view('manager_dashboard');
})->middleware(['auth', 'manager'])->name('manager_dashboard');

// ADMIN DASHBOARD
Route::get('/admin_dashboard', function () {
    return view('admin_dashboard');
})->middleware(['auth', 'admin'])->name('admin_dashboard');


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