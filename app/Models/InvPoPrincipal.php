<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvPoPrincipal extends Model{
    protected $table      = 'inv.po_principal';
    protected $primaryKey = 'principal_cd'; 
    public $incrementing  = false;

    protected $fillable = [
        'principal_cd',
        'principal_nm',
        'address',
        'region_prop',
        'region_kab',
        'postcode',
        'phone',
        'mobile',
        'fax',
        'email',
        'created_by',
        'updated_by',
    ];
}
