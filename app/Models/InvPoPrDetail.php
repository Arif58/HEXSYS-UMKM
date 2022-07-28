<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class InvPoPrDetail extends Model{
    use Uuid;
    protected $table      = 'inv.po_pr_detail';
    protected $primaryKey = 'po_pr_detail_id'; 
    public $incrementing  = false;

    protected $fillable = [
        "po_pr_detail",
        "pr_cd",
        "item_cd",
        "unit_cd",
        "quantity",
		"quantity_hs",
        "created_by",
        "updated_by"
    ];
}
