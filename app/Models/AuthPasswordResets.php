<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuthPasswordResets extends Model{
    protected $table        = 'auth.password_resets';
    protected $primaryKey   = 'email'; 
    public $incrementing    = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'email', 'token','created_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];
}
