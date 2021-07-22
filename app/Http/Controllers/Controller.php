<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
/////////////////////////////////////////////////////////////
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    


  public function MyActionLogs($user,$actions){
      
    DB::table('action_logs')->insertOrIgnore([
      'user_id' => $user,
      'action' => json_encode($actions, JSON_UNESCAPED_UNICODE),
      'action_date' => date('Y-m-d'),
    ]);
    
    
    }
    
    
    
}
