<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class InvInvPosInventori extends Model{
    protected $table        = 'inv.inv_pos_inventori';
    protected $primaryKey   = 'pos_cd'; 
    public $incrementing    = false;

    protected $fillable = [
        'pos_cd', 'pos_nm', 'created_by', 'updated_by'
    ];

    static function getOwnedPos($roleUser,$defaultUnit){
        $pos      = InvInvPosInventori::all();
        //--sesuai default unit user
        if(!in_array($roleUser,array('superuser','admin'))){
            $pos = InvInvPosInventori::where('pos_cd',configuration('WHPOS_TRX'));
            if($defaultUnit){
                $pos = $pos->orWhere('unit',$defaultUnit);
            }
            $pos = $pos->get();
        }

        return $pos;
    }
	
	public static function getPosCd(){
		$lastNum      = InvInvPosInventori::select(DB::Raw("
                        coalesce(max(pos_cd::int) + 1, 1) as lastnum
                        "))
                        ->whereRaw("pos_cd ~ '^[-+]?[0-9]*\.?[0-9]+([eE][-+]?[0-9]+)?$'")
                        ->first()
                        ->lastnum;
		
		return str_pad($lastNum,4,"0",STR_PAD_LEFT);
    }
}
