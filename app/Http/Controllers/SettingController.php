<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class SettingController extends Controller {

  public function settinging(Request $request) {

    $TakeYear = DB::table('month')->orderBy('month_year', 'asc')->paginate(16);
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
      'действие' => 'добавлен месяц',
      'месяц'    => $month_year,
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
    /* ================== ЛОГИ ========================================================= */
    $LogAction = [
      'действие'      => 'добавлена комната',
      'корпус'        => $korpus,
      'номер комнаты' => $room,
      'цена'          => $price,
      'комментарий'   => $commentar,
    ];

    $this->MyActionLogs(Auth::id(), $LogAction);
    /* ================== /ЛОГИ ========================================================= */

    return redirect()->route('cabinet.setting');
  }

  public function showactionlog() {
    $show_logs = DB::table('action_logs')
        ->leftJoin('users', 'action_logs.user_id', '=', 'users.id')
        ->orderBy('action_logs.action_date', 'desc')
        ->paginate(24);

    $j = 0;
    foreach ($show_logs as $log)
    {
      $jsons    = json_decode($log->action, true); //декодирование текста
      $new_date = Carbon::parse($log->action_date);

      $show_log[$j]['action_log_date'] = $new_date->format('d.m.Y H:i');
      $show_log[$j]['user_action']     = $log->imya . " " . $log->familia;
      $show_log[$j]['action']          = $jsons['действие'];

      if ($jsons['действие'] == 'быстрое изменение номера')
      {
        $show_log[$j]['type_action'] = $jsons['тип занятости'];
        $show_log[$j]['date_bron']   = $jsons['дата бронирование'];
        $show_log[$j]['number_room'] = $jsons['номер комнаты'];
        $show_log[$j]['fio']         = $jsons['фио'];
        $show_log[$j]['tel']         = $jsons['тел'];
        $show_log[$j]['com']         = $jsons['комментарий'];
      }
      elseif ($jsons['действие'] == 'изменена цена')
      {
        $show_log[$j]['room']  = $jsons['номер комнаты'];
        $show_log[$j]['price'] = $jsons['цена'];
        $show_log[$j]['com']   = $jsons['комментарий'];
      }
      elseif ($jsons['действие'] == 'комментарий удален')
      {
        $show_log[$j]['room'] = $jsons['номер комнаты'];
      }
      elseif ($jsons['действие'] == 'комментарий изменен')
      {
        $show_log[$j]['room'] = $jsons['номер комнаты'];
        $show_log[$j]['com']  = $jsons['комментарий'];
      }elseif($jsons['действие'] == 'добавлен месяц'){
        $show_log[$j]['month'] = $jsons['месяц'];
      }elseif($jsons['действие'] == 'бронирование номера'){
        $show_log[$j]['type_action'] = $jsons['тип занятости'];
        $show_log[$j]['date_bron']   = $jsons['дата бронирование'];
        $show_log[$j]['number_room'] = $jsons['номер комнаты'];
        $show_log[$j]['fio']         = $jsons['фио'];
        $show_log[$j]['tel']         = $jsons['тел'];
        $show_log[$j]['com']         = $jsons['комментарий'];
      }elseif($jsons['действие'] == 'удаление номера'){
        $show_log[$j]['date_bron']   = $jsons['удаление с даты'];
        $show_log[$j]['number_room'] = $jsons['комната'];
        $show_log[$j]['dating'] = $jsons['удаление с даты'];
      }elseif($jsons['действие'] == 'обновление'){
        $show_log[$j]['vid']   = $jsons['вид'];
        $show_log[$j]['edit'] = $jsons['изменения'];
        $show_log[$j]['dating'] = $jsons['дата'];
      }
      
      $j++;
    }
    return view('cabinet.showlog', compact(['show_log', 'show_logs']));
  }

}
