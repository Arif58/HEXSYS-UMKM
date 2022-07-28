<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuthLoginHistory extends Model{
    protected $table        = 'auth.login_history';
    protected $primaryKey   = 'login_history_id'; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'user_id','datetime_login','datetime_logout','ip_address','mac_address'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];
}
