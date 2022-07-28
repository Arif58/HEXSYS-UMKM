<?php

namespace App\Models;

use DB;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class InvInvProduksi extends Model{
    use Uuid;

    protected $table      = 'inv.inv_produksi';
    protected $primaryKey = 'prod_cd'; 
    public $incrementing  = false;
	
	protected $fillable = [
        "prod_cd",
        "prod_no",
		"prod_item",
		"quantity",
        "trx_year",
        "trx_month",
        "trx_date",
        "pos_cd",
        "note",
        "prod_st",
        "created_by",
        "updated_by",
    ];

    public static function getDataCd($year, $month){
        $lastNum      = InvInvProduksi::select(DB::Raw("
                        coalesce(max(right(prod_no, 6)::int) + 1, 1) as lastnum
                        "))
                        ->where('trx_year',$year)
                        ->where('trx_month',$month)
                        ->first()
                        ->lastnum;

        return substr($year, -2) .str_pad($month,2,"0",STR_PAD_LEFT).str_pad($lastNum,6,"0",STR_PAD_LEFT);
    }
}
