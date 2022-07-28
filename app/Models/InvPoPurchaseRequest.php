<?php

namespace App\Models;

use DB;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class InvPoPurchaseRequest extends Model{
    use Uuid;

    protected $table      = 'inv.po_purchase_request';
    protected $primaryKey = 'pr_cd'; 
    public $incrementing  = false;

    protected $fillable = [
        "pr_cd",
        "pr_no",
        "pos_cd",
        "supplier_cd",
        "trx_year",
        "trx_month",
        "trx_date",
        "note",
        "pr_st",
        "created_by",
        "updated_by",
    ];

    public static function getDataCd($year, $month){
        $lastNum      = InvPoPurchaseRequest::select(DB::Raw("
                        coalesce(max(right(pr_no, 6)::int) + 1, 1) as lastnum
                        "))
                        ->where('trx_year',$year)
                        ->where('trx_month',$month)
                        ->first()
                        ->lastnum;

        //return str_pad($year,2,"0",STR_PAD_LEFT).str_pad($month,2,"0",STR_PAD_LEFT).str_pad($lastNum,6,"0",STR_PAD_LEFT);
		return substr($year, -2) .str_pad($month,2,"0",STR_PAD_LEFT).str_pad($lastNum,6,"0",STR_PAD_LEFT);
    }
}
