<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class InvPoReceiveDetail extends Model{
    use Uuid;
    protected $table      = 'inv.po_receive_detail';
    protected $primaryKey = 'po_receive_detail_id'; 
    public $incrementing  = false;

    protected $fillable = [
        "po_receive_detail_id",
        "ri_cd",
        "item_cd",
        "po_cd",
        "principal_cd",
        "unit_cd",
        "quantity",
        "unit_price",
        "discount_percent",
        "discount_amount",
        "trx_amount",
        "currency_cd",
        "rate",
        "faktur_no",
        "faktur_date",
        "batch_no",
        "expire_date",
        "note",
        "created_by",
        "updated_by",
    ];
}
