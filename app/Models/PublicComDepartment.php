<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PublicComDepartment
 * 
 * @property character varying $dept_cd
 * @property character varying|null $comp_cd
 * @property character varying|null $dept_nm
 * @property character varying|null $dept_root
 * @property character varying|null $header_cd
 * @property character varying|null $created_by
 * @property character varying|null $updated_by
 * @property timestamp without time zone|null $created_at
 * @property timestamp without time zone|null $updated_at
 * 
 * @property ComCompany $com_company
 *
 * @package App\Models
 */
class PublicComDepartment extends Model
{
	protected $table 		= 'public.com_department';
	protected $primaryKey 	= 'dept_cd';
	public $incrementing	= false;
	public $keyType 		= 'string';

	protected $casts = [
		'dept_cd' 		=> 'character varying',
		'comp_cd' 		=> 'character varying',
		'dept_nm' 		=> 'character varying',
		'dept_root' 	=> 'character varying',
		'header_cd' 	=> 'character varying',
		'created_by' 	=> 'character varying',
		'updated_by' 	=> 'character varying',
		'created_at' 	=> 'timestamp without time zone',
		'updated_at' 	=> 'timestamp without time zone'
	];

	protected $fillable = [
		'dept_cd',
		'comp_cd',
		'dept_nm',
		'dept_root',
		'header_cd',
		'created_by',
		'updated_by'
	];

	public function com_company()
	{
		return $this->belongsTo(PublicComCompany::class, 'comp_cd');
	}
}
