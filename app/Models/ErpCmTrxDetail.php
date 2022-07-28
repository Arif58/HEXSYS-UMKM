<?php
namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use DB;

/**
 * Class ErpCmTrxDetail
 * 
 * @property uuid $cm_transaction_detail_id
 * @property int|null $cm_seq
 * @property character varying|null $currency_cd
 * @property float|null $rate
 * @property float|null $trx_amount
 * @property string|null $note
 * @property character varying|null $dc_value
 * @property character varying|null $coa_cd
 * @property character varying|null $cc_cd
 * @property character varying|null $created_by
 * @property character varying|null $updated_by
 * @property timestamp without time zone|null $created_at
 * @property timestamp without time zone|null $updated_at
 * 
 * @property PublicComCurrency $com_currency
 * @property PublicComCurrency $com_currency
 * @package App\Models
 */
class ErpCmTrxDetail extends Model
{
	use Uuid;
	protected $table 		= 'erp.cm_trx_detail';
	protected Static $tableName = 'erp.cm_trx_detail';
	protected $primaryKey 	= 'cm_transaction_detail_id';
	public $incrementing 	= false;
	public $keyType 		= 'string';
	
	protected $casts = [
		'cm_transaction_detail_id' 	=> 'uuid',
		'cm_cd' 					=> 'character varying',
		'cm_seq' 					=> 'int',
		'coa_cd' 					=> 'character varying',
		'currency_cd' 				=> 'character varying',
		'rate' 						=> 'float',
		'trx_amount' 				=> 'float',
		'item_jumlah' 				=> 'int',
		'item_amount' 				=> 'float',
		'dc_value' 					=> 'character varying',
		'cc_cd' 					=> 'character varying',
		'subunit_tp' 				=> 'character varying',
		'dana_tp' 					=> 'character varying',
		'standar_tp' 				=> 'character varying',
		'aktivitas_cd'				=> 'character varying',
		'aktivitas_item'			=> 'character varying',
		'cmcash_tp' 				=> 'character varying',
		'created_by' 				=> 'character varying',
		'updated_by' 				=> 'character varying',
		'created_at' 				=> 'timestamp without time zone',
		'updated_at' 				=> 'timestamp without time zone'
	];

	protected $fillable = [
		'cm_transaction_detail_id',
		'cm_cd',
		'cm_seq',
		'coa_cd',
		'currency_cd',
		'rate',
		'trx_amount',
		'item_jumlah',
		'item_amount',
		'dc_value',
		'cc_cd',
		'subunit_tp',
		'dana_tp',
		'standar_tp',
		'aktivitas_cd',
		'aktivitas_item',
		'cmcash_tp',
		'note',
		'created_by',
		'updated_by'
	];

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
	
	public function gl_aktivitas()
	{
		return $this->belongsTo(PublicComAktivitas::class, 'aktivitas_cd');
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
	public function comcode_aktivitas_item()
	{
		return $this->belongsTo(PublicComCode::class, 'aktivitas_item');
	}
	public function comcode_cmcash_tp()
	{
		return $this->belongsTo(PublicComCode::class, 'cmcash_tp');
	}

	public static function getCmItemSeq($cmCd)
	{
		$data   = ErpCmTrxDetail::where('cm_cd',$cmCd)->max('cm_seq');

		if ($data) {
			return $data + 1;
		}else{
			return 1;
		}
	}
	
	public static function findByTrxcd($cmcd)
    {
		$data = DB::table(Self::$tableName.' as A')
				->where('cm_cd',$cmcd)
                ->select('A.*')
				->get();
				
        return $data;
    }
}
