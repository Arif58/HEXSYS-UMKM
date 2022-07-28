<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PublicVwRegion extends Model
{
    protected $table        = 'vw_region';
    protected $primaryKey   = 'region_cd'; 
    public $incrementing    = false;
}
