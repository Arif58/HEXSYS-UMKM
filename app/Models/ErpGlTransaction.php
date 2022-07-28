<?php
namespace App\Models;

use Auth;
use DB;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\ErpGlJournalDoc;
use App\Models\ErpGlCostCenter;

/**
 * Class ErpGlTransaction
 * 
 * @property character varying $trx_cd
 * @property character varying|null $comp_cd
 * @property character varying|null $gl_source
 * @property character varying|null $gl_source_cd
 * @property int|null $trx_year
 * @property int|null $trx_month
 * @property character varying|null $journal_no
 * @property character varying|null $journal_cd
 * @property int|null $journal_seq
 * @property Carbon|null $trx_date
 * @property string|null $note
 * @property float|null $total_debit
 * @property float|null $total_credit
 * @property character varying $reverse_st
 * @property character varying $post_st
 * @property character varying|null $entry_by
 * @property timestamp without time zone|null $entry_date
 * @property character varying|null $post_by
 * @property timestamp without time zone|null $post_date
 * @property character varying|null $approve_by
 * @property timestamp without time zone|null $approve_date
 * @property int|null $approve_no
 * @property character varying|null $journal_tp
 * @property character varying|null $created_by
 * @property character varying|null $updated_by
 * @property timestamp without time zone|null $created_at
 * @property timestamp without time zone|null $updated_at
 * 
 * @property PublicComCompany $com_company
 *
 * @package App\Models
 */
class ErpGlTransaction extends Model
{
	protected $table 		= 'erp.gl_transaction';
	protected Static $tableName = 'erp.gl_transaction';
	protected $primaryKey 	= 'trx_cd';
	public $incrementing 	= false;
	public $keyType 		= 'string';

	protected $casts = [
		'trx_cd' 		=> 'character varying',
		'comp_cd' 		=> 'character varying',
		'gl_source' 	=> 'character varying',
		'gl_source_cd' 	=> 'character varying',
		'trx_year' 		=> 'int',
		'trx_month' 	=> 'int',
		'journal_no' 	=> 'character varying',
		'journal_cd' 	=> 'character varying',
		'journal_seq' 	=> 'int',
		'total_debit' 	=> 'float',
		'total_credit'	=> 'float',
		'reverse_st' 	=> 'character varying',
		'post_st' 		=> 'character varying',
		'entry_by' 		=> 'character varying',
		'entry_date' 	=> 'timestamp without time zone',
		'post_by' 		=> 'character varying',
		'post_date' 	=> 'timestamp without time zone',
		'approve_by' 	=> 'character varying',
		'approve_date' 	=> 'timestamp without time zone',
		'approve_no' 	=> 'int',
		'journal_tp' 	=> 'character varying',
		'created_by' 	=> 'character varying',
		'updated_by' 	=> 'character varying',
		'created_at' 	=> 'timestamp without time zone',
		'updated_at' 	=> 'timestamp without time zone'
	];

	protected $dates = [
		'trx_date'
	];

	protected $fillable = [
		'trx_cd',
		'comp_cd',
		'gl_source',
		'gl_source_cd',
		'trx_year',
		'trx_month',
		'journal_no',
		'journal_cd',
		'journal_seq',
		'trx_date',
		'note',
		'total_debit',
		'total_credit',
		'reverse_st',
		'post_st',
		'entry_by',
		'entry_date',
		'post_by',
		'post_date',
		'approve_by',
		'approve_date',
		'approve_no',
		'journal_tp',
		'created_by',
		'updated_by'
	];

	public function gl_transaction_details()
	{
		return $this->hasMany(ErpGlTransactionDetail::class, 'trx_cd');
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
		$totalDebit 	= ErpGlTransactionDetail::where([['trx_cd','=',$id],['dc_value','=','D']])->sum('trx_amount');
		$totalCredit 	= ErpGlTransactionDetail::where([['trx_cd','=',$id],['dc_value','=','C']])->sum('trx_amount');

		$data 				= ErpGlTransaction::find($id);
		$data->total_debit 	= $totalDebit;
		$data->total_credit = $totalCredit;
		$data->updated_by   = Auth::user()->user_id;
		$data->save();
		
		return "ok";
	}

	public static function getTrxCd($compCd, $year, $month)
	{
		$data   = DB::select(DB::Raw("SELECT erp.FN_GL_GET_TRX_NO('HEXSYS',$year, $month) as trx_cd"));

		return $data[0]->trx_cd;
	}

	public static function getJournalSeq($compCd, $journalCd, $year, $month)
	{
		$data   = DB::select(DB::Raw("SELECT erp.fn_gl_get_last_journalseq('HEXSYS', '$journalCd', $year, $month) as journal_seq"));

		return $data[0]->journal_seq;
	}
	
	public static function deleteTrx($id)
    {
		try {
			DB::table('erp.gl_transaction_detail')->where('trx_cd','=',$id)->delete();
			DB::table('erp.gl_transaction')->where('trx_cd','=',$id)->delete();
		}
		catch (Exception $exc) {
			return compact(false,$exc->getMessage());
		}
		
		return true;
    }
	
	public static function findbySource($gl_source,$gl_source_cd){
		$data = DB::table(Self::$tableName.' as A')
				->where('A.gl_source',$gl_source)
				->where('A.gl_source_cd',$gl_source_cd)
                ->select('A.trx_cd')
				->first();
				
        return $data;
		
		/* $data = ErpGlTransaction::select('A.trx_cd')
                ->where('A.gl_source',$gl_source)
				->where('A.gl_source_cd',$gl_source_cd)
				->first(); */
		
		/* $data   = DB::select(
				  DB::Raw("SELECT A.trx_cd
						  FROM erp.gl_transaction A
						  WHERE A.gl_source=$gl_source AND A.gl_source_cd=$gl_source_cd"));

		return $data; */
    }
}
