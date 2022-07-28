<?php

namespace App\Models;

use DB;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class InvPoRetur extends Model
{
    use Uuid;

    protected $table      = 'inv.po_retur';
    protected $primaryKey = 'retur_cd'; 
    public $incrementing  = false;

    protected $fillable = [
        "retur_cd",
        "retur_no",
        "supplier_cd",
        "principal_cd",
        "trx_year",
        "trx_month",
        "trx_date",
        "currency_cd",
        "rate",
        "total_price",
        "total_amount",
        "vat_tp",
        "percent_ppn",
        "ppn",
        "retur_datetime",
        "note",
        "entry_by",
        "entry_date",
        "retur_st",
        "created_by",
        "updated_by"
    ];

    public static function getDataCd($year, $month){
        $lastNum      = InvPoRetur::select(DB::Raw("
                        coalesce(max(right(retur_no, 6)::int) + 1, 1) as lastnum
                        "))
                        ->where('trx_year',$year)
                        ->where('trx_month',$month)
						->whereRaw("retur_no ~ '^[-+]?[0-9]*\.?[0-9]+([eE][-+]?[0-9]+)?$'")
                        ->first()
                        ->lastnum;

        //return str_pad($year,2,"0",STR_PAD_LEFT).str_pad($month,2,"0",STR_PAD_LEFT).str_pad($lastNum,6,"0",STR_PAD_LEFT);
		return substr($year, -2) .str_pad($month,2,"0",STR_PAD_LEFT).str_pad($lastNum,6,"0",STR_PAD_LEFT);
    }
}
