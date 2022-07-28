<?php
namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

use App\Models\ErpGlCostCenter;
use App\Models\ErpGlTransaction;

/**
 * Class ErpGlTransactionDetail
 * 
 * @property uuid $gl_transaction_detail_id
 * @property character varying|null $trx_cd
 * @property character varying|null $coa_cd
 * @property string|null $note
 * @property character varying|null $cc_cd
 * @property character varying|null $dc_value
 * @property character varying|null $currency_cd
 * @property float|null $trx_amount
 * @property float|null $rate
 * @property character varying|null $created_by
 * @property character varying|null $updated_by
 * @property timestamp without time zone|null $created_at
 * @property timestamp without time zone|null $updated_at
 * 
 * @property PublicComCurrency $com_currency
 *
 * @package App\Models
 */
class ErpGlTransactionDetail extends Model
{
	use Uuid;
	protected $table 		= 'erp.gl_transaction_detail';
	protected Static $tableName = 'erp.gl_transaction_detail';
	protected $primaryKey 	= 'gl_transaction_detail_id';
	public $incrementing 	= false;
	public $keyType 		= 'string';

	protected $casts = [
		'gl_transaction_detail_id' 	=> 'uuid',
		'trx_cd' 					=> 'character varying',
		'trx_item_seq'				=> 'integer',
		'coa_cd' 					=> 'character varying',
		'currency_cd' 				=> 'character varying',
		'trx_amount' 				=> 'float',
		'rate' 						=> 'float',
		'dc_value' 					=> 'character varying',
		'cc_cd' 					=> 'character varying',
		'subunit_tp' 				=> 'character varying',
		'dana_tp' 					=> 'character varying',
		'standar_tp' 				=> 'character varying',
		'created_by' 				=> 'character varying',
		'updated_by' 				=> 'character varying',
		'created_at' 				=> 'timestamp without time zone',
		'updated_at' 				=> 'timestamp without time zone'
	];

	protected $fillable = [
		'gl_transaction_detail_id',
		'trx_cd',
		'trx_item_seq',
		'coa_cd',
		'currency_cd',
		'trx_amount',
		'rate',
		'dc_value',
		'cc_cd',
		'subunit_tp',
		'dana_tp',
		'standar_tp',
		'note',
		'created_by',
		'updated_by'
	];

	public function com_currency()
	{
		return $this->belongsTo(PublicComCurrency::class, 'currency_cd');
	}

	public function gl_transaction()
	{
		return $this->belongsTo(ErpGlTransaction::class, 'trx_cd');
	}

	public function gl_coa()
	{
		return $this->belongsTo(ErpGlCoa::class, 'coa_cd');
	}

	public function gl_cost_center()
	{
		return $this->belongsTo(ErpGlCostCenter::class, 'cc_cd');
	}
	
	public function comcode_subunit_tp()
	{
		return $this->belongsTo(PublicComCode::class, 'subunit_tp');
	}
	public function comcode_dana_tp()
	{
		return $this->belongsTo(PublicComCode::class, 'dana_tp');
	}
	public function comcode_standar_tp()
	{
		return $this->belongsTo(PublicComCode::class, 'standar_tp');
	}
	
	public static function getTrxItemSeq($trxCd)
	{
		$data   = ErpGlTransactionDetail::where('trx_cd',$trxCd)->max('trx_item_seq');

		if ($data) {
			return $data + 1;
		}else{
			return 1;
		}
	}
	
	public static function findByTrxcd($trxcd)
    {
		$data = DB::table(Self::$tableName.' as A')
				->where('trx_cd',$trxcd)
                ->select('A.*')
				->first();
				
        return $data;
		
		/* $data = DB::table(Self::$tableName)
                ->where('trx_cd',$trxcd)
                ->select('*');

        return $data->get(); */
    }
}
