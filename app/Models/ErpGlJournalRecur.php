<?php
namespace App\Models;

use Auth;
use DB;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ErpGlJournalRecur
 * 
 * @property character varying $recur_cd
 * @property character varying|null $comp_cd
 * @property character varying|null $recur_no
 * @property character varying|null $journal_cd
 * @property string|null $note
 * @property float|null $total_debit
 * @property float|null $total_credit
 * @property timestamp without time zone|null $start_valid
 * @property timestamp without time zone|null $end_valid
 * @property timestamp without time zone|null $due_date
 * @property int|null $freq_month
 * @property character varying|null $created_by
 * @property character varying|null $updated_by
 * @property timestamp without time zone|null $created_at
 * @property timestamp without time zone|null $updated_at
 * 
 * @property PublicComCompany $com_company
 *
 * @package App\Models
 */
class ErpGlJournalRecur extends Model
{
	protected $table 		= 'erp.gl_journal_recur';
	protected $primaryKey 	= 'recur_cd';
	public $incrementing	= false;
	public $keyType 		= 'string';
	
	protected $casts = [
		'recur_cd' 		=> 'character varying',
		'comp_cd' 		=> 'character varying',
		'recur_no' 		=> 'character varying',
		'journal_cd' 	=> 'character varying',
		'total_debit' 	=> 'float',
		'total_credit' 	=> 'float',
		'start_valid' 	=> 'timestamp without time zone',
		'end_valid' 	=> 'timestamp without time zone',
		'due_date'		=> 'timestamp without time zone',
		'freq_month' 	=> 'int',
		'created_by' 	=> 'character varying',
		'updated_by' 	=> 'character varying',
		'created_at' 	=> 'timestamp without time zone',
		'updated_at' 	=> 'timestamp without time zone'
	];

	protected $fillable = [
		'recur_cd',
		'comp_cd',
		'recur_no',
		'journal_cd',
		'note',
		'total_debit',
		'total_credit',
		'start_valid',
		'end_valid',
		'due_date',
		'freq_month',
		'created_by',
		'updated_by'
	];

	public function gl_journal_recur_details()
	{
		return $this->hasMany(ErpGlJournalRecurDetail::class, 'recur_cd');
	}

	public function com_company()
	{
		return $this->belongsTo(PublicComCompany::class, 'comp_cd');
	}
	
	public function gl_journal_doc()
	{
		return $this->belongsTo(ErpGlJournalDoc::class, 'journal_cd');
	}

	public function gl_cost_center()
	{
		return $this->belongsTo(ErpGlCostCenter::class, 'cc_cd');
	}

	public static function updateTotalAmount($id)
	{
		$totalDebit 	= ErpGlJournalRecurDetail::where([['recur_cd','=',$id],['dc_value','=','D']])->sum('trx_amount');
		$totalCredit 	= ErpGlJournalRecurDetail::where([['recur_cd','=',$id],['dc_value','=','C']])->sum('trx_amount');

		$data 				= ErpGlJournalRecur::find($id);
		$data->total_debit 	= $totalDebit;
		$data->total_credit = $totalCredit;
		$data->updated_by   = Auth::user()->user_id;
		$data->save();
		
		return "ok";
	}

	public static function getRecurCd($compCd, $year){
		$data = ErpGlJournalRecur::where(function($where) use($compCd, $year){
					$where->where('comp_cd',$compCd);
					$where->whereRaw("date_part('year',start_valid::date)::int = $year");
				})
				->max(DB::Raw("right(recur_cd,5)::int"));

		return $compCd.str_pad($data + 1 , 5 , "0" ,STR_PAD_LEFT);
    }
}
