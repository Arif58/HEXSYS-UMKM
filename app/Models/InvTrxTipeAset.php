<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class InvTrxTipeAset extends Model
{
	protected $table 		= 'inv.trx_tipe_aset';
	protected $primaryKey	= 'asettp_cd';
	public $incrementing	= false;
	public $keyType 		= 'string';
	
	protected $fillable = [
		'asettp_cd',
		'asettp_no',
		'asettp_nm',
		'asettp_root',
		'masa_manfaat',
		'nilai_kapitalisasi',
		'note',
		'asettp_level',
		'created_by',
		'updated_by'
	];
}
