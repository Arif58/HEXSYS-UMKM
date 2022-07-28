<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ErpGlCoaBudgetDetail
 * 
 * @property uuid $gl_coa_budget_detail_id
 * @property character varying|null $coa_budget_cd
 * @property int|null $budget_month
 * @property float|null $amount_debit
 * @property float|null $amount_credit
 * @property character varying|null $created_by
 * @property character varying|null $updated_by
 * @property timestamp without time zone|null $created_at
 * @property timestamp without time zone|null $updated_at
 * 
 * @property ErpGlCoaBudget $gl_coa_budget
 *
 * @package App\Models
 */
class ErpGlCoaBudgetDetail extends Model
{
	use Uuid;
	protected $table 		= 'erp.gl_coa_budget_detail';
	protected $primaryKey 	= 'gl_coa_budget_detail_id';
	public $incrementing 	= false;
	public $keyType 		= 'string';

	protected $casts = [
		'gl_coa_budget_detail_id' 	=> 'uuid',
		'coa_budget_cd' 			=> 'character varying',
		'budget_month' 				=> 'int',
		'amount_debit' 				=> 'float',
		'amount_credit' 			=> 'float',
		'created_by' 				=> 'character varying',
		'updated_by' 				=> 'character varying',
		'created_at' 				=> 'timestamp without time zone',
		'updated_at' 				=> 'timestamp without time zone'
	];

	protected $fillable = [
		'gl_coa_budget_detail_id',
		'coa_budget_cd',
		'budget_month',
		'amount_debit',
		'amount_credit',
		'created_by',
		'updated_by'
	];

	public function gl_coa_budget()
	{
		return $this->belongsTo(ErpGlCoaBudget::class, 'coa_budget_cd');
	}
}
