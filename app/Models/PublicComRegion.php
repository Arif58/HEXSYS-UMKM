<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PublicComRegion extends Model{
    protected $table        = 'com_region';
    protected $primaryKey   = 'region_cd'; 
    public $incrementing    = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'region_cd',
        'region_nm',
        'region_root',
        'region_capital',
        'region_level',
        'default_st',
        'region_tp',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];
}
