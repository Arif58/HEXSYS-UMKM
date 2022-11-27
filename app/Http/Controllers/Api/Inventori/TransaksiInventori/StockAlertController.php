<?php

namespace App\Http\Controllers\Api\Inventori\TransaksiInventori;

use App\Http\Controllers\Controller;
use App\Models\InvVwStockAlert;
use App\Models\InvVwStockExpired;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockAlertController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getStockAlert()
    {
        $pos = Auth::user()->unit_cd;
        if($pos != null) {
            $dataStockAlert = InvVwStockAlert::where('pos_cd', $pos)->get();
            $dataStockExpired = InvVwStockExpired::where('pos_cd', $pos)->get();
        } else {
            $dataStockAlert = InvVwStockAlert::all();
            $dataStockExpired = InvVwStockExpired::all();
        }
        $response = [
            'status' => 'success',
            'data_stock_alert' => $dataStockAlert,
            'data_stock_expired' => $dataStockExpired
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
    public function update(Request $request, $id)
    {
        //
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
