<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\InvTrxTarifUnitMedis;

class InvInvItemMaster extends Model{
    protected $table        = 'inv.inv_item_master';
    protected $primaryKey   = 'item_cd'; 
    public $incrementing    = false;

    protected $fillable = [
        'item_cd', 
        'item_nm', 
        'type_cd',
        'unit_cd',
        'barcode',
        'currency_cd',
        'item_price_buy',
        'item_price',
        'vat_tp',
        'ppn',
        'reorder_point',
        'minimum_stock',
        'maximum_stock',
        'generic_st',
        'active_st',
        'inventory_st',
        'tariftp_cd',
        'principal_cd',
        'item_root',
        'golongan_cd',
        'kategori_cd',
        'map_value',
        'dosis',
        'created_by', 
        'update_by'
    ];

    static $itemType1 = array('001');
    static $itemType2 = array('002');

    static function getData(){
        $data = InvInvItemMaster::select(
				"inv_item_master.item_cd",
				"inv_item_master.item_nm",
				"unit.unit_cd",
				"unit.unit_nm",
				"inv_item_master.item_price",
				"invpos.quantity",
				'pos.pos_nm'
			)
            ->join('inv.inv_pos_itemunit as invpos','invpos.item_cd','inv_item_master.item_cd')
            ->join('inv.inv_pos_inventori as pos','pos.pos_cd','invpos.pos_cd')
            ->join('inv.inv_unit as unit','unit.unit_cd','invpos.unit_cd');
        return $data;
    }
	
	static function getItemCd()
	{
		$data = InvInvItemMaster::max(DB::Raw("item_cd::int"));
		
		return str_pad($data + 1 , 5 , "0" ,STR_PAD_LEFT);
	}

    static function getDataType1($pos){
        $ownedPos   = array();
        $posArray   = $pos->toArray();
        foreach($posArray as $singlePos){
            array_push($ownedPos, $singlePos['pos_cd']);
        }
        $data   = self::getData();
        $data   = $data
                    ->whereIn('invpos.pos_cd',$ownedPos)
                    ->whereIn('inv_item_master.type_cd',self::$itemType1)
                    ->where('inventory_st','1');
        return $data;
    }

    static function getDataType2($pos){
        $ownedPos   = array();
        $posArray   = $pos->toArray();
        foreach($posArray as $singlePos){
            array_push($ownedPos, $singlePos['pos_cd']);
        }
        $data   = self::getData();
        $data   = $data
                ->whereIn('invpos.pos_cd',$ownedPos)
                //->whereIn('inv_item_master.type_cd',self::$itemType2)
                ->where('inventory_st','1');
        return $data;
    }

    static function getTypeTransaksi($itemCd){
        $data = InvTrxTarifInventori::where('item_cd',$itemCd)->first();
        $result = '';
        if($data){
            $result = ($data->account_cd == 'COA01') ? 'Type1' : 'Type2';
        }
        return $result;
    }
}
