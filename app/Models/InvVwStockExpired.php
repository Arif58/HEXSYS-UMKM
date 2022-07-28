<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvVwStockExpired extends Model{
    protected $table        = 'inv.vw_stock_expired';
    protected $primaryKey   = 'item_cd'; 
    public $incrementing    = false;
}
