<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BronusController;
use App\Http\Controllers\SettingController;
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
  return view('home.welcome');
})->name('welcome');

Auth::routes(['register' => true]);
Route::prefix('/cabinet')->name('cabinet.')->namespace('Cabinet')->middleware(['auth'])->group(function () { 
  
  Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');
  Route::get('/showKorpus/{korp}', [DashboardController::class, 'korpus'])->name('korpus');
  Route::get('/updateyear/{update}', [DashboardController::class, 'updateYear'])->name('updateyear');
  Route::get('/showRoom', [BronusController::class, 'showRooms'])->name('showRooms');
  Route::get('/settings', [SettingController::class, 'settinging'])->name('setting');
  Route::post('/insertBron', [BronusController::class, 'inserToBron'])->name('insertToBron');
  /*****************************************************************************************************/
  /***************************************    AJAX    **************************************************/
  /*****************************************************************************************************/
  Route::get('/selectRoom', [DashboardController::class, 'selectLevel'])->name('selectrooms');
  Route::get('/getchooseroom', [BronusController::class, 'chooseroom'])->name('chooseroom');
  

});
