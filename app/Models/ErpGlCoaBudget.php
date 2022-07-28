<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ErpGlCoaBudget
 * 
 * @property character varying $coa_budget_cd
 * @property character varying|null $comp_cd
 * @property character varying|null $coa_cd
 * @property int|null $budget_year
 * @property float|null $begin_debit
 * @property float|null $begin_credit
 * @property character varying|null $currency_cd
 * @property character varying|null $created_by
 * @property character varying|null $updated_by
 * @property timestamp without time zone|null $created_at
 * @property timestamp without time zone|null $updated_at
 * 
 * @property ComCompany $com_company
 * @property ErpGlCoa $gl_coa
 * @property ComCurrency $com_currency
 * @property Collection|ErpGlCoaBudgetDetail[] $gl_coa_budget_details
 *
 * @package App\Models
 */
class ErpGlCoaBudget extends Model
{
	protected $table 		= 'erp.gl_coa_budget';
	protected $primaryKey 	= 'coa_budget_cd';
	public $incrementing 	= false;

	protected $casts = [
		'coa_budget_cd' => 'character varying',
		'comp_cd' 		=> 'character varying',
		'coa_cd' 		=> 'character varying',
		'budget_year' 	=> 'int',
		'begin_debit' 	=> 'float',
		'begin_credit' 	=> 'float',
		'currency_cd' 	=> 'character varying',
		'created_by' 	=> 'character varying',
		'updated_by' 	=> 'character varying',
		'created_at' 	=> 'timestamp without time zone',
		'updated_at' 	=> 'timestamp without time zone'
	];

	protected $fillable = [
		'coa_budget_cd',
		'comp_cd',
		'coa_cd',
		'budget_year',
		'begin_debit',
		'begin_credit',
		'currency_cd',
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

	public function com_currency()
	{
		return $this->belongsTo(PublicComCurrency::class, 'currency_cd');
	}

	public function gl_coa_budget_details()
	{
		return $this->hasMany(ErpGlCoaBudgetDetail::class, 'coa_budget_cd');
	}
}
