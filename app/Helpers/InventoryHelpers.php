<?php
use App\Models\HexsysInvPosItemUnit;
if (! function_exists('stockValidator')){
    function stockValidator($list_data,$pos_cd){
        $status = true;
        $message = "";
        foreach($list_data as $data){
            $item_cd = $data[0];
            $unit_cd = $data[1];
            $quantityRequested = $data[2];
            $data_nm = $data[3];
            $quantityLeft = HexsysInvPosItemUnit::where('pos_cd',$pos_cd)->where('item_cd',$item_cd)->where('unit_cd',$unit_cd)->first();
            if($quantityLeft){
                $quantityLeft = $quantityLeft->quantity;
                if($quantityLeft < $quantityRequested){
                    $status = false;
                    $message .= $data_nm . " - " . $unit_cd . " di gudang " . $pos_cd . " sisa " . $quantityLeft . "(permintaan: " . $quantityRequested . "). ";
                }
            } else {
                $status = false;
                $message .= "Tidak ada data " . $data_nm . " - " . $unit_cd . " di gudang " . $pos_cd . ". ";
            }
        }
        $response = array($status,$message);
        return $response;
    }
}