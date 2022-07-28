<?php
namespace App\Models;

use DB;
use Auth;
use Illuminate\Database\Eloquent\Model;

use App\Models\ErpCmTrxDetail;
/**
 * Class ErpCmTrx
 * 
 * @property character varying $cm_cd
 * @property character varying|null $comp_cd
 * @property character varying|null $cm_tp
 * @property character varying|null $cm_no
 * @property character varying|null $cm_source
 * @property character varying|null $cm_source_cd
 * @property character varying|null $vendor_cd
 * @property int|null $trx_year
 * @property int|null $trx_month
 * @property timestamp without time zone|null $trx_date
 * @property character varying|null $journal_cd
 * @property int|null $journal_seq
 * @property character varying|null $form_cd
 * @property character varying|null $pay_cd
 * @property float|null $total_debit
 * @property float|null $total_credit
 * @property character varying|null $entry_by
 * @property timestamp without time zone|null $entry_date
 * @property character varying|null $approve_by
 * @property timestamp without time zone|null $approve_date
 * @property int|null $approve_no
 * @property string|null $note
 * @property character varying|null $cm_st
 * @property int|null $print_seq
 * @property character varying|null $created_by
 * @property character varying|null $updated_by
 * @property timestamp without time zone|null $created_at
 * @property timestamp without time zone|null $updated_at
 * 
 * @property PublicComCompany $com_company
 * @property ComForm $com_form
 *
 * @package App\Models
 */
class ErpCmTrx extends Model
{
	protected $table		= 'erp.cm_trx';
	protected Static $tableName = 'erp.cm_trx';
	protected $primaryKey	= 'cm_cd';
	public $incrementing	= false;
	public $keyType 		= 'string';

	protected $casts = [
		'cm_cd' 		=> 'character varying',
		'comp_cd' 		=> 'character varying',
		'cm_tp' 		=> 'character varying',
		'cm_no' 		=> 'character varying',
		'cm_source' 	=> 'character varying',
		'cm_source_cd'	=> 'character varying',
		'vendor_cd' 	=> 'character varying',
		'trx_year' 		=> 'int',
		'trx_month' 	=> 'int',
		'trx_date' 		=> 'timestamp without time zone',
		'journal_cd' 	=> 'character varying',
		'journal_seq' 	=> 'int',
		'form_cd' 		=> 'character varying',
		'pay_cd' 		=> 'character varying',
		'total_debit' 	=> 'float',
		'total_credit' 	=> 'float',
		'entry_by' 		=> 'character varying',
		'entry_date' 	=> 'timestamp without time zone',
		'approve_by' 	=> 'character varying',
		'approve_date' 	=> 'timestamp without time zone',
		'approve_no' 	=> 'int',
		'cm_st' 		=> 'character varying',
		'print_seq' 	=> 'int',
		'created_by' 	=> 'character varying',
		'updated_by' 	=> 'character varying',
		'created_at' 	=> 'timestamp without time zone',
		'updated_at' 	=> 'timestamp without time zone'
	];

	protected $fillable = [
		'cm_cd',
		'comp_cd',
		'cm_tp',
		'cm_no',
		'cm_source',
		'cm_source_cd',
		'vendor_cd',
		'trx_year',
		'trx_month',
		'trx_date',
		'journal_cd',
		'journal_seq',
		'form_cd',
		'pay_cd',
		'total_debit',
		'total_credit',
		'entry_by',
		'entry_date',
		'approve_by',
		'approve_date',
		'approve_no',
		'note',
		'cm_st',
		'print_seq',
		'created_by',
		'updated_by'
	];

	public function cm_trx_details()
	{
		return $this->hasMany(ErpCmTrxDetail::class, 'cm_cd')->orderBy('cm_seq');
	}

	public function com_supplier()
	{
		return $this->belongsTo(PublicComSupplier::class,'vendor_cd', 'supplier_cd');
	}

	public function com_customer()
	{
		return $this->belongsTo(PublicComCustomer::class,'vendor_cd', 'cust_cd');
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
	
	public function com_form()
	{
		return $this->belongsTo(ComForm::class, 'form_cd');
	}

	public static function updateTotalAmount($id)
	{
		$totalDebit 	= ErpCmTrxDetail::where([['cm_cd','=',$id],['dc_value','=','D']])->sum('trx_amount');
		$totalCredit 	= ErpCmTrxDetail::where([['cm_cd','=',$id],['dc_value','=','C']])->sum('trx_amount');

		$data 				= ErpCmTrx::find($id);
		$data->total_debit 	= $totalDebit;
		$data->total_credit = $totalCredit;
		$data->updated_by   = Auth::user()->user_id;
		$data->save();
		
		return "ok";
	}

	public static function getTrxCd($compCd, $year, $month)
	{
		$data   = DB::select(DB::Raw("SELECT erp.FN_CM_GET_TRX_NO('HEXSYS',$year, $month) as trx_cd"));

		return $data[0]->trx_cd;
	}

	public static function getTotalUnprocessMonth($compCd, $year, $month)
	{
		$data   = ErpCmTrx::where(function($where) use($compCd, $year, $month){
					$where->where('comp_cd',$compCd);
					$where->where('trx_year',$year);
					$where->where('trx_month',$month);
					$where->whereIn('cm_st',['1','2']);
				})->count();
		
		return $data != 0 ? false : true;
	}
	
	public static function findreport($cm_source,$cm_source_cd){
		$data = DB::table(Self::$tableName.' as A')
				->where('A.cm_source',$cm_source)
				->where('A.cm_source_cd',$cm_source_cd)
				->where('A.cm_tp','5')
                ->select('A.cm_cd')
				->first();
				
        return $data;
		
		/* $data = ErpCmTrx::where(function($where) use($cm_source, $cm_source_cd){
					$where->where('cm_source',$cm_source);
					$where->where('cm_source_cd',$cm_source_cd);
					$where->where('cm_tp','5');
				});
		
		return $data; */
    }
}
