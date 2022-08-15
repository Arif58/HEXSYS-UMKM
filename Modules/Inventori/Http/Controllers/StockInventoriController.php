<?php

namespace Modules\Inventori\Http\Controllers;

use Auth;

use DataTables;
use App\Models\AuthRole;
use Illuminate\Http\Request;
use App\Models\InvInvPosItemUnit;
use App\Models\InvInvPosInventori;
use App\Models\InvVwStockInventory;
use App\Http\Controllers\Controller;

class StockInventoriController extends Controller{
    private $folder_path = 'stock-inventori';

    function __construct(){
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function index(){
        $filename_page = 'index';
        $title         = 'Data Stok Inventori';
        $gudangs       = InvInvPosInventori::all()->sortBy('pos_nm');//->where('pos_root','');
        $roles         = AuthRole::getAllRoles(Auth::user()->role->role_cd);
		//$gudangs       = InvInvPosInventori::all()->sortByDesc('pos_nm');

        return view('inventori::' . $this->folder_path . '.' . $filename_page, compact('title','roles','gudangs'));
    }

    /**
     * Display a listing of the resource for DataTables.
     *
     * @return \Illuminate\Http\Response
     */
    function getData(){
        $posCd = configuration('WHPOS_TRX');

        $data = InvInvPosItemUnit::select(
                    "inv_pos_itemunit.positemunit_cd",
                    "inv_pos_itemunit.pos_cd",
                    "pos.pos_nm",
                    "inv_pos_itemunit.item_cd",
                    "master.item_nm",
                    "master.item_price",
                    "master.item_price_buy",
                    "inv_pos_itemunit.unit_cd",
                    "unit.unit_nm",
                    "inv_pos_itemunit.quantity"
                )
				/* ->where(function($where) use($posCd){
					$unit = empty(Auth::user()->unit_cd) ? $posCd : Auth::user()->unit_cd;
					if ($unit !== '') {
						$where->where('inv_pos_itemunit.pos_cd',[$unit]);
					}
				}) */
                ->join('inv.inv_pos_inventori as pos','pos.pos_cd','inv_pos_itemunit.pos_cd')
                ->join('inv.inv_item_master as master','master.item_cd','inv_pos_itemunit.item_cd')
                ->join('inv.inv_unit as unit','unit.unit_cd','inv_pos_itemunit.unit_cd')
				->orderBy('pos_nm')
				->orderBy('item_nm')
				->where('inventory_st','1')
                //->where('inv_pos_itemunit.pos_cd', $posCd)
                ;
        return DataTables::of($data)->make(true);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function show($id){
        $stock  = InvInvPosItemUnit::select(
            "inv_pos_itemunit.positemunit_cd",
            "inv_pos_itemunit.pos_cd",
            "pos.pos_nm",
            "inv_pos_itemunit.item_cd",
            "master.item_nm",
            "master.item_price",
            "master.item_price_buy",
            "inv_pos_itemunit.unit_cd",
            "unit.unit_nm",
            "inv_pos_itemunit.quantity"
        )
        ->join('inv.inv_pos_inventori as pos','pos.pos_cd','inv_pos_itemunit.pos_cd')
        ->join('inv.inv_item_master as master','master.item_cd','inv_pos_itemunit.item_cd')
        ->join('inv.inv_unit as unit','unit.unit_cd','inv_pos_itemunit.unit_cd')
        ->where('inv_pos_itemunit.positemunit_cd', $id)
        ->first();

        if($stock){
            return response()->json(['status' => 'ok', 'data' => $stock],200);
        }else{
            return response()->json(['status' => 'failed', 'data' => 'not found'],200);
        }
    }
}
