<?php

namespace App\Models;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class InvInvOpname extends Model{
    use Uuid;

    protected $table      = 'inv.inv_opname';
    protected $primaryKey = 'inv_opname_id'; 
    public $incrementing  = false;

    protected $fillable = [
        'inv_opname_id',
        'trx_no',
        'trx_nm',
        'trx_year',
        'trx_month',
        'pos_cd',
        'date_start',
        'date_end',
        'note',
        'trx_st',
        'created_by',
        'updated_by',
    ];
}
