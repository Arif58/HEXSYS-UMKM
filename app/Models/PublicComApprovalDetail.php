<?php
namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PublicComApprovalDetail
 * 
 * @property uuid $com_approval_detail
 * @property character varying $approval_cd
 * @property character varying $role_cd
 * @property int $approval_order
 * @property character varying|null $created_by
 * @property character varying|null $updated_by
 * @property timestamp without time zone|null $created_at
 * @property timestamp without time zone|null $updated_at
 * 
 * @property PublicComApproval $com_approval
 *
 * @package App\Models
 */
class PublicComApprovalDetail extends Model
{
	use Uuid;
	protected $table 		= 'public.com_approval_detail';
	protected $primaryKey 	= 'com_approval_detail_id';
	public $incrementing 	= false;
	public $keyType 	  	= 'string';

	protected $casts = [
		'com_approval_detail_id' 	=> 'uuid',
		'approval_cd' 				=> 'character varying',
		'role_cd' 					=> 'character varying',
		'approval_order'			=> 'int',
		'created_by' 				=> 'character varying',
		'updated_by' 				=> 'character varying',
		'created_at' 				=> 'timestamp without time zone',
		'updated_at' 				=> 'timestamp without time zone'
	];

	protected $fillable = [
		'com_approval_detail_id',
		'approval_cd',
		'role_cd',
		'approval_order',
		'created_by',
		'updated_by'
	];

	public function com_approval()
	{
		return $this->belongsTo(PublicComApproval::class, 'approval_cd');
	}
}
