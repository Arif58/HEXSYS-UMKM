<?php

namespace Modules\Inventori\Http\Controllers\Report;

use DB;
use Auth;
use DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\InvPoPurchaseRequest;
use App\Models\InvInvPosInventori;
use App\Models\InvPoSupplier;
use App\Models\InvInvItemType;

class PurchaseRequestController extends Controller{
    private $folder_path = 'report.purchase-request';
    
    function __construct(){
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function index($id = NULL){
        $pageFileName	= 'index';
		$title			= 'Laporan Permintaan Barang';

		$gudangs		= InvInvPosInventori::all()->sortBy('pos_nm')
						 //->where('pos_root','')
						 ;
        $suppliers		= InvPoSupplier::all();
        //$types		= InvInvItemType::all();
        
        return view('inventori::' . $this->folder_path . '.' . $pageFileName, compact('title','gudangs', 'suppliers'));
    }

    /**
     * Display a listing of the resource for DataTables.
     *
     * @return \Illuminate\Http\Response
     */
    function getData(Request $request){
		$data = InvPoPurchaseRequest::select(
			"po_purchase_request.pr_cd",
			"pr_no",
			"po_purchase_request.pos_cd",
			"pos.pos_nm",
			//DB::Raw("fn_formatdate(po_purchase_request.trx_date) as trx_date"), 
			"po_purchase_request.trx_date as trx_date", 
			"note",
			"pr_st",
			"detail.item_cd",
			"item.item_nm",
			"detail.unit_cd",
			"detail.quantity"
		)
		->where(function($where) use($request){
			/* $posCd = $request->pos_cd_param;
			if ($posCd != '') {
				$where->where('pos.pos_cd',$posCd);
			} */
			/* $unit = empty(Auth::user()->unit_cd) ? '' : Auth::user()->unit_cd;
			if ($unit != '') {
				$where->where('pos.pos_cd',[$unit]);
			}  */
			
			if ($request->has('tanggal_param')) {
				$splitTanggal = explode("-",$request->tanggal_param);
				$tanggalStart = formatDate($splitTanggal[0]);
				$tanggalEnd   = formatDate($splitTanggal[1]);
	
				$where->whereRaw("trx_date::date between '$tanggalStart' and '$tanggalEnd'");
			}
		})
		->leftJoin('inv.po_pr_detail as detail','detail.pr_cd','po_purchase_request.pr_cd')
		->leftJoin('inv.inv_item_master as item','item.item_cd','detail.item_cd')
		->leftJoin('inv.inv_pos_inventori as pos','pos.pos_cd','po_purchase_request.pos_cd')
		->orderBy('trx_date','asc');

		return DataTables::of($data)
			->addColumn('pr_st_nm',function($data){
				switch ($data->pr_st) {
					case 'INV_TRX_ST_0':
						return 'Close';
						break;
					case 'INV_TRX_ST_1':
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
					
					default:
						return '';
						break;
				}
		
			})
			->make(true);

    }
}
