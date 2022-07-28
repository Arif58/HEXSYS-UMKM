<?php
namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

use App\Models\ErpGlCostCenter;

/**
 * Class ErpGlPostingMonth
 * 
 * @property character varying $posting_cd
 * @property character varying|null $coa_cd
 * @property character varying|null $dc_value
 * @property character varying|null $comp_cd
 * @property character varying|null $currency_cd
 * @property float|null $total_amount
 * @property character varying|null $process_by
 * @property timestamp without time zone|null $process_date
 * @property character varying|null $approve_by
 * @property timestamp without time zone|null $approve_date
 * @property int|null $approve_no
 * @property character varying|null $created_by
 * @property character varying|null $updated_by
 * @property timestamp without time zone|null $created_at
 * @property timestamp without time zone|null $updated_at
 * 
 * @property PublicComCompany $com_company
 * @property PublicComCurrency $com_currency
 * @property ErpGlCoa $gl_coa
 * @package App\Models
 */
class ErpGlPostingMonth extends Model
{
	use Uuid;
	
	protected $table 		= 'erp.gl_posting_month';
	protected $primaryKey 	= 'posting_month_id';
	public $incrementing 	= false;
	public $keyType 		= 'string';
	
	protected $casts = [
		'posting_month_id' => 'uuid',
		'posting_cd' 	=> 'character varying',
		'coa_cd' 		=> 'character varying',
		'dc_value' 		=> 'character varying',
		'comp_cd' 		=> 'character varying',
		'currency_cd' 	=> 'character varying',
		'total_amount' 	=> 'float',
		'process_by' 	=> 'character varying',
		'process_date' 	=> 'timestamp without time zone',
		'cc_cd'			=> 'character varying',
		'subunit_tp'	=> 'character varying',
		'dana_tp'		=> 'character varying',
		'standar_tp'	=> 'character varying',
		'approve_by'	=> 'character varying',
		'approve_date' 	=> 'timestamp without time zone',
		'approve_no' 	=> 'int',
		'created_by' 	=> 'character varying',
		'updated_by' 	=> 'character varying',
		'created_at' 	=> 'timestamp without time zone',
		'updated_at' 	=> 'timestamp without time zone'
	];

	protected $fillable = [
		'posting_month_id',
		'posting_cd',
		'coa_cd',
		'dc_value',
		'comp_cd',
		'currency_cd',
		'total_amount',
		'process_by',
		'process_date',
		'cc_cd',
		'subunit_tp',
		'dana_tp',
		'standar_tp',
		'approve_by',
		'approve_date',
		'approve_no',
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
}
