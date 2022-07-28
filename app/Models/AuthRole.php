<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuthRole extends Model{
    protected $table        = 'auth.roles';
    protected $primaryKey   = 'role_cd'; 
    public $incrementing    = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'role_cd', 'role_nm','rule_tp','created_by','update_by'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    static function getAllRoles($myRole){
        $data = AuthRole::select('role_cd','role_nm');
        if($myRole != 'superuser'){
            $data = $data->where('role_cd','!=','superuser');
        }
        return $data->get();
    }
}
