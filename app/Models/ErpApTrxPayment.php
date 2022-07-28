<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ErpApTrxPayment
 * 
 * @property uuid $ap_trx_payment_id
 * @property character varying $ap_cd
 * @property character varying|null $invoice_no
 * @property int|null $trx_year
 * @property int|null $trx_month
 * @property timestamp without time zone|null $trx_date
 * @property timestamp without time zone|null $payment_date
 * @property character varying|null $currency_cd
 * @property float|null $rate
 * @property float|null $trx_amount
 * @property float|null $ppn
 * @property character varying|null $cheque_no
 * @property timestamp without time zone|null $cheque_date
 * @property string|null $note
 * @property character varying|null $dc_value
 * @property character varying|null $coa_cd
 * @property character varying|null $entry_by
 * @property timestamp without time zone|null $entry_date
 * @property character varying|null $approve_by
 * @property timestamp without time zone|null $approve_date
 * @property int|null $approve_no
 * @property int|null $print_seq
 * @property character varying|null $created_by
 * @property character varying|null $updated_by
 * @property timestamp without time zone|null $created_at
 * @property timestamp without time zone|null $updated_at
 * 
 * @property ErpApTrx $ap_trx
 * @property PublicComCurrency $com_currency
 *
 * @package App\Models
 */
class ErpApTrxPayment extends Model
{
	use Uuid;
	protected $table 		= 'erp.ap_trx_payment';
	protected $primaryKey 	= 'ap_trx_payment_id';
	public $incrementing 	= false;
	public $keyType 		= 'string';

	protected $casts = [
		'ap_trx_payment_id' => 'uuid',
		'ap_cd' 			=> 'character varying',
		'invoice_no' 		=> 'character varying',
		'trx_year' 			=> 'int',
		'trx_month' 		=> 'int',
		'trx_date' 			=> 'timestamp without time zone',
		'payment_date' 		=> 'timestamp without time zone',
		'currency_cd' 		=> 'character varying',
		'rate' 				=> 'float',
		'trx_amount' 		=> 'float',
		'ppn' 				=> 'float',
		'cheque_no'			=> 'character varying',
		'cheque_date' 		=> 'timestamp without time zone',
		'dc_value' 			=> 'character varying',
		'coa_cd' 			=> 'character varying',
		'entry_by' 			=> 'character varying',
		'entry_date' 		=> 'timestamp without time zone',
		'approve_by' 		=> 'character varying',
		'approve_date' 		=> 'timestamp without time zone',
		'approve_no' 		=> 'int',
		'print_seq' 		=> 'int',
		'created_by' 		=> 'character varying',
		'updated_by' 		=> 'character varying',
		'created_at' 		=> 'timestamp without time zone',
		'updated_at' 		=> 'timestamp without time zone'
	];

	protected $fillable = [
		'ap_trx_payment_id',
		'ap_cd',
		'invoice_no',
		'trx_year',
		'trx_month',
		'trx_date',
		'payment_date',
		'currency_cd',
		'rate',
		'trx_amount',
		'ppn',
		'cheque_no',
		'cheque_date',
		'note',
		'dc_value',
		'coa_cd',
		'entry_by',
		'entry_date',
		'approve_by',
		'approve_date',
		'approve_no',
		'print_seq',
		'created_by',
		'updated_by'
	];

	public function ap_trx()
	{
		return $this->belongsTo(ErpApTrx::class, 'ap_cd');
	}

	public function com_currency()
	{
		return $this->belongsTo(PublicComCurrency::class, 'currency_cd');
	}
	
	public function gl_coa()
	{
		return $this->belongsTo(ErpGlCoa::class, 'coa_cd');
	}
}
