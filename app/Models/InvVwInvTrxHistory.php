<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvVwInvTrxHistory extends Model{
    protected $table        = 'inv.vw_inv_trx_history';
    protected $primaryKey   = 'inv_item_move_id'; 
    public $incrementing    = false;
}
