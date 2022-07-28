<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PublicTrxFile
 * 
 * @property uuid $trx_file_id
 * @property character varying $trx_cd
 * @property character varying|null $file_nm
 * @property character|null $file_tp
 * @property character varying|null $file_path
 * @property character varying|null $note
 * @property character varying|null $created_by
 * @property character varying|null $updated_by
 * @property timestamp without time zone|null $created_at
 * @property timestamp without time zone|null $updated_at
 * 
 * @package App\Models
 */
class PublicTrxFile extends Model
{
	use Uuid;
	protected $table 		= 'public.trx_file';
	protected $primaryKey 	= 'trx_file_id';
	public $incrementing 	= false;
	public $keyType 		= 'string';

	protected $casts = [
		'trx_cd' 		=> 'character varying',
		'file_nm' 		=> 'character varying',
		'file_tp' 		=> 'character',
		'file_path' 	=> 'character varying',
		'note' 			=> 'character varying',
		'created_by' 	=> 'character varying',
		'updated_by' 	=> 'character varying',
		'created_at' 	=> 'timestamp without time zone',
		'updated_at' 	=> 'timestamp without time zone'
	];

	protected $fillable = [
		'seq_no',
		'trx_cd',
		'file_nm',
		'file_tp',
		'file_path',
		'note',
		'created_by',
		'updated_by'
	];
}
