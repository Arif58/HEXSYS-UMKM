<?php

namespace App\Models;

use DB;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class InvPoReceiveItem extends Model{
    use Uuid;

    protected $table      = 'inv.po_receive_item';
    protected $primaryKey = 'ri_cd'; 
    public $incrementing  = false;

    protected $fillable = [
        "ri_cd",
        "ri_no",
        "supplier_cd",
        "principal_cd",
        "invoice_no",
        "trx_year",
        "trx_month",
        "trx_date",
        "currency_cd",
        "rate",
        "total_price",
        "total_discount",
        "total_amount",
        "vat_tp",
        "percent_ppn",
        "ppn",
        "entry_by",
        "entry_date",
        "note",
        "ri_st",
        "pos_cd",
        "created_by",
        "updated_by"
    ];

    public static function getDataCd($year, $month){
        $lastNum      = InvPoReceiveItem::select(DB::Raw("
                        coalesce(max(right(ri_no, 6)::int) + 1, 1) as lastnum
                        "))
                        ->where('trx_year',$year)
                        ->where('trx_month',$month)
						->whereRaw("ri_no ~ '^[-+]?[0-9]*\.?[0-9]+([eE][-+]?[0-9]+)?$'")
                        ->first()
                        ->lastnum;
		
        //return str_pad($year,2,"0",STR_PAD_LEFT).str_pad($month,2,"0",STR_PAD_LEFT).str_pad($lastNum,6,"0",STR_PAD_LEFT);
		return substr($year, -2) .str_pad($month,2,"0",STR_PAD_LEFT).str_pad($lastNum,6,"0",STR_PAD_LEFT);
    }
}
