<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuthConfiguration extends Model{
    protected $table        = 'auth.configurations';
    protected $primaryKey   = 'configuration_cd'; 
    public $incrementing    = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'configuration_cd', 'configuration_nm','configuration_group','configuration_value', 'created_by','updated_by'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];
}
