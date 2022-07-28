<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvInvUnit extends Model{
    protected $table        = 'inv.inv_unit';
    protected $primaryKey   = 'unit_cd'; 
    public $incrementing    = false;

    protected $fillable = [
        'unit_cd', 'unit_nm', 'created_by', 'updated_by'
    ];
}
