<?php

namespace Modules\Inventori\Http\Controllers\MutasiInventori;

use DB;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\InvInvPosItemUnit;
use App\Models\InvInvPosInventori;
use App\Models\InvInvItemMove;

class TransferController extends Controller{
    private $folder_path = 'mutasi-inventori.transfer';
    
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
        $title         = 'Transfer Barang';
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
            'jumlah_trx'         => 'required',
            'pos_cd_destination' => 'required',
        ]);
        
        DB::transaction(function () use($request, $id) {
            $oldStockSource             = InvInvPosItemUnit::find($id);
    
            $newStockSource             = InvInvPosItemUnit::find($id);
            $newStockSource->quantity   = $oldStockSource->quantity - $request->jumlah_trx;
            $newStockSource->updated_by = Auth::user()->user_id;
            $newStockSource->save();

            $checkDestination = InvInvPosItemUnit::where('item_cd',$oldStockSource->item_cd)
                                    ->where('unit_cd',$oldStockSource->unit_cd)
                                    ->where('pos_cd',$request->pos_cd_destination)
                                    ->first();
            
            if ($checkDestination) {
                $oldStockDestination             = InvInvPosItemUnit::find($checkDestination->positemunit_cd);
                $oldStockDestination->quantity   = $oldStockDestination->quantity + $request->jumlah_trx;
                $oldStockDestination->updated_by = Auth::user()->user_id;
                $oldStockDestination->save();
            }else{
                $oldStockDestination            = new InvInvPosItemUnit;
                $oldStockDestination->pos_cd    = $request->pos_cd_destination;
                $oldStockDestination->unit_cd   = $oldStockSource->unit_cd;
                $oldStockDestination->item_cd   = $oldStockSource->item_cd;
                $oldStockDestination->quantity  = $request->jumlah_trx;
                $oldStockDestination->created_by= Auth::user()->user_id;
                $oldStockDestination->save();
            }

            $newMove                  = new InvInvItemMove;
            $newMove->pos_cd          = $oldStockSource->pos_cd;
            $newMove->pos_destination = $request->pos_cd_destination;
            $newMove->unit_cd         = $oldStockSource->unit_cd;
            $newMove->item_cd         = $oldStockSource->item_cd;
            $newMove->pos_cd = Auth::user()->unit_cd;
            $newMove->trx_by          = Auth::user()->user_id;
            $newMove->trx_datetime    = date('Y-m-d H:i:s');
            $newMove->trx_qty         = $request->jumlah_trx;
            $newMove->move_tp         = 'MOVE_TP_3';
            $newMove->old_stock       = $oldStockSource->quantity;
            $newMove->new_stock       = $oldStockSource->quantity - $request->jumlah_trx;
            $newMove->created_by      = Auth::user()->user_id;
            $newMove->save();
        });

        return response()->json(['status' => 'ok'],200); 
    }
}
