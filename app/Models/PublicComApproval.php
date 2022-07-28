<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PublicComApproval
 * 
 * @property character varying $approval_cd
 * @property character varying $approval_nm
 * @property character varying $approval_tp
 * @property character varying|null $created_by
 * @property character varying|null $updated_by
 * @property timestamp without time zone|null $created_at
 * @property timestamp without time zone|null $updated_at
 * 
 * @property Collection|PublicComApprovalDetail[] $com_approval_details
 *
 * @package App\Models
 */
class PublicComApproval extends Model
{
	protected $table 		= 'public.com_approval';
	protected $primaryKey 	= 'approval_cd';
	public $incrementing 	= false;
	public $keyType 		= 'string';

	protected $casts = [
		'approval_cd' => 'character varying',
		'approval_nm' => 'character varying',
		'approval_tp' => 'character varying',
		'created_by'  => 'character varying',
		'updated_by'  => 'character varying',
		'created_at'  => 'timestamp without time zone',
		'updated_at'  => 'timestamp without time zone'
	];

	protected $fillable = [
		'approval_cd',
		'approval_nm',
		'approval_tp',
		'created_by',
		'updated_by'
	];

	public function com_approval_details()
	{
		return $this->hasMany(PublicComApprovalDetail::class, 'approval_cd');
	}
}
