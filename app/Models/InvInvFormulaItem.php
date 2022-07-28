<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvInvFormulaItem extends Model{
    protected $table      = 'inv.inv_formula_item';
    protected $primaryKey = 'formula_item_id'; 

    protected $fillable = [
        'formula_item_id',
        'item_cd',
        'formula_cd',
        'content',
        'unit_cd',
        'main_st',
        'created_by',
        'updated_by',
    ];
}
