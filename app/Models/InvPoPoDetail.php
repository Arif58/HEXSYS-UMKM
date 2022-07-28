<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class InvPoPoDetail extends Model{
    use Uuid;
    protected $table      = 'inv.po_po_detail';
    protected $primaryKey = 'po_po_detail_id'; 
    public $incrementing  = false;

    protected $fillable = [
        "po_po_detail",
        "po_cd",
        "item_cd",
        "item_desc",
        "assettp_cd",
        "assettp_desc",
        "pr_cd",
        "unit_cd",
        "quantity",
        "unit_price",
        "trx_amount",
		"quantity_hs",
        "unit_price_hs",
        "trx_amount_hs",
        "created_by",
        "updated_by"
    ];
}
