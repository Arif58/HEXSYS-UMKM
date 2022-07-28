<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PublicComAgingDetail
 * 
 * @property uuid $com_aging_detail_id
 * @property character varying $aging_cd
 * @property int $aging_no
 * @property int|null $value
 * @property character varying|null $created_by
 * @property character varying|null $updated_by
 * @property timestamp without time zone|null $created_at
 * @property timestamp without time zone|null $updated_at
 * 
 * @property PublicComAging $com_aging
 *
 * @package App\Models
 */
class PublicComAgingDetail extends Model
{
	use Uuid;
	protected $table 		= 'public.com_aging_detail';
	protected $primaryKey 	= 'com_aging_detail_id';
	public $incrementing 	= false;
	public $keyType 		= 'string';
	
	protected $casts = [
		'com_aging_detail_id' 	=> 'uuid',
		'aging_cd' 				=> 'character varying',
		'aging_no' 				=> 'int',
		'value' 				=> 'int',
		'created_by' 			=> 'character varying',
		'updated_by' 			=> 'character varying',
		'created_at' 			=> 'timestamp without time zone',
		'updated_at' 			=> 'timestamp without time zone'
	];

	protected $fillable = [
		'com_aging_detail_id',
		'aging_cd',
		'aging_no',
		'value',
		'created_by',
		'updated_by'
	];

	public function com_aging()
	{
		return $this->belongsTo(PublicComAging::class, 'aging_cd');
	}
}
