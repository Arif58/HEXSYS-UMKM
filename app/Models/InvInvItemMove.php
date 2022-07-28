<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvInvItemMove extends Model{
    protected $table      = 'inv.inv_item_move';
    protected $primaryKey = 'inv_item_move_id'; 

    protected $fillable = [
        'inv_item_move_id',
        'pos_cd',
        'pos_destination',
        'item_cd',
        'trx_by',
        'trx_datetime',
        'trx_qty',
        'old_stock',
        'new_stock',
        'purpose',
        'vendor',
        'move_tp',
        'note',
        'unit_cd',
        'created_by',
        'updated_by',
    ];
}
