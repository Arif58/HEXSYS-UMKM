<?php
namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ErpCmReference
 * 
 * @property uuid $cm_reference_id
 * @property character varying $comp_cd
 * @property int $ref_year
 * @property int $ref_month
 * @property character varying|null $curr_default
 * @property character varying|null $curr_tp
 * @property character varying|null $journal_st
 * @property character varying|null $ref_st
 * @property character varying|null $cm_approval_cd
 * @property character varying|null $created_by
 * @property character varying|null $updated_by
 * @property timestamp without time zone|null $created_at
 * @property timestamp without time zone|null $updated_at
 * 
 * @property PublicComCompany $com_company
 * @property PublicComCurrency $com_currency
 * @property PublicComApproval $cm_approval_cd
 *
 * @package App\Models
 */
class ErpCmReference extends Model
{
	use Uuid;
	protected $table 		= 'erp.cm_reference';
	protected $primaryKey 	= 'cm_reference_id';
	public $incrementing 	= false;
	public $keyType 		= 'string';

	protected $casts = [
		'cm_reference_id' 	=> 'uuid',
		'comp_cd' 			=> 'character varying',
		'ref_year' 			=> 'int',
		'ref_month' 		=> 'int',
		'curr_default' 		=> 'character varying',
		'curr_tp' 			=> 'character varying',
		'journal_st' 		=> 'character varying',
		'ref_st' 			=> 'character varying',
		'cm_approval_cd' 	=> 'character varying',
		'created_by' 		=> 'character varying',
		'updated_by' 		=> 'character varying',
		'created_at' 		=> 'timestamp without time zone',
		'updated_at' 		=> 'timestamp without time zone'
	];

	protected $fillable = [
		'cm_reference_id',
		'comp_cd',
		'ref_year',
		'ref_month',
		'curr_default',
		'curr_tp',
		'journal_st',
		'ref_st',
		'cm_approval_cd',
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

	public function cm_approval_cd()
	{
		return $this->belongsTo(PublicComApproval::class, 'cm_approval_cd' ,'approval_cd');
	}
}
