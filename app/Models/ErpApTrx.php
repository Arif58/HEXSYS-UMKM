<?php
namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ErpApTrx
 * 
 * @property character varying $ap_cd
 * @property character varying|null $comp_cd
 * @property character varying|null $ap_no
 * @property character varying|null $ap_source
 * @property character varying|null $ap_source_cd
 * @property character varying|null $supplier_cd
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
 * @property character varying|null $ap_st
 * @property int|null $print_seq
 * @property character varying|null $vat_tp
 * @property character varying|null $created_by
 * @property character varying|null $updated_by
 * @property timestamp without time zone|null $created_at
 * @property timestamp without time zone|null $updated_at
 * 
 * @property PublicComCompany $com_company
 * @property PublicComCurrency $com_currency
 * @property Collection|ErpApTrxPayment[] $ap_trx_payments
 *
 * @package App\Models
 */
class ErpApTrx extends Model
{
	protected $table 		= 'erp.ap_trx';
	protected $primaryKey 	= 'ap_cd';
	public $incrementing 	= false;
	public $keyType 		= 'string';

	protected $casts = [
		'ap_cd' 			=> 'character varying',
		'comp_cd' 			=> 'character varying',
		'ap_no' 			=> 'character varying',
		'ap_source' 		=> 'character varying',
		'ap_source_cd' 		=> 'character varying',
		'supplier_cd' 		=> 'character varying',
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
		'ap_st' 			=> 'character varying',
		'print_seq' 		=> 'int',
		'vat_tp' 			=> 'character varying',
		'created_by' 		=> 'character varying',
		'updated_by' 		=> 'character varying',
		'created_at' 		=> 'timestamp without time zone',
		'updated_at' 		=> 'timestamp without time zone'
	];

	protected $fillable = [
		'ap_cd',
		'comp_cd',
		'ap_no',
		'ap_source',
		'ap_source_cd',
		'supplier_cd',
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
		'ap_st',
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

	public function com_supplier()
	{
		return $this->belongsTo(PublicComSupplier::class, 'supplier_cd');
	}

	public function com_payment_type()
	{
		return $this->belongsTo(PublicComPaymentType::class, 'top_cd');
	}

	public function ap_trx_payments()
	{
		return $this->hasMany(ErpApTrxPayment::class, 'ap_cd');
	}

	public static function getApCd($compCd, $year, $month)
	{
		$data   = DB::select(DB::Raw("SELECT erp.fn_ap_get_trx_no('HEXSYS',$year, $month) as ap_cd"));

		return $data[0]->ap_cd;
	}
	
	public static function getTotalUnprocessMonth($compCd, $year, $month)
	{
		$data   = ErpApTrx::where(function($where) use($compCd, $year, $month){
					$where->where('comp_cd',$compCd);
					$where->where('trx_year',$year);
					$where->where('trx_month',$month);
					$where->whereIn('ap_st',['1','2']);
				})->count();
		
		return $data != 0 ? false : true;
	}
}
