<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PublicTrxApproval
 * 
 * @property uuid $trx_approval_id
 * @property character varying $trx_cd
 * @property int $approve_no
 * @property character varying $approve_by
 * @property timestamp without time zone $approve_date
 * @property character varying|null $created_by
 * @property character varying|null $updated_by
 * @property timestamp without time zone|null $created_at
 * @property timestamp without time zone|null $updated_at
 *
 * @package App\Models
 */
class PublicTrxApproval extends Model
{
	use Uuid;
	protected $table 		= 'public.trx_approval';
	protected $primaryKey 	= 'trx_approval_id';
	public $incrementing 	= false;
	public $keyType 		= 'string';

	protected $casts = [
		'trx_approval_id' 	=> 'uuid',
		'trx_cd' 			=> 'character varying',
		'approve_no' 		=> 'int',
		'approve_by' 		=> 'character varying',
		'approve_date' 		=> 'timestamp without time zone',
		'created_by' 		=> 'character varying',
		'updated_by' 		=> 'character varying',
		'created_at' 		=> 'timestamp without time zone',
		'updated_at' 		=> 'timestamp without time zone'
	];

	protected $fillable = [
		'trx_approval_id',
		'trx_cd',
		'approve_no',
		'approve_by',
		'approve_date',
		'created_by',
		'updated_by'
	];
}
