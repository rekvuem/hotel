<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;

class DashboardController extends Controller {
  /* ====================================================================================== */

  public function dashboard(Request $request) {
    $User_month = DB::table('user_active_year')->where('user_id', Auth::id())->first();
    Cookie::queue(Cookie::forever('monthing', $User_month->month_id));

    $month = DB::table('month')->get();

    if (empty($request->query('korpus')))
    {
      $room = DB::table('rooms')->where('corpus', 1)->get();
    }
    return view('cabinet.dashboard', compact([
      'month', 'room'
    ]));
  }

  /* ====================================================================================== */

  public function korpus(Request $request, $korp) {
    $sel = $request->query('room');

    $TakeRoom = DB::table('rooms')->where('corpus', $korp)->get();

    $User_month = DB::table('user_active_year')->where('user_id', Auth::id())->first();
    $month      = DB::table('month')->where('id', $User_month->id)->first();
    $jsons      = '';
    IF (!empty($sel))
    {
      $TakeBron    = DB::table('bron')
          ->leftJoin('rooms', 'bron.room_id', '=', 'rooms.id')
          ->where('room_id', $sel)
          ->where('month_id', $User_month->id)
          ->get();
//dd($TakeBron);
      $jsons_array = json_decode($TakeBron, true);
      sleep(1);
//
//      foreach ($jsons_array as $gettext)
//      {
//        $jsons            = json_decode($gettext['jsontext'], true);
//        $jsons['takeVid'] = null;
//        IF (isset($jsons['takeVid']))
//        {
//          $jsons['takeVid'];
//        } else
//        {
//          $jsons['takeVid'] = 'забронировано';
//        }
//      }
    } else
    {
      $TakeBron    = DB::table('bron')
          ->leftJoin('rooms', 'bron.room_id', '=', 'rooms.id')
          ->where('room_id', $sel)
          ->where('month_id', $User_month->month_id)
          ->get();
      $jsons_array = json_decode($TakeBron, true);

      $jsons = '';
    }

    return view('cabinet.korpus', compact(['TakeRoom', 'TakeBron', 'month', 'jsons', 'jsons_array']));
  }

  /* ====================================================================================== */

  public function selectLevel(Request $req) {
    $getkorpus = $req->all('getroom');
    $Room      = DB::table('rooms')->where('corpus', $getkorpus)->get();

    return view('ajax.room', compact([
      'Room',
    ]));
  }

  /* ====================================================================================== */

  public function updateYear($update) {

    $Roomed   = DB::table('rooms')->get();
    $Month    = DB::table('month')->where('id', $update)->first();
    $showDate = cal_days_in_month(CAL_GREGORIAN, $Month->month, $Month->year);
    $selectos = DB::table('bron')->where('month_id', $Month->id)->first();
    foreach ($Roomed as $rooming)
    {

      IF (empty($selectos->month_id) >= $Month->id)
      {
        for ($i = 1; $i <= $showDate; $i++)
        {
          DB::table('bron')->insertOrIgnore([
            'room_id'  => $rooming->id,
            'month_id' => $Month->id,
            'day'      => $i,
          ]);
        }
      }
    }

    DB::table('user_active_year')
        ->where('user_id', Auth::id())->update([
      'month_id' => $update,
    ]);
    Cookie::queue(Cookie::forever('monthing', $update));
    return redirect()->route('cabinet.dashboard');
  }

}
