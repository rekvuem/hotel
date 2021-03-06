<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BronusController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\AjaxInsertController;
use Illuminate\Http\Request;

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
  Route::get('/showKorpus', [DashboardController::class, 'korpus'])->name('korpus');

  /*   * ************************************************************************************************** */
  /*   * ***********************************    BRONUS    ************************************************* */
  /*   * ************************************************************************************************** */
  Route::get('/showRoom', [BronusController::class, 'fullShowRoomOne'])->name('fullShowRoom');
  Route::post('/insertBron', [BronusController::class, 'inserToBron'])->name('insertToBron');

  /*   * ************************************************************************************************** */
  /*   * *************************************    AJAX    ************************************************* */
  /*   * ************************************************************************************************** */
  Route::get('/freeroom', [AjaxController::class, 'freeroom'])->name('freeroom');
  Route::get('/listfreeroom', [AjaxController::class, 'listfreeroom'])->name('listfreeroom');
  Route::get('/shownoneroom', [AjaxController::class, 'shownoneroom'])->name('shownoneroom');
  
  Route::delete('/deletetype', [AjaxController::class, 'deletetypebron'])->name('deleteTypeBron');
  
  Route::post('/updatetype', [AjaxController::class, 'updatetypebron'])->name('updateTypeBron');
  
  Route::put('/updateroominfo', [AjaxController::class, 'updateInfoRoom'])->name('updateroominfo');
  Route::put('/updateroomcomment', [AjaxController::class, 'updateInfoComment'])->name('updateroominfocomment'); 
  
  Route::post('/insertAjaxbron', [AjaxInsertController::class, 'insertAjaxBron'])->name('insertAjaxBron');
  Route::post('/insertFastBron', [AjaxInsertController::class, 'insertFastBron'])->name('insertFastBron');
  /*   * ************************************************************************************************** */
  /*   * ***********************************    Settings    *********************************************** */
  /*   * ************************************************************************************************** */
  Route::get('/settings', [SettingController::class, 'settinging'])->name('setting');
  Route::post('/insertYear', [SettingController::class, 'addYear'])->name('insertYear');
  Route::post('/addroom', [SettingController::class, 'addRoom'])->name('addRoom');
  Route::get('/updateyear', [SettingController::class, 'updateYearKorp'])->name('updateyearkorp');

  Route::get('/updateyear/{year}', [SettingController::class, 'updateYear'])->name('updateyear'); // ???????????????????????? ?????? ???? ?????????????? ??????????????
  Route::get('/logs', [SettingController::class, 'showactionlog'])->name('siteactionlog');
  
  Route::get('/getClear', function () {
    Artisan::call('optimize');
    return redirect()->route('cabinet.setting');
  })->name('getClear');
});
