<?php
namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ComCompanyBank
 * 
 * @property uuid $com_company_bank_id
 * @property character varying $comp_cd
 * @property character varying $account_cd
 * @property character varying|null $bank_cd
 * @property character varying|null $branch_nm
 * @property character varying|null $account_nm
 * @property character varying|null $account_no
 * @property character varying|null $currency_cd
 * @property character varying|null $created_by
 * @property character varying|null $updated_by
 * @property timestamp without time zone|null $created_at
 * @property timestamp without time zone|null $updated_at
 *
 * @package App\Models
 */
class PublicComCompanyBank extends Model
{
	use Uuid;
	protected $table 		= 'public.com_company_bank';
	protected $primaryKey 	= 'com_company_bank_id';
	public $incrementing 	= false;
	public $keyType 		= 'string';

	protected $casts = [
		'com_company_bank_id'	=> 'uuid',
		'comp_cd' 				=> 'character varying',
		'account_cd' 			=> 'character varying',
		'bank_cd' 				=> 'character varying',
		'branch_nm' 			=> 'character varying',
		'account_nm' 			=> 'character varying',
		'account_no' 			=> 'character varying',
		'currency_cd'			=> 'character varying',
		'created_by' 			=> 'character varying',
		'updated_by' 			=> 'character varying',
		'created_at' 			=> 'timestamp without time zone',
		'updated_at' 			=> 'timestamp without time zone'
	];

	protected $fillable = [
		'com_company_bank_id',
		'comp_cd',
		'account_cd',
		'bank_cd',
		'branch_nm',
		'account_nm',
		'account_no',
		'currency_cd',
		'created_by',
		'updated_by'
	];

	public function com_company()
	{
		return $this->belongsTo(PublicComCompany::class, 'comp_cd');
	}

	public function com_bank()
	{
		return $this->belongsTo(PublicComBank::class, 'bank_cd');
	}

	public function com_currency()
	{
		return $this->belongsTo(PublicComCurrency::class, 'currency_cd');
	}
}
