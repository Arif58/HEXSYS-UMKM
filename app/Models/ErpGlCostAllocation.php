<?php
namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ErpGlCostAllocation
 * 
 * @property uuid $gl_cost_allocation_id
 * @property character varying|null $coa_cd
 * @property character varying|null $cc_to
 * @property character varying|null $cc_from
 * @property character varying|null $comp_cd
 * @property float|null $fix_value
 * @property float|null $variable_value
 * @property character varying|null $created_by
 * @property character varying|null $updated_by
 * @property timestamp without time zone|null $created_at
 * @property timestamp without time zone|null $updated_at
 * 
 * @property PublicComCompany $com_company
 * @property ErpGlCoa $gl_coa
 *
 * @package App\Models
 */
class ErpGlCostAllocation extends Model
{
	use Uuid;
	protected $table 		= 'erp.gl_cost_allocation';
	protected $primaryKey	= 'gl_cost_allocation_id';
	public $incrementing	= false;
	public $keyType 	  	= 'string';
	
	protected $casts = [
		'gl_cost_allocation_id' => 'uuid',
		'coa_cd' 				=> 'character varying',
		'cc_to' 				=> 'character varying',
		'cc_from' 				=> 'character varying',
		'comp_cd' 				=> 'character varying',
		'fix_value' 			=> 'float',
		'variable_value' 		=> 'float',
		'created_by' 			=> 'character varying',
		'updated_by' 			=> 'character varying',
		'created_at' 			=> 'timestamp without time zone',
		'updated_at' 			=> 'timestamp without time zone'
	];

	protected $fillable = [
		'gl_cost_allocation_id',
		'coa_cd',
		'cc_to',
		'cc_from',
		'comp_cd',
		'fix_value',
		'variable_value',
		'created_by',
		'updated_by'
	];

	public function com_company()
	{
		return $this->belongsTo(PublicComCompany::class, 'comp_cd');
	}

	public function gl_coa()
	{
		return $this->belongsTo(ErpGlCoa::class, 'coa_cd');
	}
}
