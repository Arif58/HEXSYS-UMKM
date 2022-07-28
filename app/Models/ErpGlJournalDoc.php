<?php
namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ErpGlJournalDoc
 * 
 * @property character varying $comp_cd
 * @property character varying $journal_cd
 * @property character varying $journal_nm
 * @property character varying $seq_tp
 * @property character varying|null $form_cd
 * @property character varying|null $created_by
 * @property character varying|null $updated_by
 * @property timestamp without time zone|null $created_at
 * @property timestamp without time zone|null $updated_at
 * 
 * @property PublicComCompany $com_company
 * @property PublicComForm $com_form
 *
 * @package App\Models
 */
class ErpGlJournalDoc extends Model
{
	protected $table 		= 'erp.gl_journal_doc';
	protected $primaryKey	= 'journal_cd';
	public $incrementing	= false;
	public $keyType 	  	= 'string';

	protected $casts = [
		'journal_cd' 	=> 'character varying',
		'comp_cd' 		=> 'character varying',
		'journal_nm' 	=> 'character varying',
		'seq_tp' 		=> 'character varying',
		'form_cd' 		=> 'character varying',
		'created_by' 	=> 'character varying',
		'updated_by' 	=> 'character varying',
		'created_at' 	=> 'timestamp without time zone',
		'updated_at' 	=> 'timestamp without time zone'
	];

	protected $fillable = [
		'journal_cd',
		'comp_cd',
		'journal_cd',
		'journal_nm',
		'seq_tp',
		'form_cd',
		'created_by',
		'updated_by'
	];

	public function com_company()
	{
		return $this->belongsTo(PublicComCompany::class, 'comp_cd');
	}

	public function com_form()
	{
		return $this->belongsTo(PublicComForm::class, 'form_cd');
	}
}
