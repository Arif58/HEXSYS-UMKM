<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvVwInvPrDetail extends Model{
    protected $table        = 'inv.vw_inv_pr_detail';
    protected $primaryKey   = 'po_pr_detail_id'; 
    public $incrementing    = false;
}
