<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ErpVwBudgetReal extends Model{
    protected $table        = 'erp.vw_budget_real';
    protected $primaryKey   = 'coa_cd'; 
    public $incrementing    = false;
}
