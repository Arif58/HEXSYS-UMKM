<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ErpGlCoaType
 * 
 * @property character varying $coa_tp_cd
 * @property character varying|null $coa_tp_nm
 * @property character varying|null $dc_value
 * @property character varying|null $created_by
 * @property character varying|null $updated_by
 * @property timestamp without time zone|null $created_at
 * @property timestamp without time zone|null $updated_at
 * 
 * @property Collection|ErpGlCoa[] $gl_coas
 *
 * @package App\Models
 */
class ErpGlCoaType extends Model
{
	protected $table 		= 'erp.gl_coa_type';
	protected $primaryKey 	= 'coa_tp_cd';
	public $incrementing 	= false;
	public $keyType 		= 'string';

	protected $casts = [
		'coa_tp_cd' 	=> 'character varying',
		'coa_tp_nm' 	=> 'character varying',
		'dc_value' 		=> 'character varying',
		'created_by' 	=> 'character varying',
		'updated_by' 	=> 'character varying',
		'created_at' 	=> 'timestamp without time zone',
		'updated_at' 	=> 'timestamp without time zone'
	];

	protected $fillable = [
		'coa_tp_cd',
		'coa_tp_nm',
		'dc_value',
		'created_by',
		'updated_by'
	];

	public function gl_coas()
	{
		return $this->hasMany(ErpGlCoa::class, 'coa_tp_cd');
	}
}
