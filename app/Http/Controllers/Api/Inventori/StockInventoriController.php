<?php

namespace App\Http\Controllers\Api\Inventori;

use App\Http\Controllers\Controller;
use App\Models\InvInvPosInventori;
use App\Models\InvInvPosItemUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class StockInventoriController extends Controller
{

    // protected $user;

    // public function __construct()
    // {
    //     $this->user = JWTAuth::parseToken()->authenticate();
    // }

    public function getData() {
        $pos = Auth::user()->unit_cd;
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
				->orderBy('pos_nm')
				->orderBy('item_nm')
				->where('inv_pos_itemunit.pos_cd', $pos)->get();

       $response = [
            'status' => 'success',
            'data' => $stock
        ];

        return response()->json($response, 200);
       
    }

    public function show($id) {
        $stock = InvInvPosItemUnit::select(
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

        if($stock) {
            $response = [
                'status' => 'success',
                'data' => $stock
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Stock not found'
            ];
        }

        return response()->json($response, 200);
    }
}
