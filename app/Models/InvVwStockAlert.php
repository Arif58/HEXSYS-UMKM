<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvVwStockAlert extends Model{
    protected $table        = 'inv.vw_stock_alert';
    protected $primaryKey   = 'item_cd'; 
    public $incrementing    = false;
}
