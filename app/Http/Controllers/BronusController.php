<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;


class BronusController extends Controller {

  public function fullShowRoomOne(Request $r) {

    $korpus = $r->query('korpus');

    $select_month = DB::table('user_active_year')->where('user_id', Auth::id())->first();

    $month = DB::table('month')->where('id', $select_month->month_id)->first();

    IF (empty($month->year))
    {
      abort('403', 'Активируйте актуальный месяц в настройках!');
    }

    $carbon_month = Carbon::parse($month->year . '-' . $month->month);
    $carbon_days  = $carbon_month->daysInMonth;

    $TakeRoom = DB::table('bron')
            ->leftJoin('rooms', 'bron.room_id', '=', 'rooms.id_room')
            ->where('corpus', $korpus)
            ->select('room_id', 'room')
            ->where('month_id', $month->id)
            ->groupBy('room_id', 'room')->get();

    $TakeRoomys = DB::table('bron')
        ->leftJoin('rooms', 'bron.room_id', '=', 'rooms.id_room')
        ->where('corpus', $korpus)
        ->leftJoin('bron_info', 'bron.bron_info_id', '=', 'bron_info.id_bron')
        ->where('month_id', $month->id)
        ->leftJoin('month', 'bron.month_id', '=', 'month.id')
        ->where('month_id', $month->id)
        ->get();

//    массив с ключами для быстрого определения и построения таблиц с данными
    $rs = 0;
    foreach ($TakeRoomys as $idroom)
    {
      $takemyroom[$rs]['rowid']   = $idroom->id;
      $takemyroom[$rs]['bornid']  = $idroom->id_bron;
      $takemyroom[$rs]['roomid']  = $idroom->room_id;
      $takemyroom[$rs]['monthid'] = $idroom->month_id;
      $takemyroom[$rs]['day']     = $idroom->day;
      $takemyroom[$rs]['month']   = $idroom->month_year;
      $takemyroom[$rs]['bron']    = $idroom->bron_info_id;

      $takemyroom[$rs]['start_date'] = $idroom->bron_start_date;
      $takemyroom[$rs]['end_date']   = $idroom->bron_end_date;

      $takemyroom[$rs]['takeVid'] = $idroom->takeVid;
      $takemyroom[$rs]['fio']     = $idroom->fio;
      $takemyroom[$rs]['telehon'] = $idroom->telehon;
      $takemyroom[$rs]['comment'] = $idroom->comment;

      $rs++;
    }

    return view('cabinet.fulllist', compact([
      'TakeRoomys', 'TakeRoom', 'carbon_days', 'takemyroom',
    ]));
  }

  public function inserToBron(Request $req) {
//  $data = $req->only(['takeVid', 'fio', 'telephon', 'forText']);
    $korpus          = $req->input('takeKorp');
    $roomos          = $req->input('room');
    $get_date_range  = $req->input('takeBron_range');
    $takeVid         = $req->input('takeVid');
    $fio             = $req->input('fio');
    $tel             = $req->input('telephon');
    $forText         = $req->input('forText');
    /* ======================================================================================== */
    $range_date      = Str::of($get_date_range)->explode('-');
    $Day_start       = Str::of($range_date[0])->substr(0, 2); //показать день
    $shortDate_start = Str::of($range_date[0])->substr(3);  //показать месяц и год
    $str_date_start  = Str::of($shortDate_start)->trim(); //показать месяц и год без пробела
    $expl_start      = Str::of($str_date_start)->explode('.');
    $Day_end         = Str::of($range_date[1])->substr(1, 2); //показать день
    $shortDate_end   = Str::of($range_date[1])->substr(4);  //показать месяц и год
    $str_date_end    = Str::of($shortDate_end)->trim(); //показать месяц и год без пробела
    $expl_end        = Str::of($str_date_end)->explode('.');

    $z_start = $expl_start[1] . "-" . $expl_start[0] . "-" . $Day_start;
    $z_end   = $expl_end[1] . "-" . $expl_end[0] . "-" . $Day_end;

    $z_format_start = $Day_start . "." . $expl_start[0] . "." . $expl_start[1];
    $z_format_end   = $Day_end . "." . $expl_end[0] . "." . $expl_end[1];
//  dd([$range_date,$Day_start,$shortDate_start,$str_date_start,$expl_start,$Day_end,$shortDate_end,$str_date_end,$expl_end]);
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
        ->whereBetween('month_year', [$z_start, $z_end])
        ->update([
          'bron_info_id' => $bron_info,
    ]);

    /* ================== ЛОГИ ========================================================= */
    $select_number = DB::table('rooms')->where('id_room', $roomos)->first();
    $LogAction     = [
      'действие'          => 'бронирование номера',
      'тип занятости'     => $takeVid,
      'дата бронирование' => $z_format_start . '-' . $z_format_end,
      'корпус'            => $korpus,
      'ид комната'        => $roomos,
      'номер комнаты'     => $select_number->room,
      'фио'               => $fio,
      'тел'               => $tel,
      'комментарий'       => $forText,
    ];
    $this->MyActionLogs(Auth::id(), $LogAction);
    /* ================== /ЛОГИ ========================================================= */

    session()->flash('checkroom', 'Номер забронирован с ' . $z_format_start . ' по ' . $z_format_end);

    return redirect()->route('cabinet.dashboard');
  }

}
