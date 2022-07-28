<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvInvItemGolongan extends Model{
    protected $table        = 'inv.inv_item_golongan';
    protected $primaryKey   = 'golongan_cd'; 
    public $incrementing    = false;

    protected $fillable = [
        'golongan_cd', 'golongan_nm', 'root_cd','type_cd', 'level_no', 'created_by', 'updated_by'
    ];
}
