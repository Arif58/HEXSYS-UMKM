<?php
namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

use App\Models\PublicComCompany;
use App\Models\PublicComCurrency;
use App\Models\PublicComApproval;
use App\Models\ErpGlCoa;
/**
 * Class ErpGlReference
 * 
 * @property uuid $gl_reference_id
 * @property int $ref_year
 * @property int $ref_month
 * @property int $comp_cd
 * @property character varying|null $curr_default
 * @property character varying|null $curr_tp
 * @property character varying|null $account_format
 * @property character varying|null $account_ret_earning
 * @property character varying|null $account_rev_gain
 * @property character varying|null $account_rev_loss
 * @property character varying|null $ref_st
 * @property character varying|null $journal_approval_cd
 * @property character varying|null $posting_approval_cd
 * @property character varying|null $closing_approval_cd
 * @property character varying|null $created_by
 * @property character varying|null $updated_by
 * @property timestamp without time zone|null $created_at
 * @property timestamp without time zone|null $updated_at
 *
 * @package App\Models
 */
class ErpGlReference extends Model
{
	use Uuid;
	
	protected $table 		= 'erp.gl_reference';
	protected $primaryKey 	= 'gl_reference_id';
	public $incrementing 	= false;

	protected $casts = [
		'gl_reference_id' 		=> 'uuid',
		'ref_year' 				=> 'int',
		'ref_month' 			=> 'int',
		'comp_cd' 				=> 'character varying',
		'curr_default' 			=> 'character varying',
		'curr_tp' 				=> 'character varying',
		'account_format' 		=> 'character varying',
		'account_ret_earning' 	=> 'character varying',
		'account_rev_gain' 		=> 'character varying',
		'account_rev_loss' 		=> 'character varying',
		'ref_st' 				=> 'character varying',
		'journal_approval_cd' 	=> 'character varying',
		'posting_approval_cd' 	=> 'character varying',
		'closing_approval_cd' 	=> 'character varying',
		'created_by' 			=> 'character varying',
		'updated_by' 			=> 'character varying',
		'created_at' 			=> 'timestamp without time zone',
		'updated_at' 			=> 'timestamp without time zone'
	];

	protected $fillable = [
		'gl_reference_id',
		'ref_year',
		'ref_month',
		'comp_cd',
		'curr_default',
		'curr_tp',
		'account_format',
		'account_ret_earning',
		'account_rev_gain',
		'account_rev_loss',
		'ref_st',
		'journal_approval_cd',
		'posting_approval_cd',
		'closing_approval_cd',
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

	public function coa_account_ret_earning()
	{
		return $this->belongsTo(ErpGlCoa::class,'account_ret_earning', 'coa_cd');
	}

	public function coa_account_rev_gain()
	{
		return $this->belongsTo(ErpGlCoa::class,'account_rev_gain', 'coa_cd');
	}

	public function coa_account_rev_loss()
	{
		return $this->belongsTo(ErpGlCoa::class,'account_rev_loss', 'coa_cd');
	}

	public function journal_approval()
	{
		return $this->belongsTo(PublicComApproval::class, 'journal_approval_cd' ,'approval_cd');
	}

	public function posting_approval()
	{
		return $this->belongsTo(PublicComApproval::class, 'posting_approval_cd' ,'approval_cd');
	}

	public function closing_approval()
	{
		return $this->belongsTo(PublicComApproval::class, 'closing_approval_cd' ,'approval_cd');
	}


}
