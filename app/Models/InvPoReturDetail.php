<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class InvPoReturDetail extends Model
{
    use Uuid;
    protected $table      = 'inv.po_retur_detail';
    protected $primaryKey = 'po_retur_detail_id'; 
    public $incrementing  = false;

    protected $fillable = [
        "po_retur_detail_id",
        "retur_cd",
        "item_cd",
        "unit_cd",
        "quantity",
        "unit_price",
        "trx_amount",
        "faktur_no",
        "faktur_date",
        "note",
        "created_by",
        "updated_by",
    ];
}
