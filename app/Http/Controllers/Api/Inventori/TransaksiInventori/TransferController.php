<?php

namespace App\Http\Controllers\Api\Inventori\TransaksiInventori;

use App\Http\Controllers\Controller;
use App\Models\InvInvItemMove;
use App\Models\InvInvPosItemUnit;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransferController extends Controller
{
    function update(Request $request, $id){
        try {
            $this->validate($request,[
                'jumlah_trx'         => 'required',
                'pos_cd_destination' => 'required',
            ]);
            //code...
            DB::transaction(function() use($request, $id) {
                // dd($request->all());
                $oldStockSource = InvInvPosItemUnit::find($id);
                $newStockSource = InvInvPosItemUnit::find($id);
                
                $newStockSource->update([
                    'quantity' => $oldStockSource->quantity - $request->jumlah_trx,
                    'updated_by' => Auth::user()->user_id,
                    // 'updated_at' => now()
                ]);

                $checkDestination = InvInvPosItemUnit::where('item_cd', $oldStockSource->item_cd)
                    ->where('unit_cd', $oldStockSource->unit_cd)
                    ->where('pos_cd', $request->pos_cd_destination)
                    ->first();
                
                if ($checkDestination) {
                    $oldStockDestination = InvInvPosItemUnit::find($checkDestination->positemunit_cd);
                    $oldStockDestination->update([
                        'quantity' => $oldStockDestination->quantity + $request->jumlah_trx,
                        'updated_by' => Auth::user()->user_id,
                        // 'updated_at' => now()
                    ]);
                } else {
                    $oldStockDestination = InvInvPosItemUnit::create([
                        'pos_cd' => $request->pos_cd_destionation,
                        'unit_cd' => $oldStockSource->unit_cd,
                        'item_cd' => $oldStockSource->item_cd,
                        'quantity' => $request->jumlah_trx,
                        'created_by' => Auth::user()->user_id,
                        // 'created_at' => now()
                    ]);
                }

                $newMove = InvInvItemMove::create([
                    'pos_cd'          => $oldStockSource->pos_cd,
                    'pos_destination' => $oldStockSource->pos_cd,
                    'unit_cd '        => $oldStockSource->unit_cd,
                    'item_cd'         => $oldStockSource->item_cd,
                    'pos_cd '         => Auth::user()->unit_cd,
                    'trx_by'          => Auth::user()->user_id,
                    'trx_datetime'    => date('Y-m-d H:i:s'),
                    'trx_qty'         => $request->jumlah_trx,
                    'move_tp'         => 'MOVE_TP_1',
                    'old_stock'       => $oldStockSource->quantity,
                    'new_stock'       => $oldStockSource->quantity+$request->jumlah_trx,
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
}
