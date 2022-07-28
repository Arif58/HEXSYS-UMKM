<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvVwInventori extends Model{
    protected $table        = 'vw_inventori';
    protected $primaryKey   = 'item_cd'; 
    public $incrementing    = false;
}
