<?php
namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ErpGlCostCenterBeginBalance
 * 
 * @property uuid|null $gl_cost_center_begin_balance_id
 * @property character varying|null $comp_cd
 * @property character varying|null $coa_cd
 * @property character varying|null $cc_cd
 * @property int|null $balance_year
 * @property character varying|null $currency_cd
 * @property float|null $amount_debit
 * @property float|null $amount_credit
 * @property float|null $rate
 * @property character varying|null $created_by
 * @property character varying|null $updated_by
 * @property timestamp without time zone|null $created_at
 * @property timestamp without time zone|null $updated_at
 * 
 * @property PublicComCompany $com_company
 * @property ErpGlCostCenter $gl_cost_center
 * @property PublicComCurrency $com_currency
 *
 * @package App\Models
 */
class ErpGlCostCenterBeginBalance extends Model
{
	use Uuid;
	protected $table 		= 'erp.gl_cost_center_begin_balance';
	protected $primaryKey 	= 'gl_cost_center_begin_balance_id';
	public $incrementing 	= false;
	public $keyType 		= 'string';

	protected $casts = [
		'gl_cost_center_begin_balance_id' 	=> 'uuid',
		'comp_cd' 							=> 'character varying',
		'coa_cd' 							=> 'character varying',
		'cc_cd' 							=> 'character varying',
		'balance_year' 						=> 'int',
		'currency_cd' 						=> 'character varying',
		'amount_debit' 						=> 'float',
		'amount_credit' 					=> 'float',
		'rate' 								=> 'float',
		'created_by' 						=> 'character varying',
		'updated_by' 						=> 'character varying',
		'created_at' 						=> 'timestamp without time zone',
		'updated_at' 						=> 'timestamp without time zone'
	];

	protected $fillable = [
		'gl_cost_center_begin_balance_id',
		'comp_cd',
		'coa_cd',
		'cc_cd',
		'balance_year',
		'currency_cd',
		'amount_debit',
		'amount_credit',
		'rate',
		'created_by',
		'updated_by'
	];

	public function com_company()
	{
		return $this->belongsTo(PublicComCompany::class, 'comp_cd');
	}

	public function com_currency()
	{
		return $this->belongsTo(PublicComCurrency::class, 'currency_cd');
	}

	public function gl_coa()
	{
		return $this->belongsTo(ErpGlCoa::class, 'coa_cd');
	}

	public function gl_cost_center()
	{
		return $this->belongsTo(ErpGlCostCenter::class, 'cc_cd');
	}
}
