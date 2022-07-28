<?php

namespace Modules\Inventori\Http\Controllers\Report;

use DB;
use Auth;
use DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\InvPoPurchaseOrder;
use App\Models\InvInvPosInventori;
use App\Models\InvPoSupplier;
use App\Models\InvInvItemType;

class PurchaseOrderController extends Controller{
    private $folder_path = 'report.purchase-order';
    
    function __construct(){
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function index($id = NULL){
		$pageFileName  = 'index';
		$title         = 'Laporan Purchase Order';

		$gudangs		= InvInvPosInventori::all()->sortBy('pos_nm')
						 //->where('pos_root','')
						 ;
        $suppliers		= InvPoSupplier::all();
        //$types      = InvInvItemType::all();
		
		return view('inventori::' . $this->folder_path . '.' . $pageFileName, compact('title','gudangs', 'suppliers'));
    }
	
	function realisasi($id = NULL){
		$pageFileName  = 'realisasi';
		$title         = 'Realisasi Purchase Order';

		$gudangs		= InvInvPosInventori::all()->sortBy('pos_nm')
						 //->where('pos_root','')
						 ;
        $suppliers		= InvPoSupplier::all();
        //$types      = InvInvItemType::all();
		
		return view('inventori::' . $this->folder_path . '.' . $pageFileName, compact('title','gudangs', 'suppliers'));
    }

    /**
     * Display a listing of the resource for DataTables.
     *
     * @return \Illuminate\Http\Response
     */
    function getData(Request $request){
		$data = InvPoPurchaseOrder::select(
			"po_cd",
			"po_no",
			"po_purchase_order.supplier_cd",
			"supplier.supplier_nm",
			"po_purchase_order.trx_date", 
			"note",
			"po_st",
			"popr_st",
			"po_purchase_order.dana_tp",
			"com.code_nm as dana_tp_nm",
			"po_purchase_order.created_by",
			"po_purchase_order.unit_cd",
			"po_purchase_order.total_amount"
		)
		->where(function($where) use($request){
			/* $unit = empty(Auth::user()->unit_cd) ? '' : Auth::user()->unit_cd;
			if ($unit !== '') {
				$where->where('unit_cd',[$unit]);
			} */
			
			if ($request->has('tanggal_param')) {
				$splitTanggal = explode("-",$request->tanggal_param);
				$tanggalStart = formatDate($splitTanggal[0]);
				$tanggalEnd   = formatDate($splitTanggal[1]);
	
				$where->whereRaw("trx_date::date between '$tanggalStart' and '$tanggalEnd'");
			}
			
			//$where->where('popr_st',null);
			$where->whereRaw("coalesce(popr_st,'')=''");
		})
		->leftJoin('inv.po_supplier as supplier','supplier.supplier_cd','po_purchase_order.supplier_cd')
		->leftJoin('public.com_code as com','com.com_cd','po_purchase_order.dana_tp')
		->leftJoin('erp.gl_cost_center as unit','unit.cc_cd','po_purchase_order.unit_cd')
		->orderBy('trx_date','asc');

		return DataTables::of($data)
			->addColumn('po_st_nm',function($data){
				switch ($data->po_st) {
					case 'INV_TRX_ST_0':
						return 'Close';
						break;
					case 'INV_TRX_ST_1':
						//return 'Purchase Order';
						return 'Input';
						break;
					case 'INV_TRX_ST_2':
						return 'Approval';
						break;
					case 'INV_TRX_ST_3':
						return 'Approval';
						break;
					case 'INV_TRX_ST_4':
						return 'Proses';
						break;
					case 'INV_TRX_ST_5':
						return 'Permintaan Pembelian';
						break;
					case 'INV_TRX_ST_9':
						return 'Reject';
						break;
					
					default:
						return '';
						break;
				}
		
			})
			->make(true);
    }
	
	function getRealisasi(Request $request){
		$data = InvPoPurchaseOrder::select(
			"po_cd",
			"po_no",
			"po_purchase_order.supplier_cd",
			"supplier.supplier_nm",
			"po_purchase_order.trx_date", 
			"note",
			"po_st",
			"popr_st",
			"po_purchase_order.dana_tp",
			"com.code_nm as dana_tp_nm",
			"po_purchase_order.created_by",
			"po_purchase_order.unit_cd",
			"po_purchase_order.total_amount"
		)
		->where(function($where) use($request){
			/* $unit = empty(Auth::user()->unit_cd) ? '' : Auth::user()->unit_cd;
			if ($unit !== '') {
				$where->where('unit_cd',[$unit]);
			} */
			
			if ($request->has('tanggal_param')) {
				$splitTanggal = explode("-",$request->tanggal_param);
				$tanggalStart = formatDate($splitTanggal[0]);
				$tanggalEnd   = formatDate($splitTanggal[1]);
	
				$where->whereRaw("trx_date::date between '$tanggalStart' and '$tanggalEnd'");
			}
			
			//$where->where('popr_st',null);
			$where->whereRaw("coalesce(popr_st,'')=''");
			$where->whereIn('po_st',['INV_TRX_ST_0','INV_TRX_ST_3']);
		})
		->leftJoin('inv.po_supplier as supplier','supplier.supplier_cd','po_purchase_order.supplier_cd')
		->leftJoin('public.com_code as com','com.com_cd','po_purchase_order.dana_tp')
		->leftJoin('erp.gl_cost_center as unit','unit.cc_cd','po_purchase_order.unit_cd')
		->orderBy('trx_date','asc');

		return DataTables::of($data)
			->addColumn('po_st_nm',function($data){
				switch ($data->po_st) {
					case 'INV_TRX_ST_0':
						return 'Close';
						break;
					case 'INV_TRX_ST_1':
						//return 'Purchase Order';
						return 'Input';
						break;
					case 'INV_TRX_ST_2':
						return 'Approval';
						break;
					case 'INV_TRX_ST_3':
						return 'Approval';
						break;
					case 'INV_TRX_ST_4':
						return 'Proses';
						break;
					case 'INV_TRX_ST_5':
						return 'Permintaan Pembelian';
						break;
					case 'INV_TRX_ST_9':
						return 'Reject';
						break;
					
					default:
						return '';
						break;
				}
		
			})
			->make(true);
    }
}
