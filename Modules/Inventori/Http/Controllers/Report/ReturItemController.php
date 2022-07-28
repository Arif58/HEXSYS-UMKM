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

use App\Models\InvPoRetur;
use App\Models\InvPoReturDetail;

class ReturItemController extends Controller
{
    private $folder_path = 'report.retur-item';
    
    function __construct(){
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index($id = NULL)
    {
        $pageFileName  = 'index';
		$title         = 'Laporan Retur Barang';
		
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
		$data = InvPoRetur::select(
			"po_retur.retur_cd",
			"retur_no",
			"po_retur.supplier_cd",
			"supplier.supplier_nm",
			DB::Raw("fn_formatdatetime(po_retur.created_at) as entry_date"),
			//"po_retur.trx_date",
			"po_retur.note",
			"retur_st",
			"detail.item_cd",
			//"item.item_nm",
			DB::Raw("
			CASE
				WHEN detail.item_cd IS NULL THEN detail.item_desc
				ELSE item.item_nm
			END AS item_nm"),
			"detail.unit_cd",
			"detail.quantity"
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
		})
		->leftJoin('inv.po_supplier as supplier','supplier.supplier_cd','po_receive_item.supplier_cd')
		->leftJoin('inv.po_retur_detail as detail','detail.retur_cd','po_retur.retur_cd')
		->leftJoin('inv.inv_item_master as item','item.item_cd','detail.item_cd')
		->orderBy('entry_date','asc');

		return DataTables::of($data)
			->addColumn('retur_st_nm',function($data){
				switch ($data->ri_st) {
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
						return 'Cancel';
						break;
				}
		
			})
			->rawColumns(['retur_st_nm'])
			->make(true);

    }
}
