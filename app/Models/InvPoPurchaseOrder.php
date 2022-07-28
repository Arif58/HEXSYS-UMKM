<?php

namespace App\Models;

use DB;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class InvPoPurchaseOrder extends Model{
    use Uuid;

    protected $table      = 'inv.po_purchase_order';
    protected $primaryKey = 'po_cd'; 
    public $incrementing  = false;

    protected $fillable = [
        "po_cd",
        "po_no",
        "supplier_cd",
        "invoice_no",
        "trx_year",
        "trx_month",
        "trx_date",
        "top_cd",
        "currency_cd",
        "rate",
        "total_price",
        "total_amount",
        "vat_tp",
        "percent_ppn",
        "ppn",
        "delivery_address",
        "delivery_datetime",
        "note",
        "po_st",
		"dana_tp",
		"unit_cd",
		"po_source",
		"data_no",
        "created_by",
        "updated_by",
    ];

    public static function getDataCd($year, $month){
		$lastNum      = InvPoPurchaseOrder::select(DB::Raw("
                        coalesce(max(right(po_no, 6)::int) + 1, 1) as lastnum
                        "))
                        ->where('trx_year',$year)
                        ->where('trx_month',$month)
						->whereRaw("po_no ~ '^[-+]?[0-9]*\.?[0-9]+([eE][-+]?[0-9]+)?$'")
                        ->first()
                        ->lastnum;
		
		//return str_pad($year,2,"0",STR_PAD_LEFT).str_pad($month,2,"0",STR_PAD_LEFT).str_pad($lastNum,6,"0",STR_PAD_LEFT);
		return substr($year, -2) .str_pad($month,2,"0",STR_PAD_LEFT).str_pad($lastNum,6,"0",STR_PAD_LEFT);
    }
	
	/* public static function getDataNo($unitCd, $year){
		$lastNum = InvPoPurchaseOrder::select(DB::Raw("
					coalesce(max(data_no) + 1, 1) as lastnum
					"))
					->where('unit_cd',$unitCd)
					->where('trx_year',$year)
					//->where('popr_st',null)
					->whereRaw("coalesce(popr_st,'')=''")
					->first()
					->lastnum;
		
		return $lastNum;
    } */
	
	public static function getDataNo($unitCd, $danatp, $year){
		$lastNum = InvPoPurchaseOrder::select(DB::Raw("
					coalesce(max(data_no) + 1, 1) as lastnum
					"))
					->where('unit_cd',$unitCd)
					->where('dana_tp',$danatp)
					->where('trx_year',$year)
					//->where('popr_st',null)
					->whereRaw("coalesce(popr_st,'')=''")
					->first()
					->lastnum;
		
		return $lastNum;
    }
}
