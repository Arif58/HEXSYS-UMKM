<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvInvItemKategori extends Model{
    protected $table        = 'inv.inv_item_kategori';
    protected $primaryKey   = 'kategori_cd'; 
    public $incrementing    = false;

    protected $fillable = [
        'kategori_cd', 'kategori_nm', 'root_cd','type_cd', 'level_no', 'created_by', 'updated_by'
    ];
}
