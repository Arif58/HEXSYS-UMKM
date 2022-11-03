<?php

namespace App\Http\Controllers\Api\Inventori;

use App\Http\Controllers\Controller;
use App\Models\InvInvItemMaster;
use App\Models\InvInvItemType;
use App\Models\InvInvUnit;
use App\Models\InvPoPrincipal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvItemController extends Controller
{
    
    function index() {
        // $types = InvInvItemType::all(['type_cd', 'type_nm']);
        $pos = Auth::user()->unit_cd;
        if ($pos != NULL) {
            $data = InvInvItemMaster::getDatas()
            ->get();

        } else {
            $data = InvInvItemMaster::select(
                "inv_item_master.item_cd",
                "inv_item_master.item_nm",
                "inv_item_master.type_cd",
                "type.type_nm",
                "inv_item_master.unit_cd",
                "inv_item_master.item_price_buy",
                "inv_item_master.item_price_buy",
                "inv_item_master.ppn",
                "inv_item_master.minimum_stock",
                "inv_item_master.created_at",
                "inv_item_master.updated_at",
            )
            ->join('inv.inv_item_type as type','type.type_cd', '=','inv_item_master.type_cd')
            ->get();
        }
        

        $response = [
            'status' => 'success',
            'data' => $data
        ];

        return response()->json($response, 200);
    }
}
