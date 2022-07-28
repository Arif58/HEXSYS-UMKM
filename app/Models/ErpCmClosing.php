<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ErpCmClosing
 * 
 * @property character varying $closing_cd
 * @property character varying|null $comp_cd
 * @property character varying|null $process_by
 * @property timestamp without time zone|null $process_date
 * @property character varying|null $approve_by
 * @property timestamp without time zone|null $approve_date
 * @property int|null $approve_no
 * @property character varying|null $closing_tp
 * @property character varying|null $created_by
 * @property character varying|null $updated_by
 * @property timestamp without time zone|null $created_at
 * @property timestamp without time zone|null $updated_at
 * 
 * @property PublicComCompany $com_company
 *
 * @package App\Models
 */
class ErpCmClosing extends Model
{
	protected $table 		= 'erp.cm_closing';
	protected $primaryKey 	= 'closing_cd';
	public $incrementing 	= false;
	public $keyType 		= 'string';

	protected $casts = [
		'closing_cd' 	=> 'character varying',
		'comp_cd' 		=> 'character varying',
		'process_by' 	=> 'character varying',
		'process_date' 	=> 'timestamp without time zone',
		'approve_by' 	=> 'character varying',
		'approve_date' 	=> 'timestamp without time zone',
		'approve_no' 	=> 'int',
		'closing_tp' 	=> 'character varying',
		'created_by' 	=> 'character varying',
		'updated_by' 	=> 'character varying',
		'created_at' 	=> 'timestamp without time zone',
		'updated_at' 	=> 'timestamp without time zone'
	];

	protected $fillable = [
		'closing_cd',
		'comp_cd',
		'process_by',
		'process_date',
		'approve_by',
		'approve_date',
		'approve_no',
		'closing_tp',
		'created_by',
		'updated_by'
	];

	public function com_company()
	{
		return $this->belongsTo(PublicComCompany::class, 'comp_cd');
	}
}
