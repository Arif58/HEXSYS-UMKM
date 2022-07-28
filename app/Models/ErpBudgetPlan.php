<?php
namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BudgetPlan
 * 
 * @property uuid $budgetplan_cd
 * @property character varying|null $comp_cd
 * @property int|null $budget_year
 * @property int|null $budget_month
 * @property character varying|null $budget_cd
 * @property character varying|null $dept_cd
 * @property float|null $amount
 * @property character varying|null $approve_by
 * @property character varying|null $trx_st
 * @property timestamp without time zone|null $approve_date
 * @property int|null $approve_no
 * @property string|null $note
 * @property character varying|null $created_by
 * @property character varying|null $updated_by
 * @property timestamp without time zone|null $created_at
 * @property timestamp without time zone|null $updated_at
 * 
 * @property ComCompany $com_company
 *
 * @package App\Models
 */
class ErpBudgetPlan extends Model
{
	use Uuid;
	protected $table 		= 'erp.budget_plan';
	protected Static $tableName = 'erp.budget_plan';
	protected $primaryKey 	= 'budgetplan_cd';
	public $incrementing 	= false;
	public $keyType 		= 'string';

	protected $casts = [
		'budgetplan_cd' => 'uuid',
		'comp_cd' 		=> 'character varying',
		'budget_year' 	=> 'int',
		'budget_month' 	=> 'int',
		'budget_cd' 	=> 'character varying',
		'dept_cd' 		=> 'character varying',
		'amount' 		=> 'float',
		'currency_cd'	=> 'character varying',
		'rate'			=> 'float',
		'approve_by' 	=> 'character varying',
		'trx_st' 		=> 'character varying',
		'approve_date' 	=> 'timestamp without time zone',
		'approve_no' 	=> 'int',
		'cc_cd'			=> 'character varying',
		'subunit_tp'	=> 'character varying',
		'dana_tp'		=> 'character varying',
		'standar_tp'	=> 'character varying',
		'aktivitas_tp'	=> 'character varying',
		'aktivitas_cd'	=> 'character varying',
		'created_by' 	=> 'character varying',
		'updated_by' 	=> 'character varying',
		'created_at' 	=> 'timestamp without time zone',
		'updated_at' 	=> 'timestamp without time zone'
	];

	protected $fillable = [
		'budgetplan_cd',
		'comp_cd',
		'budget_year',
		'budget_month',
		'budget_cd',
		'dept_cd',
		'amount',
		'currency_cd',
		'rate',
		'approve_by',
		'trx_st',
		'approve_date',
		'approve_no',
		'cc_cd',
		'subunit_tp',
		'dana_tp',
		'standar_tp',
		'aktivitas_tp',
		'aktivitas_cd',
		'note',
		'created_by',
		'updated_by'
	];

	public function com_company()
	{
		return $this->belongsTo(ComCompany::class, 'comp_cd');
	}

	public function gl_coa()
	{
		return $this->belongsTo(ErpGlCoa::class, 'budget_cd', 'coa_cd');
	}
	
	public function gl_cost_center()
	{
		return $this->belongsTo(ErpGlCostCenter::class, 'cc_cd');
	}
	public function comcode_subunit_tp()
	{
		return $this->belongsTo(PublicComCode::class, 'subunit_tp');
	}
	public function comcode_dana_tp()
	{
		return $this->belongsTo(PublicComCode::class, 'dana_tp');
	}
	public function comcode_standar_tp()
	{
		return $this->belongsTo(PublicComCode::class, 'standar_tp');
	}
	public function comcode_aktivitas_tp()
	{
		return $this->belongsTo(PublicComCode::class, 'aktivitas_item');
	}
	public function gl_aktivitas()
	{
		return $this->belongsTo(PublicComAktivitas::class, 'aktivitas_cd');
	}
	
	public function isExist($year, $coacd, $cccd, $danatp, $standartp, $aktivitascd){
		$data = DB::table(Self::$tableName.' as A')
                ->where("A.budget_year", $year)
				->where("A.coa_cd", $coacd)
				->where("A.cc_cd", $cccd)
				->where("A.dana_tp", $danatp)
				->where("A.standar_tp", $standartp)
				->where("A.aktivitas_cd", $aktivitascd)
				//->where("A.aktivitas_tp", $aktivitastp)
				->select('A.budgetplan_cd')
				->first();
		
		return data;
    }
}
