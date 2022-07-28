<?php

namespace Modules\Inventori\Http\Controllers\Report;

use DB;
use Auth;
use DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\InvVwInvTrxHistory;
use App\Models\InvInvPosInventori;

class HistoryController extends Controller{
    private $folder_path = 'report.history';
    
    function __construct(){
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function index(){
        $pageFileName  = 'index';
        $title         = 'Laporan Kartu Stok';
        $gudangs       = InvInvPosInventori::all()->sortBy('pos_nm')
						 //->where('pos_root','')
						 ;

        return view('inventori::' . $this->folder_path . '.' . $pageFileName, compact('title','gudangs'));
    }

    /**
     * Display a listing of the resource for DataTables.
     *
     * @return \Illuminate\Http\Response
     */
    function getData(Request $request){
		$data = InvVwInvTrxHistory::select('*')
				->where(function($where) use($request){
					//$unit = empty(Auth::user()->unit_cd) ? '' : Auth::user()->unit_cd;
					//if ($unit != '') {
                    //    $where->where('pos_destination',[$unit]);
                    //}
					
					if ($request->has('tanggal_param')) {
						$splitTanggal = explode("-",$request->tanggal_param);
						$tanggalStart = formatDate($splitTanggal[0]);
						$tanggalEnd   = formatDate($splitTanggal[1]);
			
						$where->whereRaw("trx_datetime::date between '$tanggalStart' and '$tanggalEnd'");
					}
				});
		
		return DataTables::of($data)->make(true);
    }
}
