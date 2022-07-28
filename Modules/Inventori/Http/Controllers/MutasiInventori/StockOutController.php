<?php

namespace Modules\Inventori\Http\Controllers\MutasiInventori;

use DB;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\InvInvPosItemUnit;
use App\Models\InvInvPosInventori;
use App\Models\InvInvItemMove;

class StockOutController extends Controller{
    private $folder_path = 'mutasi-inventori.stock-out';
    
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
        $title         = 'Transaksi Barang Keluar';
        $gudangs       = InvInvPosInventori::all()->sortBy('pos_nm')
						 //->where('pos_root','')
						 ;

        return view('inventori::' . $this->folder_path . '.' . $pageFileName, compact('title','gudangs'));
    }

    /*
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function update(Request $request, $id){
        $this->validate($request,[
            'jumlah_trx' => 'required',
            'new_stock'  => 'required',
        ]);
        
        DB::transaction(function () use($request, $id) {
            $oldStock             = InvInvPosItemUnit::find($id);
    
            $newStock             = InvInvPosItemUnit::find($id);
            $newStock->quantity   = $oldStock->quantity - $request->jumlah_trx;
            $newStock->updated_by = Auth::user()->user_id;
            $newStock->save();

            $newMove                  = new InvInvItemMove;
            $newMove->pos_cd          = $oldStock->pos_cd;
            $newMove->pos_destination = $oldStock->pos_cd;
            $newMove->unit_cd         = $oldStock->unit_cd;
            $newMove->item_cd         = $oldStock->item_cd;
            $newMove->trx_by          = Auth::user()->user_id;
            $newMove->trx_datetime    = date('Y-m-d H:i:s');
            $newMove->trx_qty         = $request->jumlah_trx;
            $newMove->move_tp         = 'MOVE_TP_2';
            $newMove->old_stock       = $oldStock->quantity;
            $newMove->new_stock       = $oldStock->quantity-$request->jumlah_trx;
            $newMove->created_by      = Auth::user()->user_id;
            $newMove->save();
        });

        return response()->json(['status' => 'ok'],200); 
    }
}
