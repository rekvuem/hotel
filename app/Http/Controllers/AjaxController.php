<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AjaxController extends Controller {

  public function updatetypebron(Request $req) {

    $type     = $req->input('idtype');
    $takeDate = $req->input('optionType');

    DB::table('bron_info')
        ->where('id_bron', $type)
        ->update([
          'takeVid' => $takeDate,
    ]);

//    return true;
  }

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

  public function chooseroom(Request $req) {


    $roomos    = $req->query('room');
    $takeDate  = $req->query('check');
    $explode   = Str::of($takeDate)->explode('.');
    $mon       = $explode[1] . "." . $explode[2];
    $TakeMonth = DB::table('month')->where('month_year', '=', $mon)->first();

    $FirstTakeDate = DB::table('bron')
            ->where('room_id', $roomos)
            ->where('month_id', $TakeMonth->id)
            ->where('day', '=', $explode[0])->first();

    return view('ajax.reservation', compact(['FirstTakeDate']));
  }

  public function freeroom(Request $rq) {
    $daterange = $rq->query('daterange');
    $explode   = Str::of($daterange)->explode('-');

    $start_date = Str::of($explode[0])->trim();
    $start_end  = Str::of($explode[1])->trim();

    $sub_date_start        = Carbon::parse($start_date);
    $new_format_date_start = $sub_date_start->year . "-" . $sub_date_start->month . "-" . $sub_date_start->day;
    $sub_date_end          = Carbon::parse($start_end);
    $new_format_date_end   = $sub_date_end->year . "-" . $sub_date_end->month . "-" . $sub_date_end->day;

    $getRange = DB::table('bron')
        ->leftJoin('rooms', 'bron.room_id', '=', 'rooms.id_room')
        ->where('corpus', $rq->query('korpus'))
        ->whereBetween('month_year', [$new_format_date_start, $new_format_date_end])
        ->leftJoin('bron_info', 'bron.bron_info_id', '=', 'bron_info.id_bron')
        ->get();

    $free = 0;
    foreach ($getRange as $dates)
    {
//      $month = Carbon::parse($dates->month_year);
      $month                    = Str::of($dates->month_year)->explode('-');
      $freeshown[$free]['date'] = $month[2] . "." . $month[1] . "." . $month[0];
      $freeshown[$free]['room'] = $dates->room;
      $freeshown[$free]['vid']  = $dates->takeVid;
      $free++;
    }


    return view('ajax.freeroom', compact(['getRange', 'freeshown']));
  }

  public function listfreeroom(Request $rq) {
    $daterange = $rq->query('daterange');
    $explode   = Str::of($daterange)->explode('-');

    $start_date = Str::of($explode[0])->trim();
    $start_end  = Str::of($explode[1])->trim();

    $sub_date_start        = Carbon::parse($start_date);
    $new_format_date_start = $sub_date_start->year . "-" . $sub_date_start->month . "-" . $sub_date_start->day;
    $sub_date_end          = Carbon::parse($start_end);
    $new_format_date_end   = $sub_date_end->year . "-" . $sub_date_end->month . "-" . $sub_date_end->day;

    $getRange = DB::table('bron')
        ->leftJoin('rooms', 'bron.room_id', '=', 'rooms.id_room')
        ->where('corpus', $rq->query('korpus'))
        ->whereBetween('month_year', [$new_format_date_start, $new_format_date_end])
        ->leftJoin('bron_info', 'bron.bron_info_id', '=', 'bron_info.id_bron')
        ->whereNull('takeVid')
        ->get();

    $free = 0;
    foreach ($getRange as $dates)
    {
//      $month = Carbon::parse($dates->month_year);
      $month                      = Str::of($dates->month_year)->explode('-');
      $freeshown[$free]['date']   = $month[2] . "." . $month[1] . "." . $month[0];
      $freeshown[$free]['roomid'] = $dates->room_id;
      $freeshown[$free]['room']   = $dates->room;
      $freeshown[$free]['vid']    = $dates->takeVid;
      $free++;
    }

    return view('ajax.listfreeroom', compact(['getRange', 'freeshown']));
  }

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

    return true;
  }

  public function updateInfoRoom(Request $req) {
    $room       = $req->input('roomid');
    $price_room = $req->input('priceofroom');
    $number     = $req->input('roomnumber');
    DB::table('rooms')
        ->where('id_room', 1)
        ->update(['price' => $price_room]);

    /* ================== ЛОГИ ========================================================= */
    $LogAction = [
      'action'      => 'изменена цена',
      'id_room' => $room,
      'number_room' => $number,
      'price'       => $price_room,
      'commentar'   => null,
    ];

    $this->MyActionLogs(Auth::id(), $LogAction);
    /* ================== /ЛОГИ ========================================================= */
  }

  public function updateInfoComment(Request $req) {
    $room     = $req->input('roomid');
    $com_room = $req->input('commentofroom');
    $number   = $req->input('roomnumber');

    if ($com_room == '')
    {
      DB::table('rooms')
          ->where('id_room', $room)
          ->update(['comment' => null]);

      /* ================== ЛОГИ ========================================================= */
      $LogAction = [
        'action'      => 'комментарий удален',
        'id_room' => $room,
        'number_room' => $number,
        'price'       => null,
        'commentar'   => null,
      ];

      $this->MyActionLogs(Auth::id(), $LogAction);
      /* ================== /ЛОГИ ========================================================= */
    } else
    {
      DB::table('rooms')
          ->where('id_room', $room)
          ->update(['comment' => $com_room]);
    }

    /* ================== ЛОГИ ========================================================= */
    $LogAction = [
      'action'      => 'комментарий изменен',
      'id_room' => $room,
      'number_room' => $number,
      'price'       => null,
      'commentar'   => $com_room,
    ];

    $this->MyActionLogs(Auth::id(), $LogAction);
    /* ================== /ЛОГИ ========================================================= */
  }

}
