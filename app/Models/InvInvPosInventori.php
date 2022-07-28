<?php

namespace App\Models;

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
}
