<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvInvFormula extends Model{
    protected $table      = 'inv.inv_formula';
    protected $primaryKey = 'formula_cd'; 
    public $incrementing  = false;

    protected $fillable = [
        'formula_cd',
        'formula_nm',
        'created_by',
        'updated_by',
    ];
}
