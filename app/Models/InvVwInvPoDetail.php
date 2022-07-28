<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvVwInvPoDetail extends Model{
    protected $table        = 'inv.vw_inv_po_detail';
    protected $primaryKey   = 'po_po_detail_id'; 
    public $incrementing    = false;
}
