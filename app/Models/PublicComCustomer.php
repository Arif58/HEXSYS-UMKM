<?php
namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PublicComCustomer
 * 
 * @property character varying $cust_cd
 * @property character varying $comp_cd
 * @property character varying|null $ref_cd
 * @property character varying|null $cust_nm
 * @property string|null $address
 * @property character varying|null $region_prop
 * @property character varying|null $region_kab
 * @property character varying|null $postcode
 * @property character varying|null $phone
 * @property character varying|null $fax
 * @property character varying|null $email
 * @property character varying|null $npwp
 * @property character varying|null $nppkp
 * @property character varying|null $pkp_st
 * @property Carbon|null $pkp_date
 * @property character varying|null $pic
 * @property character varying|null $ar_coa
 * @property character varying|null $created_by
 * @property character varying|null $updated_by
 * @property timestamp without time zone|null $created_at
 * @property timestamp without time zone|null $updated_at
 * 
 * @property PublicComCompany $com_company
 *
 * @package App\Models
 */
class PublicComCustomer extends Model
{
	protected $table 		= 'public.com_customer';
	protected $primaryKey 	= 'cust_cd';
	public $incrementing 	= false;
	public $keyType 		= 'string';
	
	protected $casts = [
		'cust_cd' 		=> 'character varying',
		'comp_cd' 		=> 'character varying',
		'ref_cd' 		=> 'character varying',
		'cust_nm' 		=> 'character varying',
		'region_prop' 	=> 'character varying',
		'region_kab' 	=> 'character varying',
		'postcode' 		=> 'character varying',
		'phone' 		=> 'character varying',
		'fax' 			=> 'character varying',
		'email' 		=> 'character varying',
		'npwp' 			=> 'character varying',
		'nppkp' 		=> 'character varying',
		'pkp_st' 		=> 'character varying',
		'pic' 			=> 'character varying',
		'ar_coa' 		=> 'character varying',
		'created_by' 	=> 'character varying',
		'updated_by' 	=> 'character varying',
		'created_at' 	=> 'timestamp without time zone',
		'updated_at' 	=> 'timestamp without time zone'
	];

	protected $dates = [
		'pkp_date'
	];

	protected $fillable = [
		'cust_cd',
		'comp_cd',
		'ref_cd',
		'cust_nm',
		'address',
		'region_prop',
		'region_kab',
		'postcode',
		'phone',
		'fax',
		'email',
		'npwp',
		'nppkp',
		'pkp_st',
		'pkp_date',
		'pic',
		'ar_coa',
		'created_by',
		'updated_by'
	];

	public function com_company()
	{
		return $this->belongsTo(PublicComCompany::class, 'comp_cd');
	}
}
