<?php
namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ErpArTrx
 * 
 * @property character varying $ar_cd
 * @property character varying|null $comp_cd
 * @property character varying|null $ar_no
 * @property character varying|null $ar_source
 * @property character varying|null $ar_source_cd
 * @property character varying|null $cust_cd
 * @property character varying|null $invoice_no
 * @property int|null $trx_year
 * @property int|null $trx_month
 * @property timestamp without time zone|null $trx_date
 * @property timestamp without time zone|null $due_date
 * @property character varying|null $form_cd
 * @property character varying|null $top_cd
 * @property character varying|null $currency_cd
 * @property float|null $rate
 * @property float|null $total_price
 * @property float|null $freight_cost
 * @property float|null $total_discount
 * @property float|null $total_amount
 * @property float|null $percent_ppn
 * @property float|null $ppn
 * @property character varying|null $entry_by
 * @property timestamp without time zone|null $entry_date
 * @property character varying|null $approve_by
 * @property timestamp without time zone|null $approve_date
 * @property int|null $approve_no
 * @property string|null $note
 * @property character varying|null $ar_st
 * @property int|null $print_seq
 * @property character varying|null $vat_tp
 * @property character varying|null $created_by
 * @property character varying|null $updated_by
 * @property timestamp without time zone|null $created_at
 * @property timestamp without time zone|null $updated_at
 * 
 * @property PublicComCompany $com_company
 * @property PublicComCurrency $com_currency
 * @property PublicComCustomer $com_customer
 * @property PublicComPaymentType $com_payment_type
 * @property Collection|ErpArTrxPayment[] $ar_trx_payments
 *
 * @package App\Models
 */
class ErpArTrx extends Model
{

	protected $table 		= 'erp.ar_trx';
	protected $primaryKey 	= 'ar_cd';
	public $incrementing 	= false;
	public $keyType 		= 'string';

	protected $casts = [
		'ar_cd' 			=> 'character varying',
		'comp_cd' 			=> 'character varying',
		'ar_no' 			=> 'character varying',
		'ar_source' 		=> 'character varying',
		'ar_source_cd' 		=> 'character varying',
		'cust_cd' 			=> 'character varying',
		'invoice_no' 		=> 'character varying',
		'trx_year' 			=> 'int',
		'trx_month' 		=> 'int',
		'trx_date' 			=> 'timestamp without time zone',
		'due_date' 			=> 'timestamp without time zone',
		'form_cd' 			=> 'character varying',
		'top_cd' 			=> 'character varying',
		'currency_cd' 		=> 'character varying',
		'rate' 				=> 'float',
		'total_price' 		=> 'float',
		'freight_cost' 		=> 'float',
		'total_discount' 	=> 'float',
		'total_amount' 		=> 'float',
		'percent_ppn' 		=> 'float',
		'ppn' 				=> 'float',
		'entry_by' 			=> 'character varying',
		'entry_date' 		=> 'timestamp without time zone',
		'approve_by' 		=> 'character varying',
		'approve_date' 		=> 'timestamp without time zone',
		'approve_no' 		=> 'int',
		'ar_st' 			=> 'character varying',
		'print_seq' 		=> 'int',
		'vat_tp' 			=> 'character varying',
		'created_by' 		=> 'character varying',
		'updated_by' 		=> 'character varying',
		'created_at' 		=> 'timestamp without time zone',
		'updated_at' 		=> 'timestamp without time zone'
	];

	protected $fillable = [
		'ar_cd',
		'comp_cd',
		'ar_no',
		'ar_source',
		'ar_source_cd',
		'cust_cd',
		'invoice_no',
		'trx_year',
		'trx_month',
		'trx_date',
		'due_date',
		'form_cd',
		'top_cd',
		'currency_cd',
		'rate',
		'total_price',
		'freight_cost',
		'total_discount',
		'total_amount',
		'percent_ppn',
		'ppn',
		'entry_by',
		'entry_date',
		'approve_by',
		'approve_date',
		'approve_no',
		'note',
		'ar_st',
		'print_seq',
		'vat_tp',
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

	public function com_customer()
	{
		return $this->belongsTo(PublicComCustomer::class, 'cust_cd');
	}

	public function com_payment_type()
	{
		return $this->belongsTo(PublicComPaymentType::class, 'top_cd');
	}

	public function ar_trx_payments()
	{
		return $this->hasMany(ErpArTrxPayment::class, 'ar_cd');
	}

	public static function getArCd($compCd, $year, $month)
	{
		$data   = DB::select(DB::Raw("SELECT erp.fn_ar_get_trx_no('HEXSYS',$year, $month) as ar_cd"));

		return $data[0]->ar_cd;
	}

	public static function getTotalUnprocessMonth($compCd, $year, $month)
	{
		$data   = ErpArTrx::where(function($where) use($compCd, $year, $month){
					$where->where('comp_cd',$compCd);
					$where->where('trx_year',$year);
					$where->where('trx_month',$month);
					$where->whereIn('ar_st',['1','2']);
				})->count();
		
		return $data != 0 ? false : true;
	}
}
