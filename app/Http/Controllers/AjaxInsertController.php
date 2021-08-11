<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AjaxInsertController extends Controller {

  public function insertAjaxBron(Request $req) {

    $idrow    = $req->input('id');
    $takeRoom = $req->input('room');

    $last = DB::table('bron_info')->insertGetId([
      'takeVid' => 'уборка',
    ]);

    DB::table('bron')->where('id', $idrow)->update([
      'bron_info_id' => $last,
    ]);

    return true;
  }

  /*   * ********************************************************************************************************** */

  public function insertFastBron(Request $req) {

    $roomos         = $req->input('roomid');
    $month_id       = $req->input('monthid');
    $get_date_range = $req->input('takeBron_range');
    $takeVid        = $req->input('takeVid');
    $fio            = $req->input('fio');
    $tel            = $req->input('telephon');
    $forText        = $req->input('forText');

    /* ======================================================================================== */
    $range_date = Str::of($get_date_range)->explode('-');
    $date_start = Str::of($range_date[0])->trim();
    $date_end   = Str::of($range_date[1])->trim();

    $Carbon_start = Carbon::parse($date_start);
    $Carbon_end   = Carbon::parse($date_end);

    
    
    $z_start_new = $Carbon_start->format('d.m.Y');
    $z_end_new = $Carbon_start->format('d.m.Y');
    $z_start = $Carbon_start->year . "-" . $Carbon_start->month . "-" . $Carbon_start->day;
    $z_end   = $Carbon_end->year . "-" . $Carbon_end->month . "-" . $Carbon_end->day;
    /* =====================================UPDATE============================================= */

    $bron_info = DB::table('bron_info')->insertGetId([
      'takeVid'         => $takeVid,
      'fio'             => $fio,
      'telehon'         => $tel,
      'comment'         => $forText,
      'bron_start_date' => $z_start,
      'bron_end_date'   => $z_end,
    ]);

    
    DB::table('bron')
        ->where('room_id', '=', $roomos)
        ->where('month_id', '=', $month_id)
        ->whereBetween('month_year', [$z_start, $z_end])
        ->update([
          'bron_info_id' => $bron_info,
    ]);
    /* ================== ЛОГИ ========================================================= */
    $select_number = DB::table('rooms')->where('id_room', $roomos)->first();
    $LogAction     = [
      'действие'          => 'быстрое изменение номера',
      'тип занятости'     => $takeVid,
      'дата бронирование' => $z_start_new . ' - ' . $z_end_new,
      'номер комнаты'     => $select_number->room,
      'фио'               => $fio,
      'тел'               => $tel,
      'комментарий'       => $forText,
    ];
    $this->MyActionLogs(Auth::id(), $LogAction);
    /* ================== /ЛОГИ ========================================================= */
    return true;
  }

}
