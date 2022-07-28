<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ErpGlCoaBeginBalance
 * 
 * @property uuid $gl_coa_begin_balance_id
 * @property character varying|null $comp_cd
 * @property character varying|null $coa_cd
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
 * @property ComCompany $com_company
 * @property ErpGlCoa $gl_coa
 * @property ComCurrency $com_currency
 *
 * @package App\Models
 */
class ErpGlCoaBeginBalance extends Model
{
	use Uuid;
	protected $table 		= 'erp.gl_coa_begin_balance';
	protected $primaryKey 	= 'gl_coa_begin_balance_id';
	public $incrementing 	= false;
	public $keyType 		= 'string';

	protected $casts = [
		'gl_coa_begin_balance_id' 	=> 'uuid',
		'comp_cd' 					=> 'character varying',
		'coa_cd' 					=> 'character varying',
		'balance_year' 				=> 'int',
		'currency_cd' 				=> 'character varying',
		'amount_debit' 				=> 'float',
		'amount_credit' 			=> 'float',
		'rate' 						=> 'float',
		'created_by' 				=> 'character varying',
		'updated_by' 				=> 'character varying',
		'created_at' 				=> 'timestamp without time zone',
		'updated_at' 				=> 'timestamp without time zone'
	];

	protected $fillable = [
		'gl_coa_begin_balance_id',
		'comp_cd',
		'coa_cd',
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
		return $this->belongsTo(ComCompany::class, 'comp_cd');
	}

	public function gl_coa()
	{
		return $this->belongsTo(ErpGlCoa::class, 'coa_cd');
	}

	public function com_currency()
	{
		return $this->belongsTo(ComCurrency::class, 'currency_cd');
	}
}
