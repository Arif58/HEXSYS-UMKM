<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvInvItemUnit extends Model
{
    protected $table        = 'inv.inv_item_unit';
    protected $primaryKey   = 'inv_item_unit_id'; 

    protected $fillable = [
        'inv_item_unit_id', 'item_cd', 'unit_cd','conversion', 'created_by', 'updated_by'
    ];
}
