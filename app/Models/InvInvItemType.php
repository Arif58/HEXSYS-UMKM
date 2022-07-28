<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvInvItemType extends Model{
    protected $table        = 'inv.inv_item_type';
    protected $primaryKey   = 'type_cd'; 
    public $incrementing    = false;

    protected $fillable = [
        'type_cd', 'type_nm', 'created_by', 'updated_by'
    ];
}
