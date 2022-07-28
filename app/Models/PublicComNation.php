<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PublicComNation extends Model{
    protected $table        = 'com_nation';
    protected $primaryKey   = 'nation_cd'; 
    public $incrementing    = false;

    protected $fillable = [
        'nation_cd', 'nation_nm', 'capital','created_by', 'updated_by'
    ];
}
