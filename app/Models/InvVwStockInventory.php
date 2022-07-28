<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvVwStockInventory extends Model{
    protected $table        = 'vw_stock_inventory';
    protected $primaryKey   = 'positemunit_cd'; 
    public $incrementing    = false;
}
