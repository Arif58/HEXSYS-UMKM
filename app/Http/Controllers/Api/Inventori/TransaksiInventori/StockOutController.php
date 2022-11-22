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
        //
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
