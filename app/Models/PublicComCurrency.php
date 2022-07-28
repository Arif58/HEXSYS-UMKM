<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ComCurrency
 * 
 * @property character varying $currency_cd
 * @property character varying|null $currency_nm
 * @property character varying|null $currency_symbol
 * @property float|null $current_rate
 * @property character varying|null $created_by
 * @property character varying|null $updated_by
 * @property timestamp without time zone|null $created_at
 * @property timestamp without time zone|null $updated_at
 *
 * @package App\Models
 */
class PublicComCurrency extends Model
{
	protected $table 		= 'public.com_currency';
	protected $primaryKey 	= 'currency_cd';
	public $incrementing 	= false;
	public $keyType 		= 'string';

	protected $casts = [
		'currency_cd' 		=> 'character varying',
		'currency_nm' 		=> 'character varying',
		'currency_symbol'	=> 'character varying',
		'current_rate' 		=> 'float',
		'created_by' 		=> 'character varying',
		'updated_by' 		=> 'character varying',
		'created_at' 		=> 'timestamp without time zone',
		'updated_at' 		=> 'timestamp without time zone'
	];

	protected $fillable = [
		'currency_cd',
		'currency_nm',
		'currency_symbol',
		'current_rate',
		'created_by',
		'updated_by'
	];
}
