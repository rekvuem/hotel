<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
  public function settinging(Request $request) {

    $TakeYear = DB::table('month')->get();
    $room_1 = DB::table('rooms')->where('corpus', 1)->get();
    $room_2 = DB::table('rooms')->where('corpus', 2)->get();
    return view('cabinet.settings', compact(['TakeYear','room_1','room_2']));
  }
}
