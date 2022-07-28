<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvInvPosItemUnit extends Model{
    protected $table        = 'inv.inv_pos_itemunit';
    protected $primaryKey   = 'positemunit_cd'; 

    protected $fillable = [
        'positemunit_cd',
        'pos_cd',
        'item_cd',
        'unit_cd',
        'quantity',
        'created_by',
        'updated_by',
    ];
}
