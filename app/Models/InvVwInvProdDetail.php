<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvVwInvProdDetail extends Model{
    protected $table        = 'inv.vw_inv_prod_detail';
    protected $primaryKey   = 'prod_detail_id'; 
    public $incrementing    = false;
}
