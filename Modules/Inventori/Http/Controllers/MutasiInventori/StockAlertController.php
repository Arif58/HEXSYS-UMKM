<?php

namespace Modules\Inventori\Http\Controllers\MutasiInventori;

use Auth;
use DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\InvInvPosInventori;
use App\Models\InvVwStockAlert;
use App\Models\InvVwStockExpired;

class StockAlertController extends Controller{
    private $folder_path = 'mutasi-inventori.stock-alert';

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
        $title         = 'Stock Alert';
        $gudangs       = InvInvPosInventori::all()->sortBy('pos_nm');//->where('pos_root','');

        return view('inventori::' . $this->folder_path . '.' . $pageFileName, compact('title','gudangs'));
    }

    /**
     * Display a listing of the resource for DataTables.
     *
     * @return \Illuminate\Http\Response
     */
    function getData(Request $request){
        $pos = Auth::user()->unit_cd;
        if($pos != null ) {
            if ($request->type == 'alert') {
                $data=InvVwStockAlert::query()->where('pos_cd', $pos);
            }else{
                $data=InvVwStockExpired::query()->where('pos_cd', $pos);
            }
        } else {
            if ($request->type == 'alert') {
                $data=InvVwStockAlert::query();
            }else{
                $data=InvVwStockExpired::query();
            }
        }

        return DataTables::of($data)->make(true);
    }
}
