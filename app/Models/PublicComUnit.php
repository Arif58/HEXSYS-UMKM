<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class PublicComUnit extends Model{
    protected $table        = 'com_unit';
    private static $tableName   = 'com_unit';
    protected $primaryKey   = 'unit_cd'; 
    public $incrementing    = false;

    protected $fillable = [
        'unit_cd','unit_nm','unit_root','unit_data1','created_by','updated_by'
    ];
}
