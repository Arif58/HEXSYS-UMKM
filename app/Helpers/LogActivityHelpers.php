<?php
namespace App\Helpers;

use Auth;
use Request;
use App\Models\LogLogActivity as LogActivityModel;

class LogActivityHelpers {
    public static function saveLog($logTp, $logNm, $table = NULL, $newData = NULL, $oldData = NULL){
        if(configuration('LOG_ST') == 'ON'){
            $log              = new LogActivityModel;
            $log->user_id     = Auth::user()->user_id;
            $log->log_tp      = $logTp;
            $log->log_nm      = $logNm;
            $log->table       = $table ? $table : 'No Table';
            $log->old_data    = json_encode($oldData);
            $log->new_data    = json_encode($newData);
            $log->ip_address  = Request::ip();
            $log->user_agent  = Request::header('user-agent');
            $log->created_by  = Auth::user()->user_id;
            $log->save();

            return true;
        }else{
            return true;
        }
    }
}