<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvInvOpnameDetail extends Model{
    protected $table      = 'inv.inv_opname_detail';
    protected $primaryKey = 'inv_opname_detail_id'; 
    public $incrementing  = false;

    protected $fillable = [
        'inv_opname_detail_id',
        'trx_cd',
        'item_cd',
        'unit_cd',
        'quantity_real',
        'quantity_system',
        'created_by',
        'updated_by',
    ];
}
