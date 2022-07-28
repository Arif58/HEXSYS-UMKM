<?php

namespace App\Http\Controllers\Admin;

use DB;
use Auth;
use DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\AuthUser;
use App\Models\AuthConfiguration;
use App\Models\LogLogActivity;

class LogActivityController extends Controller{
    private $folder_path = 'admin.log-activity';

    function __construct(){
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function index(){
        $pageFileName = 'index';
        $title        = 'Log Aktivitas';
        $users        =  AuthUser::all();

        \LogActivityHelpers::saveLog(
            $logTp = 'visit', 
            $logNm = "Membuka Menu $title"
        );
        
        return view('sistem.' . $this->folder_path . '.' . $pageFileName, compact('title','users'));
    }

    /**
     * Display a listing of the resource for DataTables.
     *
     * @return \Illuminate\Http\Response
     */
    function getData(Request $request){
        $data = LogLogActivity::select(
                    'log_activity_id',
                    'log_activity.created_at',
                    'log_activity.user_id',
                    'user.user_nm',
                    'log_tp',
                    'log_nm',
                    'table',
                    'old_data',
                    'new_data',
                    'ip_address',
                    'user_agent',
                    'note',
                )
                ->join('auth.users as user', 'user.user_id','log_activity.user_id')
                ->where(function($where) use($request){
                    if (!is_null($request->tanggal)) {
                        $splitTanggal = explode("-",$request->tanggal);
                        $tanggalStart = formatDate($splitTanggal[0]);
                        $tanggalEnd   = formatDate($splitTanggal[1]);
            
                        $where->whereRaw("log_activity.created_at::date between '$tanggalStart' and '$tanggalEnd'");
                    }
                })
                ;

        return DataTables::of($data)
                ->addColumn('actions', function($data){
                    $actions = '';
                    // $actions .= "<button type='button' id='ubah'  class='btn btn-warning btn-flat btn-sm' data-toggle='tooltip' data-placement='top' title='Ubah Data'><i class='icon icon-pencil7'></i> </button> &nbsp";
                    // $actions .= "<button type='button' id='hapus' class='btn btn-danger btn-flat btn-sm' data-toggle='tooltip' data-placement='top' title='Hapus Data'><i class='icon icon-trash'></i> </button>";
                    
                    $actions .= "<button type='button' id='detail' class='btn btn-info btn-flat btn-sm' data-toggle='tooltip' data-placement='top' title='Detail Data'><i class='icon-folder-open2'></i> </button>";
                    
                    return $actions;
                })
                ->rawColumns(['actions'])
                ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    function store(Request $request){
        
        DB::beginTransaction();
        try {
            $data                       = AuthConfiguration::find('LOG_ST');
            $oldData = clone $data;
            $data->configuration_value  = $request->value;
            $data->updated_by           = Auth::user()->user_id;
            $data->save();

            \LogActivityHelpers::saveLog(
                $logTp = 'create', 
                $logNm = "Mengubah Status Log", 
                $table = $data->getTable(), 
                $newData = $data,
                $oldData = $oldData
                
            );

            DB::commit();
            return response()->json(['status' => 'ok'],200); 
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => 'error','error' => $e],200); 
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function show($id){
        $data= LogLogActivity::find($id);

        return response()->json(['status' => 'ok', 'data' => $data],200); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function destroy($id=NULL){
        if ($id) {
            $data = LogLogActivity::find($id);
            
            if ($data) {
                \LogActivityHelpers::saveLog(
                    $logTp   = 'delete', 
                    $logNm   = "Menghapus Data Log $id", 
                    $table   = $data->getTable(), 
                    $oldData = $data
                );
                
                LogLogActivity::destroy($id);
                
                return response()->json(['status' => 'ok'],200); 
            }else{
                return response()->json(['status' => 'error'],200); 
            }
        }else{
            $data = LogLogActivity::all();

            LogLogActivity::truncate();
            
            \LogActivityHelpers::saveLog(
                $logTp   = 'delete', 
                $logNm   = "Menghapus Semua Data Log", 
                $table   = "log.log_activity", 
                $newData = NULL,
                $oldData = $data
            );
            
            
            return response()->json(['status' => 'ok'],200); 
        }
    }
}
