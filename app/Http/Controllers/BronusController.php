<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class BronusController extends Controller {

  public function showRooms() {

    dd("jghjh");
    return view('cabinet.showbron', compact([
    ]));
  }

  public function inserToBron(Request $req) {

    $data = $req->only(['takeVid', 'fio', 'telephon', 'forText']);

    $korpus       = $req->input('takeKorp');
    $roomos       = $req->input('room');
    $takeDate     = $req->input('takeBron');
    $fio          = $req->input('fio');
    $forText      = $req->input('forText');
    /* ======================================================================================== */
    $shortDate    = Str::of($takeDate)->substr(3);
    $explode      = Str::of($takeDate)->explode('.');
    $explode_Date = Str::of($shortDate)->explode('.');
    /* ======================================================================================== */
    IF (!DB::table('month')->where('month_year', $shortDate)->exists())
    {
      $month = DB::table('month')->insertOrIgnore([
        'month'      => $explode_Date[0],
        'year'       => $explode_Date[1],
        'month_year' => $shortDate,
      ]);
    }
    /* ================================INSERT TO BRON========================================== */
    sleep(2);
    $TakeRoom = DB::table('rooms')->get();

    $takeMonth = DB::table('month')->where('month_year', $shortDate)->first();
    $selectos  = DB::table('bron')->where('month_id', $takeMonth->id)->first();

    $showDate = cal_days_in_month(CAL_GREGORIAN, $explode_Date[0], $explode_Date[1]);
    foreach ($TakeRoom as $room)
    {
      IF (empty($selectos->month_id) >= $takeMonth->id)
      {
        for ($i = 1; $i <= $showDate; $i++)
        {
          DB::table('bron')->insertOrIgnore([
            'room_id'  => $room->id,
            'month_id' => $takeMonth->id,
            'day'      => $i,
          ]);
        }
      }
    }
    /* =====================================UPDATE============================================= */
    sleep(2);
    $up = DB::table('bron')
        ->where('room_id', '=', $roomos)
        ->where('month_id', '=', $takeMonth->id)
        ->where('day', '=', $explode[0])
        ->update([
      'jsontext' => json_encode($data, JSON_UNESCAPED_UNICODE),
    ]);

    return redirect()->route('cabinet.dashboard');
  }

  /* =====================================CHECK BRON============================================= */

  public function chooseroom(Request $req) {


    $roomos   = $req->query('room');
    $takeDate = $req->query('check');
    $explode  = Str::of($takeDate)->explode('.');
    $mon      = $explode[1].".".$explode[2];
    $TakeMonth = DB::table('month')->where('month_year', '=',$mon)->first();

    $takeDates = DB::table('bron')
        ->where('room_id', '=', $roomos)
        ->where('month_id', '=', $TakeMonth->id)
        ->where('day', '=', $explode[0])->first();
    
    $jsons = json_decode($takeDates->jsontext, true); //декодирование текста
    
    return view('ajax.reservation', compact(['takeDates','jsons']));
  }

}
