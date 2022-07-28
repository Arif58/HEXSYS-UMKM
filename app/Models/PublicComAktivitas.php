<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PublicComAktivitas extends Model{
    protected $table      = 'public.com_aktivitas';
    protected $primaryKey = 'aktivitas_cd'; 
    public $incrementing  = false;
    public $keyType 	  = 'string';

    protected $fillable = [
        'aktivitas_cd', 
        'aktivitas_nm',
		'aktivitas_tp',		
        'note', 
        'created_by', 
        'updated_by'
    ];
}
