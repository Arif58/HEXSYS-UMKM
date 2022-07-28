<?php
namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ErpGlClosingMonth
 * 
 * @property character varying $closing_cd
 * @property character varying|null $comp_cd
 * @property float|null $ret_earning
 * @property float|null $rev_gain
 * @property float|null $rev_loss
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
 *
 * @package App\Models
 */

// ClsMain.gCOMPANYCODE & pintYear.ToString & Format(pintMonth, "00").ToString
class ErpGlClosingMonth extends Model
{
	protected $table 		= 'erp.gl_closing_month';
	protected $primaryKey 	= 'closing_cd';
	public $incrementing 	= false;
	public $keyType 		= 'string';
	
	protected $casts = [
		'closing_cd'	=> 'character varying',
		'comp_cd' 		=> 'character varying',
		'ret_earning' 	=> 'float',
		'rev_gain' 		=> 'float',
		'rev_loss' 		=> 'float',
		'process_by' 	=> 'character varying',
		'process_date' 	=> 'timestamp without time zone',
		'approve_by' 	=> 'character varying',
		'approve_date' 	=> 'timestamp without time zone',
		'approve_no' 	=> 'int',
		'created_by' 	=> 'character varying',
		'updated_by' 	=> 'character varying',
		'created_at' 	=> 'timestamp without time zone',
		'updated_at' 	=> 'timestamp without time zone'
	];

	protected $fillable = [
		'closing_cd',
		'comp_cd',
		'ret_earning',
		'rev_gain',
		'rev_loss',
		'process_by',
		'process_date',
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
}
