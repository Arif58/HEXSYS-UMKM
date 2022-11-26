<?php

namespace App\Http\Controllers\Api\Inventori\TransaksiInventori;

use App\Http\Controllers\Controller;
use App\Models\InvInvItemMove;
use App\Models\InvInvPosItemUnit;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockOutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pos = Auth::user()->unit_cd;
        $stockIn = InvInvPosItemUnit::select(
            "inv_pos_itemunit.positemunit_cd",
                    "inv_pos_itemunit.pos_cd",
                    "pos.pos_nm",
                    "inv_pos_itemunit.item_cd",
                    "master.item_nm",
                    // "master.item_price",
                    // "master.item_price_buy",
                    "inv_pos_itemunit.unit_cd",
                    "unit.unit_nm",
                    "inv_pos_itemunit.quantity"
        )
        ->join('inv.inv_pos_inventori as pos','pos.pos_cd','inv_pos_itemunit.pos_cd')
                ->join('inv.inv_item_master as master','master.item_cd','inv_pos_itemunit.item_cd')
                ->join('inv.inv_unit as unit','unit.unit_cd','inv_pos_itemunit.unit_cd')
				->orderBy('pos_nm')
				->orderBy('item_nm')
				->where('inv_pos_itemunit.pos_cd', $pos)->get();

        $response = [
            'status' => 'success',
            'data' => $stockIn
        ];
        return response()->json($response, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function update(Request $request, $id){
        // $this->validate($request,[
        //     'jumlah_trx' => 'required',
        //     'new_stock'  => 'required',
        // ]);
        
        try {
            //code...
            DB::transaction(function() use($request, $id) {
                $oldStock = InvInvPosItemUnit::find($id);
                $newStock = InvInvPosItemUnit::find($id);
                
                $newStock->update([
                    'quantity' => $oldStock->quantity- $request->jumlah_trx,
                    'updated_by' => Auth::user()->user_id,
                    // 'updated_at' => now()
                ]);

                $newMove = InvInvItemMove::create([
                    'pos_cd'          => $oldStock->pos_cd,
                    'pos_destination' => $oldStock->pos_cd,
                    'unit_cd '        => $oldStock->unit_cd,
                    'item_cd'         => $oldStock->item_cd,
                    'pos_cd '         => Auth::user()->unit_cd,
                    'trx_by'          => Auth::user()->user_id,
                    'trx_datetime'    => date('Y-m-d H:i:s'),
                    'trx_qty'         => $request->jumlah_trx,
                    'move_tp'         => 'MOVE_TP_1',
                    'old_stock'       => $oldStock->quantity,
                    'new_stock'       => $oldStock->quantity+$request->jumlah_trx,
                    'created_by'      => Auth::user()->user_id,
                ]);
            });
            // $stock->update($request->all());
            
            $response = [
                'status' => 'success',
                // 'data' => $newStock
            ];
            return response()->json($response, 200);
          
        } catch (QueryException $e) {
            //throw $th;
            return response()->json([
                'message' => 'Failed'
            ]);
        }
     
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
