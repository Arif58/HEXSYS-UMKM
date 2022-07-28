<?php
namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

use App\Models\PublicComCurrency;
use App\Models\ErpGlCoa;
/**
 * Class ErpGlJournalRecurDetail
 * 
 * @property uuid $gl_journal_recur_detail_id
 * @property int|null $trx_item_seq
 * @property character varying|null $recur_cd
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
 * @property ErpGlCoa $gl_coa
 *
 * @package App\Models
 */
class ErpGlJournalRecurDetail extends Model
{
	use Uuid;
	protected $table 		= 'erp.gl_journal_recur_detail';
	protected $primaryKey 	= 'gl_journal_recur_detail_id';
	public $incrementing 	= false;
	public $keyType 		= 'string';

	protected $casts = [
		'gl_journal_recur_detail_id' 	=> 'uuid',
		'trx_item_seq' 					=> 'int',
		'recur_cd' 						=> 'character varying',
		'coa_cd' 						=> 'character varying',
		'cc_cd' 						=> 'character varying',
		'dc_value' 						=> 'character varying',
		'currency_cd' 					=> 'character varying',
		'trx_amount' 					=> 'float',
		'rate' 							=> 'float',
		'created_by' 					=> 'character varying',
		'updated_by' 					=> 'character varying',
		'created_at' 					=> 'timestamp without time zone',
		'updated_at' 					=> 'timestamp without time zone'
	];

	protected $fillable = [
		'gl_journal_recur_detail_id',
		'trx_item_seq',
		'recur_cd',
		'coa_cd',
		'note',
		'cc_cd',
		'dc_value',
		'currency_cd',
		'trx_amount',
		'rate',
		'created_by',
		'updated_by'
	];

	public function gl_journal_recur()
	{
		return $this->belongsTo(ErpGlJournalRecur::class, 'recur_cd');
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

	public static function getTrxItemSeq($recurCd)
	{
		$data   = ErpGlJournalRecurDetail::where('recur_cd',$recurCd)->max('trx_item_seq');

		if ($data) {
			return $data + 1;
		}else{
			return 1;
		}
	}
}
