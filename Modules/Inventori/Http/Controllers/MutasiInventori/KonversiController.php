<?php

namespace Modules\Inventori\Http\Controllers\MutasiInventori;

use DB;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\InvInvPosItemUnit;
use App\Models\InvInvPosInventori;
use App\Models\InvInvItemMaster;
use App\Models\InvInvItemMove;
use App\Models\InvInvItemUnit;

class KonversiController extends Controller
{
    private $folder_path = 'mutasi-inventori.konversi';
    function __construct(){
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $pageFileName  = 'index';
        $title         = 'Konversi Barang';
        $gudangs       = InvInvPosInventori::all()->sortBy('pos_nm')
						 //->where('pos_root','')
						 ;
        $items         = InvInvItemMaster::all();


        return view('inventori::' . $this->folder_path . '.' . $pageFileName, compact('title','gudangs','items'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('inventori::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('inventori::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('inventori::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    function update(Request $request, $id){
        $this->validate($request,[
            'jumlah_trx'         => 'required',
            'pos_cd_destination' => 'required',
            'target_item_cd'     => 'required',
        ]);
        
        $oldStockSource             = InvInvPosItemUnit::find($id);
        if (($oldStockSource->quantity - $request->jumlah_trx)<0){
                return response()->json(['status' => 'error','message' => 'konversi melebihi stok'],200); 
        }
        
        DB::transaction(function () use($request, $id, $oldStockSource) {
            $newStockSource             = InvInvPosItemUnit::find($id);
            $newStockSource->quantity   = $oldStockSource->quantity - $request->jumlah_trx;
            $newStockSource->updated_by = Auth::user()->user_id;
            $newStockSource->save();

            $checkDestination = InvInvPosItemUnit::where('item_cd',$request->target_item_cd)
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
                $oldStockDestination->item_cd   = $request->target_item_cd;
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
            $newMove->move_tp         = 'MOVE_TP_4';
            $newMove->old_stock       = $oldStockSource->quantity;
            $newMove->new_stock       = $oldStockSource->quantity - $request->jumlah_trx;
            $newMove->created_by      = Auth::user()->user_id;
            $newMove->save();
        });

        return response()->json(['status' => 'ok'],200); 
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    function konversiMulti(Request $request){
        $this->validate($request,[
            'positemunit_cd'  => 'required',
            'jumlah_konversi' => 'required',
        ]);
        DB::transaction(function () use($request) {
            //kurangi stok barang multi
            $oldStock             = InvInvPosItemUnit::find($request->positemunit_cd);
    
            $newStock             = InvInvPosItemUnit::find($request->positemunit_cd);
            $newStock->quantity   = $oldStock->quantity - $request->jumlah_konversi;
            $newStock->updated_by = Auth::user()->user_id;
            $newStock->save();
            //simpan transaksi
            $newMove                  = new InvInvItemMove;
            $newMove->pos_cd          = $oldStock->pos_cd;
            $newMove->pos_destination = $oldStock->pos_cd;
            $newMove->unit_cd         = $oldStock->unit_cd;
            $newMove->item_cd         = $oldStock->item_cd;
            $newMove->trx_by          = Auth::user()->user_id;
            $newMove->trx_datetime    = date('Y-m-d H:i:s');
            $newMove->trx_qty         = $request->jumlah_konversi;
            $newMove->move_tp         = 'MOVE_TP_4';
            $newMove->old_stock       = $oldStock->quantity;
            $newMove->new_stock       = $oldStock->quantity-$request->jumlah_konversi;
            $newMove->created_by      = Auth::user()->user_id;
            $newMove->save();
            //cari konversi dan item root multi
            $konversi   = InvInvItemUnit::where('item_cd',$oldStock->item_cd)
                            ->where('unit_cd',$oldStock->unit_cd)
                            ->first()->conversion;
            $itemMaster = InvInvItemMaster::find($oldStock->item_cd);
            //tambah stok barang root multi
            $oldStock             = InvInvPosItemUnit::where('item_cd',$itemMaster->item_cd)
                                        ->where('unit_cd',$itemMaster->unit_cd)
                                        ->where('pos_cd',$oldStock->pos_cd)
                                        ->first();
    
            $newStock             = InvInvPosItemUnit::where('item_cd',$itemMaster->item_cd)
                                        ->where('unit_cd',$itemMaster->unit_cd)
                                        ->where('pos_cd',$oldStock->pos_cd)
                                        ->first();
            $newStock->quantity   = $oldStock->quantity + $konversi*$request->jumlah_konversi;
            $newStock->updated_by = Auth::user()->user_id;
            $newStock->save();
            //simpan transaksi
            $newMove                  = new InvInvItemMove;
            $newMove->pos_cd          = $oldStock->pos_cd;
            $newMove->pos_destination = $oldStock->pos_cd;
            $newMove->unit_cd         = $oldStock->unit_cd;
            $newMove->item_cd         = $oldStock->item_cd;
            $newMove->trx_by          = Auth::user()->user_id;
            $newMove->trx_datetime    = date('Y-m-d H:i:s');
            $newMove->trx_qty         = $konversi*$request->jumlah_konversi;
            $newMove->move_tp         = 'MOVE_TP_4';
            $newMove->old_stock       = $oldStock->quantity;
            $newMove->new_stock       = $oldStock->quantity + $konversi*$request->jumlah_konversi;
            $newMove->created_by      = Auth::user()->user_id;
            $newMove->save();
            
        });

        return response()->json(['status' => 'ok'],200); 
    }
}
