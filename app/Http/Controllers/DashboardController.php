<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class DashboardController extends Controller {
  /* ====================================================================================== */

  public function dashboard(Request $request) {
    $User_month = DB::table('user_active_year')->where('user_id', Auth::id())->first();
    $User_month_year = DB::table('month')->where('id', $User_month->month_id)->first();
    if(empty($User_month->month_id)){
    
    }else{
      Cookie::queue(Cookie::forever('monthing', $User_month->month_id));
      Cookie::queue(Cookie::forever('month_year_text', $User_month_year->month_year));
    }
    $carbon_now = Carbon::now();
    $parse_carbon_now = Carbon::parse($carbon_now);
    $time = $parse_carbon_now->year."-".$parse_carbon_now->month."-".$parse_carbon_now->day;

    
    $getBron_now = DB::table('bron')
        ->where('month_year', '=', $time)
        ->leftJoin('rooms', 'bron.room_id', '=', 'rooms.id_room')
        ->leftJoin('bron_info', 'bron.bron_info_id', '=', 'bron_info.id_bron')
        ->get();

    return view('cabinet.dashboard', compact(['getBron_now']));
  }

  /* ====================================================================================== */

  public function korpus(Request $request) {
    $sel    = $request->query('room');
    $korpus = $request->query('korpus');

    $TakeYear   = DB::table('month')->orderBy('month_year', 'desc')->get();
    $TakeRoom   = DB::table('rooms')->where('corpus', $korpus)->get();
    $User_month = DB::table('user_active_year')->where('user_id', Auth::id())->first();
    $month      = DB::table('month')->where('id', $User_month->month_id)->first();

    IF (empty($month->year))
    {
      abort('403', 'Активируйте актуальный месяц в настройках!');
    }
    
    $carbon_month = Carbon::parse($month->year . '-' . $month->month);
    $carbon_days  = $carbon_month->daysInMonth;

    $TakeRoomys = DB::table('bron')
        ->leftJoin('rooms', 'bron.room_id', '=', 'rooms.id_room')
        ->leftJoin('bron_info', 'bron.bron_info_id', '=', 'bron_info.id_bron')
        ->where('room_id', $sel)
        ->where('month_id', $month->id)
        ->get();

    return view('cabinet.korpus', compact([
      'TakeRoomys', 'TakeRoom', 'carbon_days', 'TakeYear',
    ]));
  }

}
