<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class GlCostCenter
 * 
 * @property character varying $cc_cd
 * @property character varying|null $cc_nm
 * @property character varying|null $comp_cd
 * @property character varying|null $dept_cd
 * @property character varying|null $created_by
 * @property character varying|null $updated_by
 * @property timestamp without time zone|null $created_at
 * @property timestamp without time zone|null $updated_at
 * 
 * @property PublicComCompany $com_company
 * @property ErpGlCostCenterBeginBalance $gl_cost_center_begin_balance
 *
 * @package App\Models
 */
class ErpGlCostCenter extends Model
{
	protected $table 		= 'erp.gl_cost_center';
	protected $primaryKey 	= 'cc_cd';
	public $incrementing 	= false;
	public $keyType 		= 'string';

	protected $casts = [
		'cc_cd' 		=> 'character varying',
		'cc_nm' 		=> 'character varying',
		'comp_cd' 		=> 'character varying',
		'dept_cd' 		=> 'character varying',
		'created_by' 	=> 'character varying',
		'updated_by' 	=> 'character varying',
		'created_at' 	=> 'timestamp without time zone',
		'updated_at' 	=> 'timestamp without time zone'
	];

	protected $fillable = [
		'cc_cd',
		'cc_nm',
		'comp_cd',
		'dept_cd',
		'created_by',
		'updated_by'
	];

	public function com_company()
	{
		return $this->belongsTo(PublicComCompany::class, 'comp_cd');
	}

	public function gl_cost_center_begin_balance()
	{
		return $this->hasOne(ErpGlCostCenterBeginBalance::class, 'cc_cd');
	}
}
