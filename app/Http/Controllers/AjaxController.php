<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AjaxController extends Controller {

  public function updatetypebron(Request $req) {
    $bron = $req->input('bron');
    $vid  = $req->input('takeVid');

    $take_old_vid=DB::table('bron_info')->where('id_bron', $bron)->first();
    
    DB::table('bron_info')->where('id_bron', $bron)->update([
      'takeVid' => $vid
    ]);

    /* ================== ЛОГИ ========================================================= */
    $date_start = Carbon::parse($take_old_vid->bron_start_date)->format('d.m.Y');
    $date_end = Carbon::parse($take_old_vid->bron_end_date)->format('d.m.Y');
    $LogAction = [
      'действие' => 'обновление',
      'вид' => 'смена вида бронирования',
      'изменения' => 'изменено с '.$take_old_vid->takeVid.' на '. $vid,
      'дата' => ''.$date_start.' - '.$date_end,
    ];
    $this->MyActionLogs(Auth::id(), $LogAction);
    /* ================== /ЛОГИ ========================================================= */
  }

  /*   * ********************************************************************************************************** */

  public function deletetypebron(Request $req) {
    $bron       = $req->input('bronus');
    $room       = $req->input('room');
    $start_date = $req->input('start_date');
    $end_date   = $req->input('end_date');

    $dd_room= DB::table('rooms')->where('id_room', $room)->first();
    DB::table('bron_info')->where('id_bron', $bron)->delete();
    DB::table('bron')->where('bron_info_id', $bron)->where('room_id', $room)->whereBetween('month_year', [$start_date, $end_date])
        ->update(['bron_info_id' => null]);

    /* ================== ЛОГИ ========================================================= */
    $date_start = Carbon::parse($start_date)->format('d.m.Y');
    $date_end = Carbon::parse($end_date)->format('d.m.Y');
    $LogAction = [
      'действие'         => 'удаление номера',
      'комната'          => $dd_room->room,
      'удаление с даты' => $date_start . " - " . $date_end,
    ];
    $this->MyActionLogs(Auth::id(), $LogAction);
    /* ================== /ЛОГИ ========================================================= */
  }

  /*   * ********************************************************************************************************** */

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

  /* ========================================свободные комнаты===================================================== */

  public function freeroom(Request $rq) {
    $daterange = $rq->query('daterange');
    $korpus    = $rq->query('korpus');
    $explode   = Str::of($daterange)->explode('-');

    $start_date = Str::of($explode[0])->trim();
    $start_end  = Str::of($explode[1])->trim();

    $sub_date_start        = Carbon::parse($start_date);
    $new_format_date_start = $sub_date_start->format('Y-m-d');
    $sub_date_end          = Carbon::parse($start_end);
    $new_format_date_end   = $sub_date_end->format('Y-m-d');

    $getRoom = DB::table('rooms')->where('corpus', $korpus)->get();

    $getRange = DB::table('bron')
        ->leftJoin('rooms', 'bron.room_id', '=', 'rooms.id_room')
        ->where('corpus', $korpus)
        ->whereBetween('month_year', [$new_format_date_start, $new_format_date_end])
        ->leftJoin('bron_info', 'bron.bron_info_id', '=', 'bron_info.id_bron')
        ->get();

    $free = 0;
    foreach ($getRange as $dates)
    {
//      $month = Carbon::parse($dates->month_year);
      $month                            = Str::of($dates->month_year)->explode('-');
      $freeshown[$free]['date']         = $month[2] . "." . $month[1] . "." . $month[0];
      /* ===================================== */
      $freeshown[$free]['idroom']       = $dates->id_room; // информация с базы данных комнат rooms
      $freeshown[$free]['roomid']       = $dates->room_id; // информация с базы по бронированию
      $freeshown[$free]['room']         = $dates->room; // информация номера комнаты с базы данных комнат rooms
      $freeshown[$free]['price']        = $dates->price; // информация цены комнаты с базы данных комнат rooms
      /* ===================================== */
      $new_start_format_date            = Carbon::parse($dates->bron_start_date); //данные бронирования с началы даты
      $freeshown[$free]['bron_st_date'] = $new_start_format_date->format('d.m.Y');
      $new_end_format_date              = Carbon::parse($dates->bron_end_date);  //данные бронирования с конец даты
      $freeshown[$free]['bron_en_date'] = $new_end_format_date->format('d.m.Y');
      /* ===================================== */
      $freeshown[$free]['vid']          = $dates->takeVid;
      $freeshown[$free]['fio']          = $dates->fio;
      $freeshown[$free]['tel']          = $dates->telehon;
      $freeshown[$free]['com']          = $dates->comment;
      $free++;
    }


    return view('ajax.freeroom', compact(['getRoom', 'getRange', 'freeshown']));
  }

  /*   * ********************************************************************************************************** */

  public function listfreeroom(Request $rq) {

//    $room      = $rq->query('roomid');
    $daterange = $rq->query('daterange');
    $korpus    = $rq->query('korpus');

    $explode = Str::of($daterange)->explode('-');

    $start_date = Str::of($explode[0])->trim();
    $start_end  = Str::of($explode[1])->trim();

    $sub_date_start        = Carbon::parse($start_date);
    $new_format_date_start = $sub_date_start->format('Y-m-d');
    $sub_date_end          = Carbon::parse($start_end);
    $new_format_date_end   = $sub_date_end->format('Y-m-d');

    $getRoom = DB::table('rooms')->where('corpus', $korpus)->get();

    $getRange = DB::table('bron')
        ->leftJoin('rooms', 'bron.room_id', '=', 'rooms.id_room')
        ->where('corpus', $korpus)
        ->whereBetween('month_year', [$new_format_date_start, $new_format_date_end])
        ->leftJoin('bron_info', 'bron.bron_info_id', '=', 'bron_info.id_bron')
        ->whereNull('takeVid')
        ->get();

    $free = 0;
    foreach ($getRange as $dates)
    {
      $month                      = Str::of($dates->month_year)->explode('-');
      $freeshown[$free]['date']   = $month[2] . "." . $month[1] . "." . $month[0];
      $freeshown[$free]['idroom'] = $dates->id_room;
      $freeshown[$free]['roomid'] = $dates->room_id;
      $freeshown[$free]['room']   = $dates->room;
      $freeshown[$free]['vid']    = $dates->takeVid;
      $free++;
    }

    return view('ajax.listfreeroom', compact(['getRoom', 'getRange', 'freeshown']));
  }

  /*   * ********************************************************************************************************** */

  public function shownoneroom(Request $rq) {

    $room      = $rq->query('roomid');
    $daterange = $rq->query('daterange');
    $korpus    = $rq->query('korpus');

    $explode = Str::of($daterange)->explode('-');

    $start_date = Str::of($explode[0])->trim();
    $start_end  = Str::of($explode[1])->trim();

    $sub_date_start        = Carbon::parse($start_date);
    $new_format_date_start = $sub_date_start->format('Y-m-d');
    $sub_date_end          = Carbon::parse($start_end);
    $new_format_date_end   = $sub_date_end->format('Y-m-d');

    $getRoom = DB::table('rooms')->where('corpus', $korpus)->get();

    $getRange = DB::table('bron')
        ->leftJoin('rooms', 'bron.room_id', '=', 'rooms.id_room')
        ->where('corpus', $korpus)
        ->where('id_room', $room)
        ->whereBetween('month_year', [$new_format_date_start, $new_format_date_end])
        ->leftJoin('bron_info', 'bron.bron_info_id', '=', 'bron_info.id_bron')
        ->get();

    $free = 0;
    foreach ($getRange as $dates)
    {
      $month                            = Str::of($dates->month_year)->explode('-');
      $freeshown[$free]['date']         = $month[2] . "." . $month[1] . "." . $month[0];
      /* ===================================== */
      $freeshown[$free]['idroom']       = $dates->id_room; // информация с базы данных комнат rooms
      $freeshown[$free]['roomid']       = $dates->room_id; // информация с базы по бронированию
      $freeshown[$free]['room']         = $dates->room; // информация номера комнаты с базы данных комнат rooms
      $freeshown[$free]['price']        = $dates->price; // информация цены комнаты с базы данных комнат rooms
      /* ===================================== */
      $new_start_format_date            = Carbon::parse($dates->bron_start_date); //данные бронирования с началы даты
      $freeshown[$free]['bron_st_date'] = $new_start_format_date->format('d.m.Y');
      $new_end_format_date              = Carbon::parse($dates->bron_end_date);  //данные бронирования с конец даты
      $freeshown[$free]['bron_en_date'] = $new_end_format_date->format('d.m.Y');
      /* ===================================== */
      $freeshown[$free]['vid']          = $dates->takeVid;
      $freeshown[$free]['fio']          = $dates->fio;
      $freeshown[$free]['tel']          = $dates->telehon;
      $freeshown[$free]['com']          = $dates->comment;
      $free++;
    }

    return view('ajax.onefreeroom', compact(['getRoom', 'getRange', 'freeshown']));
  }

  public function updateInfoRoom(Request $req) {
    $room       = $req->input('roomid');
    $price_room = $req->input('priceofroom');
    $number     = $req->input('roomnumber');
    DB::table('rooms')
        ->where('id_room', $room)
        ->update(['price' => $price_room]);

    /* ================== ЛОГИ ========================================================= */
    $LogAction = [
      'действие'      => 'изменена цена',
      'номер комнаты' => $number,
      'цена'          => $price_room,
      'комментарий'   => null,
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
        'действие'      => 'комментарий удален',
        'номер комнаты' => $number,
        'цена'          => null,
        'комментарий'   => null,
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
      'действие'      => 'комментарий изменен',
      'номер комнаты' => $number,
      'цена'          => null,
      'комментарий'   => $com_room,
    ];

    $this->MyActionLogs(Auth::id(), $LogAction);
    /* ================== /ЛОГИ ========================================================= */
  }

}
