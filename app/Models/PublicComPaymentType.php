<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PublicComPaymentType
 * 
 * @property character varying $top_cd
 * @property character varying|null $top_nm
 * @property int $top_total_day
 * @property int $top_total_month
 * @property character varying|null $created_by
 * @property character varying|null $updated_by
 * @property timestamp without time zone|null $created_at
 * @property timestamp without time zone|null $updated_at
 *
 * @package App\Models
 */
class PublicComPaymentType extends Model
{
	protected $table 		= 'public.com_payment_type';
	protected $primaryKey 	= 'top_cd';
	public $incrementing 	= false;
	public $keyType 		= 'string';
	
	protected $casts = [
		'top_cd' 			=> 'character varying',
		'top_nm' 			=> 'character varying',
		'top_total_day' 	=> 'int',
		'top_total_month' 	=> 'int',
		'created_by' 		=> 'character varying',
		'updated_by' 		=> 'character varying',
		'created_at' 		=> 'timestamp without time zone',
		'updated_at' 		=> 'timestamp without time zone'
	];

	protected $fillable = [
		'top_cd',
		'top_nm',
		'top_total_day',
		'top_total_month',
		'created_by',
		'updated_by'
	];
}
