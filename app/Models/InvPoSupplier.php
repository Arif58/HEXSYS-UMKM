<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class InvPoSupplier extends Model{
    protected $table      = 'inv.po_supplier';
    protected $primaryKey = 'supplier_cd'; 
    public $incrementing  = false;

    protected $fillable = [
        'supplier_cd',
        'supplier_nm',
        'address',
        'region_prop',
        'region_kab',
        'postcode',
        'phone',
        'mobile',
        'fax',
        'email',
        'npwp',
        'pic',
        'created_by', 
        'updated_by'
    ];
	
	public static function getSupplierCd(){
		$lastNum      = InvPoSupplier::select(DB::Raw("
                        coalesce(max(supplier_cd::int) + 1, 1) as lastnum
                        "))
                        ->whereRaw("supplier_cd ~ '^[-+]?[0-9]*\.?[0-9]+([eE][-+]?[0-9]+)?$'")
                        ->first()
                        ->lastnum;
		
		return str_pad($lastNum,4,"0",STR_PAD_LEFT);
    }
}
