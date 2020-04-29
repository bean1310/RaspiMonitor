<?php

use Illuminate\Support\Facades\DB;

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

// Register is available when 0 users.
$isUserExist = DB::table('users')->count();
if ($isUserExist) {
    Auth::routes(['register' => false]);
} else {
    Auth::routes();
}

Route::get('/', 'HomeController@index')->name('home');

Route::get('/settings', 'SettingsController@index')->name('settings');
Route::post('/settings/save', 'SettingsController@save')->name('settingsSave');
