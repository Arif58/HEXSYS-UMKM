<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuthRoleUser extends Model{
    protected $table        = 'auth.role_users';
    public $incrementing    = false;
    protected $primaryKey   = 'user_id';
    // protected $primaryKey   = 'configuration_cd'; 
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'user_id', 'role_cd', 'created_by','update_by'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public static function user(){
        return $this->belongsTo('App\Models\AuthUser','user_id');
    }
}
