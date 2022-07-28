<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PublicComForm
 * 
 * @property character varying $form_cd
 * @property character varying|null $comp_cd
 * @property character varying|null $form_nm
 * @property character varying|null $form_file
 * @property character varying|null $created_by
 * @property character varying|null $updated_by
 * @property timestamp without time zone|null $created_at
 * @property timestamp without time zone|null $updated_at
 * 
 * @property ComCompany $com_company
 *
 * @package App\Models
 */
class PublicComForm extends Model
{
	protected $table 		= 'public.com_form';
	protected $primaryKey 	= 'form_cd';
	public $incrementing 	= false;

	protected $casts = [
		'form_cd' => 'character varying',
		'comp_cd' => 'character varying',
		'form_nm' => 'character varying',
		'form_file' => 'character varying',
		'created_by' => 'character varying',
		'updated_by' => 'character varying',
		'created_at' => 'timestamp without time zone',
		'updated_at' => 'timestamp without time zone'
	];

	protected $fillable = [
		'form_cd',
		'comp_cd',
		'form_nm',
		'form_file',
		'created_by',
		'updated_by'
	];

	public function com_company()
	{
		return $this->belongsTo(PublicComCompany::class, 'comp_cd');
	}
}
