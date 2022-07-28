<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvInvBatchItem extends Model{
    protected $table      = 'inv.inv_batch_item';
    protected $primaryKey = 'batch_no'; 
    public $incrementing  = false;

    protected $fillable = [
        'batch_no',
        'item_cd',
        'trx_qty',
        'batch_no_start',
        'batch_no_end',
        'expire_date',
        'created_by',
        'updated_by',
    ];
}
