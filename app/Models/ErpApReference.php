<?php
namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ErpApReference
 * 
 * @property uuid $ap_reference_id
 * @property int $ref_year
 * @property int $ref_month
 * @property character varying $comp_cd
 * @property character varying|null $curr_default
 * @property character varying|null $curr_tp
 * @property character varying|null $journal_st
 * @property character varying|null $ref_st
 * @property character varying|null $ap_approval_cd
 * @property character varying|null $aging_cd_wd
 * @property character varying|null $aging_cd_od
 * @property character varying|null $created_by
 * @property character varying|null $updated_by
 * @property timestamp without time zone|null $created_at
 * @property timestamp without time zone|null $updated_at
 * 
 * @property PublicComCompany $com_company
 * @property PublicComCurrency $com_currency
 * @property PublicComApproval $ar_approval_cd
 * @property PublicComAging $aging_od_od
 * @property PublicComAging $aging_cd_od
 * @package App\Models
 */
class ErpApReference extends Model
{
	use Uuid;
	protected $table 		= 'erp.ap_reference';
	protected $primaryKey 	= 'ap_reference_id';
	public $incrementing 	= false;
	public $keyType 		= 'string';
	
	protected $casts = [
		'ap_reference_id' 	=> 'uuid',
		'ref_year' 			=> 'int',
		'ref_month' 		=> 'int',
		'comp_cd' 			=> 'character varying',
		'curr_default' 		=> 'character varying',
		'curr_tp' 			=> 'character varying',
		'journal_st' 		=> 'character varying',
		'ref_st' 			=> 'character varying',
		'ap_approval_cd' 	=> 'character varying',
		'aging_cd_wd' 		=> 'character varying',
		'aging_cd_od' 		=> 'character varying',
		'created_by' 		=> 'character varying',
		'updated_by' 		=> 'character varying',
		'created_at' 		=> 'timestamp without time zone',
		'updated_at' 		=> 'timestamp without time zone'
	];

	protected $fillable = [
		'ap_reference_id',
		'ref_year',
		'ref_month',
		'comp_cd',
		'curr_default',
		'curr_tp',
		'journal_st',
		'ref_st',
		'ap_approval_cd',
		'aging_cd_wd',
		'aging_cd_od',
		'created_by',
		'updated_by'
	];

	public function com_company()
	{
		return $this->belongsTo(PublicComCompany::class, 'comp_cd');
	}

	public function com_currency()
	{
		return $this->belongsTo(PublicComCurrency::class, 'curr_default' ,'currency_cd');
	}

	public function ap_approval_cd()
	{
		return $this->belongsTo(PublicComApproval::class, 'ap_approval_cd' ,'approval_cd');
	}

	public function aging_cd_wd()
	{
		return $this->belongsTo(PublicComAging::class, 'aging_cd_wd' ,'aging_cd');
	}

	public function aging_cd_od()
	{
		return $this->belongsTo(PublicComAging::class, 'aging_cd_od' ,'aging_cd');
	}
}
