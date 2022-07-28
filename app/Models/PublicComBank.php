<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PublicComBank extends Model{
    protected $table      = 'public.com_bank';
    protected $primaryKey = 'bank_cd'; 
    public $incrementing  = false;
    public $keyType 	  = 'string';

    protected $fillable = [
        'bank_cd', 
        'bank_nm', 
        'note', 
        'created_by', 
        'updated_by'
    ];
}
