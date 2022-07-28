<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PublicComAging
 * 
 * @property character varying $aging_cd
 * @property character varying|null $aging_nm
 * @property character varying|null $created_by
 * @property character varying|null $updated_by
 * @property timestamp without time zone|null $created_at
 * @property timestamp without time zone|null $updated_at
 * 
 * @property Collection|PublicComAgingDetail[] $com_aging_details
 *
 * @package App\Models
 */
class PublicComAging extends Model
{
	protected $table 		= 'public.com_aging';
	protected $primaryKey 	= 'aging_cd';
	public $incrementing 	= false;
	public $keyType 		= 'string';
	
	protected $casts = [
		'aging_cd' 		=> 'character varying',
		'aging_nm' 		=> 'character varying',
		'created_by' 	=> 'character varying',
		'updated_by' 	=> 'character varying',
		'created_at' 	=> 'timestamp without time zone',
		'updated_at' 	=> 'timestamp without time zone'
	];

	protected $fillable = [
		'aging_cd',
		'aging_nm',
		'created_by',
		'updated_by'
	];

	public function com_aging_details()
	{
		return $this->hasMany(PublicComAgingDetail::class, 'aging_cd');
	}
}
