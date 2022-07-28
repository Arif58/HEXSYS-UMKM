<?php
namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ErpGlPostingYear
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
class ErpGlPostingYear extends Model
{
	protected $table 		= 'erp.gl_posting_year';
	protected $primaryKey 	= 'posting_cd';
	public $incrementing	= false;
	public $keyType 		= 'string';
	
	protected $casts = [
		'posting_cd' 	=> 'character varying',
		'coa_cd' 		=> 'character varying',
		'dc_value' 		=> 'character varying',
		'comp_cd' 		=> 'character varying',
		'currency_cd' 	=> 'character varying',
		'total_amount'	=> 'float',
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
		'posting_cd',
		'coa_cd',
		'dc_value',
		'comp_cd',
		'currency_cd',
		'total_amount',
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

	public function com_currency()
	{
		return $this->belongsTo(PublicComCurrency::class, 'currency_cd');
	}

	public function gl_coa()
	{
		return $this->belongsTo(ErpGlCoa::class, 'coa_cd');
	}
}
