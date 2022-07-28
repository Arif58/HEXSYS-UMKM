<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class InvInvProduksiDetail extends Model{
    use Uuid;
    protected $table      = 'inv.inv_produksi_detail';
    protected $primaryKey = 'prod_detail_id'; 
    public $incrementing  = false;

    protected $fillable = [
        "prod_detail_id",
        "prod_cd",
        "item_cd",
        "unit_cd",
        "quantity",
        "created_by",
        "updated_by"
    ];
}
