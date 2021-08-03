<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class SettingController extends Controller {

  public function settinging(Request $request) {

    $TakeYear = DB::table('month')->orderBy('month_year', 'desc')->orderBy('month', 'asc')->simplePaginate(12);
    $room_1   = DB::table('rooms')->where('corpus', 1)->orderBy('room', 'asc')->get();
    $room_2   = DB::table('rooms')->where('corpus', 2)->orderBy('room', 'asc')->get();
        
    return view('cabinet.settings', compact(['TakeYear', 'room_1', 'room_2']));
  }

  /* ========================================================= */

  public function addYear(Request $r) {
    $month      = $r->input('month');
    $year       = $r->input('year');
    $month_year = $month . "." . $year;

    $carbon_month = Carbon::parse($year . '-' . $month);

    $takeMonth = DB::table('month')->insertGetId([
      'month'      => $month,
      'year'       => $year,
      'month_year' => $month_year,
    ]);

    $TakeRoom = DB::table('rooms')->get();
    foreach ($TakeRoom as $room)
    {
      for ($i = 1; $i <= $carbon_month->daysInMonth; $i++)
      {
        DB::table('bron')->insertOrIgnore([
          'room_id'    => $room->id_room,
          'month_id'   => $takeMonth,
          'month_year' => $year . "-" . $month . "-" . $i,
          'day'        => $i,
        ]);
      }
    }
    
    $LogAction = [
      'action' => 'добавлен месяц',
      'month' => $month_year,
    ];
    
    $this->MyActionLogs(Auth::id(), $LogAction);
    
    return redirect()->route('cabinet.setting');
  }

  /* ========================================================= */

  public function updateYearKorp(Request $r) {
    $year = $r->query('year');
    $korp = $r->query('korpus');
    DB::table('user_active_year')
        ->where('user_id', Auth::id())->update([
      'month_id' => $year,
    ]);
    Cookie::queue(Cookie::forever('monthing', $year));

    return back();
  }

  /* ========================================================= */

  public function updateYear($year) {

    DB::table('user_active_year')
        ->where('user_id', Auth::id())->update([
      'month_id' => $year,
    ]);
    Cookie::queue(Cookie::forever('monthing', $year));

    return redirect()->route('cabinet.setting');
  }

  /* ========================================================= */

  public function addRoom(Request $r) {

    $korpus    = $r->input('korpus');
    $room      = $r->input('roomos');
    $price     = $r->input('price');
    $commentar = $r->input('comment');
    DB::table('rooms')->insertOrIgnore([
      'corpus'  => $korpus,
      'room'    => $room,
      'price'   => $price,
      'comment' => $commentar,
    ]);
    /* ================== ЛОГИ =========================================================*/
    $LogAction = [
      'action' => 'добавлена комната',
      'korpus' => $korpus,
      'number_room'=>$room,
      'price'=>$price,
      'commentar'=>$commentar,
    ];
    
    $this->MyActionLogs(Auth::id(), $LogAction);
    /* ================== /ЛОГИ =========================================================*/
    
    return redirect()->route('cabinet.setting');
  }

}
