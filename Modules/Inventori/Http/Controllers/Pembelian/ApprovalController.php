<?php

namespace Modules\Inventori\Http\Controllers\Pembelian;

use DB;
use Auth;
use DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\PublicTrxApproval;
use App\Models\InvPoPurchaseOrder;
use App\Models\InvPoPoDetail;
use App\Models\InvPoSupplier;
use App\Models\InvInvPosInventori;
use App\Models\InvVwInvPoDetail;
use App\Models\PublicTrxFile;
use App\Models\InvInvItemType;
use App\Models\InvInvUnit;

class ApprovalController extends Controller{
    private $folder_path    = 'pembelian.approval';
    private $compCd 		= 'HEXSYS';
    
    function __construct(){
        $this->middleware('auth');
		
		$this->compCd = configuration('COMP_CD') == '' ? $this->compCd : configuration('COMP_CD');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function index(){
        $pageFileName = 'index';
        $title        = 'Approval';
		
		$suppliers  = InvPoSupplier::all();
        $gudangs	= InvInvPosInventori::all()->sortBy('pos_nm');//->where('pos_root','');
		
        \LogActivityHelpers::saveLog(
            $logTp = 'visit', 
            $logNm = "Membuka Menu $title"
        );
        
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
				"po_purchase_order.dana_tp",
                "com.code_nm as dana_tp_nm",
				"po_purchase_order.created_by",
				"unit.cc_cd",
				"unit_cd",
				"po_purchase_order.total_amount"
				)
                ->where(function($where) use($request){
					$unit = empty(Auth::user()->unit_cd) ? '' : Auth::user()->unit_cd;
					if ($unit !== '') {
                        $where->where('unit_cd',[$unit]);
                    }
					if (Auth::user()->user_id == 'manager1') {
                        $where->whereIn('unit_cd',['TK','SD1','SD2','SD3','SMP']);
                    }
					if (Auth::user()->user_id == 'manager2') {
                        $where->whereIn('unit_cd',['LITBANG','IT']);
                    }
					if (Auth::user()->user_id == 'manager3') {
                        $where->whereIn('unit_cd',['LOGISTIK','AKUNTING','PERSONALIA','PERPUSTAKAAN','SERVICE']);
                    }
					
                    if ($request->has('trx_date_param')) {
						$splitTanggal = explode("-",$request->trx_date_param);
						$tanggalStart = formatDate($splitTanggal[0]);
						$tanggalEnd   = formatDate($splitTanggal[1]);
			
						$where->whereRaw("trx_date::date between '$tanggalStart' and '$tanggalEnd'");
					}
					
                    $role = roleUser();
                    $where->whereRaw("inv.fn_po_get_group_approval_st('$this->compCd','$role', po_cd::varchar) = 1");
					$where->whereIn('po_st',['INV_TRX_ST_1','INV_TRX_ST_2','INV_TRX_ST_5']);
					//$where->whereIn('po_st',['INV_TRX_ST_2','INV_TRX_ST_5']);
					//$where->where('po_source',null);
					//$where->whereRaw("coalesce(po_source,'')=''");
                })
				->leftJoin('inv.po_supplier as supplier','supplier.supplier_cd','po_purchase_order.supplier_cd')
				->leftJoin('public.com_code as com','com.com_cd','po_purchase_order.dana_tp')
				->leftJoin('erp.gl_cost_center as unit','unit.cc_cd','po_purchase_order.unit_cd')
				->orderBy('trx_date','desc');

        return DataTables::of($data)
                ->addColumn('actions', function($data){
                    $actions = '';
					
					$approvalmax = 0;
					$approvalst = '';
					$approval1 = '';
					$approval2 = '';
					$approval3 = '';
					$approval = PublicTrxApproval::select(
										"trx_cd","approve_no","approval_st",
										DB::Raw("coalesce(approval_1,null,'') as approval_1"),
										DB::Raw("coalesce(approval_2,null,'') as approval_2"),
										DB::Raw("coalesce(approval_3,null,'') as approval_3"),
									)
									->where('trx_cd','PO'.$data->po_cd)
									->orderBy('approve_no', 'desc')
									->first();
					if ($approval) {
						$approvalmax = $approval->approve_no;
						$approvalst = $approval->approval_st;
						
						$approval1 = $approval->approval_1;
						$approval2 = $approval->approval_2;
						$approval3 = $approval->approval_3;
					}
					
                    //$actions .= "<button type='button' class='approve btn btn-info btn-flat btn-sm' data-toggle='tooltip' data-placement='top' title='Approval'><i class='icon icon-check'></i> </button>";
					
					//if ($data->approve_no-1 == 1) {
					//if (in_array(Auth::user()->user_id, array('manager1','manager2','manager3'))) {
					if (roleUser() == 'manager') {
						/* if (!in_array(Auth::user()->user_id, array($approval1,$approval2,$approval3))) {	
						$actions .= "<button type='button' class='approve btn btn-info btn-flat btn-sm' data-toggle='tooltip' data-placement='top' title='Approval'><i class='icon icon-check'></i> </button> &nbsp";
						} */
						
						if ( Auth::user()->user_id=='manager1' and in_array($data->unit_cd, array('TK','SD1','SD2','SD3','SMP')) ) {
							if (!in_array(Auth::user()->user_id, array($approval1,$approval2,$approval3))) {
							$actions .= "<button type='button' class='approve btn btn-info btn-flat btn-sm' data-toggle='tooltip' data-placement='top' title='Approval'><i class='icon icon-check'></i> </button> &nbsp";
							}
						}
						else if ( Auth::user()->user_id=='manager2' and in_array($data->unit_cd, array('LITBANG','IT')) ) {
							if (!in_array(Auth::user()->user_id, array($approval1,$approval2,$approval3))) {
							$actions .= "<button type='button' class='approve btn btn-info btn-flat btn-sm' data-toggle='tooltip' data-placement='top' title='Approval'><i class='icon icon-check'></i> </button> &nbsp";
							}
						}
						else if ( Auth::user()->user_id=='manager3' ) {
							if (in_array($data->unit_cd, array('LOGISTIK','AKUNTING','PERSONALIA','PERPUSTAKAAN','SERVICE')) and !in_array(Auth::user()->user_id, array($approval1,$approval2,$approval3))) {
							$actions .= "<button type='button' class='approve btn btn-info btn-flat btn-sm' data-toggle='tooltip' data-placement='top' title='Approval'><i class='icon icon-check'></i> </button> &nbsp";
							}
							if ($approval1 != '' and !in_array(Auth::user()->user_id, array($approval2,$approval3))) {
							$actions .= "<button type='button' class='approve btn btn-info btn-flat btn-sm' data-toggle='tooltip' data-placement='top' title='Approval'><i class='icon icon-check'></i> </button> &nbsp";
							}
						}
					}
					//elseif (in_array(Auth::user()->user_id, array('wketua1','wketua2','wketua3'))) {
					elseif (roleUser() == 'wketua') {	
						if (!in_array(Auth::user()->user_id, array($approval1,$approval2,$approval3))) {	
						$actions .= "<button type='button' class='approve btn btn-info btn-flat btn-sm' data-toggle='tooltip' data-placement='top' title='Approval'><i class='icon icon-check'></i> </button> &nbsp";
						}
					}
					else {
						$actions .= "<button type='button' class='approve btn btn-info btn-flat btn-sm' data-toggle='tooltip' data-placement='top' title='Approval'><i class='icon icon-check'></i> </button> &nbsp";
					}
					
					$actions .= "<button type='button' class='view btn btn-success btn-flat btn-sm' data-toggle='tooltip' data-placement='top' title='View'><i class='icon icon-clipboard3'></i> </button> &nbsp";
					
					$actions .= "<button type='button' class='detail btn btn-warning btn-flat btn-sm' data-toggle='tooltip' data-placement='top' title='Detail'><i class='icon icon-pencil7'></i> </button>";
                    
                    return $actions;
                })
                ->addColumn('po_tp_nm', function($data){
                    switch ($data->po_tp) {
                        case '0':
                            return "<span class='badge badge-success'>Inventori</span>"; 
							break;
                        case '1':
                            return "<span class='badge badge-primary'>Asset</span>"; 
							break;
                        default:
							return "<span class='badge badge-light'>Lain-Lain</span>"; 
							break;
                    }
                })
                ->addColumn('po_st_nm', function($data){
                    switch ($data->po_st) {
                        case 'INV_TRX_ST_0': 
                            return "Close";
							break;
                        case 'INV_TRX_ST_1':
                            return "Purchase Order";
							break;
                        case 'INV_TRX_ST_2':
                            return "Approval-Open"; 
							break;
                        case 'INV_TRX_ST_3':
                            return "Approval-Close"; 
							break;
                        case 'INV_TRX_ST_4':
                            return "Proses"; 
							break;
                        case 'INV_TRX_ST_5':
                            return "Permintaan Pembelian";
							break;
                        case 'INV_TRX_ST_9':
                            return "Reject"; 
							break;
                        default:
                            return ""; 
                            break;
                    }
                })
                ->rawColumns(['po_tp_nm','po_st_nm','actions'])
                ->make(true);
    }
	
	function getHistory(Request $request){
        $data = InvPoPurchaseOrder::select(
				"po_cd",
                "po_no",
                "po_purchase_order.supplier_cd",
                "supplier.supplier_nm",
                "po_purchase_order.trx_date", 
                "note",
                "po_st",
				"po_purchase_order.dana_tp",
                "com.code_nm as dana_tp_nm",
				"po_purchase_order.created_by",
				"unit.cc_cd",
				"po_purchase_order.total_amount"
				)
                ->where(function($where) use($request){
					$unit = empty(Auth::user()->unit_cd) ? '' : Auth::user()->unit_cd;
					if ($unit !== '') {
                        $where->where('unit_cd',[$unit]);
                    }
					
                    if ($request->has('trx_date_param')) {
						$splitTanggal = explode("-",$request->trx_date_param);
						$tanggalStart = formatDate($splitTanggal[0]);
						$tanggalEnd   = formatDate($splitTanggal[1]);
			
						$where->whereRaw("trx_date::date between '$tanggalStart' and '$tanggalEnd'");
					}
					
                    $where->whereIn('po_st',['INV_TRX_ST_2','INV_TRX_ST_3']);
					//$where->where('po_source',null);
					//$where->whereRaw("coalesce(po_source,'')=''");
                })
				->leftJoin('inv.po_supplier as supplier','supplier.supplier_cd','po_purchase_order.supplier_cd')
				->leftJoin('public.com_code as com','com.com_cd','po_purchase_order.dana_tp')
				->leftJoin('erp.gl_cost_center as unit','unit.cc_cd','po_purchase_order.unit_cd')
				->orderBy('trx_date','desc');

        return DataTables::of($data)
                ->addColumn('actions', function($data){
                    $actions = '';
                    $actions .= "<button type='button' class='viewh btn btn-success btn-flat btn-sm' data-toggle='tooltip' data-placement='top' title='View'><i class='icon icon-clipboard3'></i> </button>";
					
					$actions .= "&nbsp<button type='button' class='detailh btn btn-warning btn-flat btn-sm' data-toggle='tooltip' data-placement='top' title='Detail'><i class='icon icon-pencil7'></i> </button>";
                    
                    return $actions;
                })
                ->addColumn('po_tp_nm', function($data){
                    switch ($data->po_tp) {
                        case '0':
                            return "<span class='badge badge-success'>Inventori</span>"; 
							break;
                        case '1':
                            return "<span class='badge badge-primary'>Asset</span>"; 
							break;
                        default:
							return "<span class='badge badge-light'>Lain-Lain</span>"; 
							break;
                    }
                })
                ->addColumn('po_st_nm', function($data){
                    switch ($data->po_st) {
                        case 'INV_TRX_ST_0': 
                            return "Close";
							break;
                        case 'INV_TRX_ST_1':
                            return "Purchase Order";
							break;
                        case 'INV_TRX_ST_2':
                            return "Approval-Open"; 
							break;
                        case 'INV_TRX_ST_3':
                            return "Approval-Close"; 
							break;
                        case 'INV_TRX_ST_4':
                            return "Proses"; 
							break;
                        case 'INV_TRX_ST_5':
                            return "Permintaan Pembelian";
							break;
                        case 'INV_TRX_ST_9':
                            return "Reject"; 
							break;
                        default:
                            return ""; 
                            break;
                    }
                })
                ->rawColumns(['po_tp_nm','po_st_nm','actions'])
                ->make(true);
    }
	
	function viewData($id){
		$data = InvVwInvPoDetail::where('po_cd', $id)
				->get();

		return response()->json(['status' => 'ok', 'data' => $data],200);
    }
	
	function viewFile($id){
		$file 	= PublicTrxFile::where('trx_file.trx_cd',$id)
					->select(
						"trx_file.trx_file_id as trx_file_id",
						"trx_file.trx_cd as trx_cd",
						"trx_file.file_nm as file_nm",
						"trx_file.file_tp as file_tp",
						"trx_file.file_path as file_path",
						"filetp.code_nm as file_tp_nm",
						"filetp.code_value as file_tp_icon",
						"trx_file.note as note"
					)
					->join('public.com_code as filetp','filetp.com_cd','trx_file.file_tp')
					->get();		

		return response()->json(['status' => 'ok', 'data' => $file],200);
    }
	
	function editData($id){
		$suppliers  = InvPoSupplier::all();
        $gudangs	= InvInvPosInventori::all()->sortBy('pos_nm');
        $types      = InvInvItemType::all();
        $units         = InvInvUnit::all();
		$pageFileName  = 'data';
		$defaultPoNo   = InvPoPurchaseOrder::getDataCd(date('y'), date('m'));

		$title  = 'Data Purchase Order';
		$po     = InvPoPurchaseOrder::find($id);
		$popr	= $po->po_st == 'INV_TRX_ST_5' ? 'popr' : '';
		
		$file 	= PublicTrxFile::where('trx_file.trx_cd',$id)
					->select(
						"trx_file.trx_file_id as trx_file_id",
						"trx_file.trx_cd as trx_cd",
						"trx_file.file_nm as file_nm",
						"trx_file.file_tp as file_tp",
						"trx_file.file_path as file_path",
						"filetp.code_nm as file_tp_nm",
						"filetp.code_value as file_tp_icon",
						"trx_file.note as note"
					)
					->join('public.com_code as filetp','filetp.com_cd','trx_file.file_tp')
					->get();
		
		if ($po) {
			if ($po->po_st == 'INV_TRX_ST_5') {
				$title  = 'Data Permintaan Pembelian';
			}
		
			return view('inventori::' . $this->folder_path . '.' . $pageFileName, compact('title','gudangs', 'suppliers', 'types', 'units', 'po', 'defaultPoNo', 'popr', 'file'));
		}
		else {
			return redirect('inventori/pembelian/approval')->with('error', 'Purchase Order Tidak Ditemukan!');
		}
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function update(Request $request, $id){

        DB::beginTransaction();
        try {
            
            $data = InvPoPurchaseOrder::find($id);

            if ($data) {
                $oldData = $data;

                $compCd = $this->compCd;
                $role   = roleUser();
                $userId = Auth::user()->user_id;
                $userNm = Auth::user()->user_nm;

                $persetujuan    = DB::select("select inv.sp_po_process_approval('$compCd'::varchar, '$role'::varchar, '$id'::varchar, '$userId'::varchar, '$userNm'::varchar) as approval");

                if ($persetujuan[0]->approval == 'berhasil') {
                    $result = "ok";
                }else{
                    $result = "failed";
                }

                $newData = InvPoPurchaseOrder::find($id);

                \LogActivityHelpers::saveLog(
                    $logTp   = 'update', 
                    $logNm   = "Approve Data Transaksi PO $data->po_cd", 
                    $table   = $data->getTable(), 
                    $oldData = $oldData, 
                    $newData = $newData
                );
            }else{
                \LogActivityHelpers::saveLog(
                    $logTp   = 'update', 
                    $logNm   = "Mencoba Approve Data Transaksi PO Acak $id", 
                    // $table   = $data->getTable(), 
                    // $oldData = $oldData, 
                    // $newData = $data
                );

                $result = "failed";
            }

            DB::commit();
			
			//--Proses approval berdasarkan jumlah uang
			$this->prosesApproval($data->po_cd);
			
            return response()->json(['status' => $result],200); 
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => 'error','error' => $e->getMessage()],200); 
        }
    }
	
	function reject(Request $request, $id){

        DB::beginTransaction();
        try {
            $data               = InvPoPurchaseOrder::find($id);
			$oldData = $data;
			
            $data->po_st  		= 'INV_TRX_ST_9';
			$data->reject_note 	= $request->reject_note;
			$data->reject_by    = Auth::user()->user_nm;
			$data->updated_by   = Auth::user()->user_id;
            $data->save();

            \LogActivityHelpers::saveLog(
                $logTp   = 'update', 
                $logNm   = "Mengubah Data Transaksi PO $data->po_cd", 
                $table   = $data->getTable(), 
                $oldData = $oldData, 
                $newData = $data
            );

            DB::commit();
						
			return response()->json(['status' => 'ok'],200); 
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => 'error','error' => $e],200); 
        }
    }
	
	function generatePo($pocd){
		$popr = InvPoPurchaseOrder::find($pocd);
		
		if ($popr) {
			DB::beginTransaction();
			try {
				//$savePo = DB::transaction(function () use($popr) {
				$defaultPoNo	= InvPoPurchaseOrder::getDataCd(date("Y"), date("n"));
				//$dataNo			= InvPoPurchaseOrder::getDataNo($popr->unit_cd, date("Y"));
				$dataNo			= InvPoPurchaseOrder::getDataNo($popr->unit_cd, $popr->dana_tp, date("Y"));
				
				$po                     = new InvPoPurchaseOrder;
				$po->po_no              = $defaultPoNo;
				if(!empty($po->supplier_cd)){
					$po->supplier_cd        = $popr->supplier_cd;
				}
				
				//$po->invoice_no       = $popr->invoice_no;
				$po->invoice_no         = '';
				$po->trx_year           = date("Y");
				$po->trx_month          = date("n");
				$po->trx_date           = date("Y-m-d");
				$po->top_cd             = $popr->top_cd;
				$po->currency_cd        = $popr->currency_cd;
				$po->total_price        = $popr->total_price;
				$po->total_amount       = $popr->total_amount;
				$po->vat_tp             = $popr->vat_tp;
				$po->percent_ppn        = $popr->percent_ppn;
				$po->ppn                = $popr->ppn;
				$po->delivery_address   = $popr->delivery_address;
				$po->delivery_datetime  = empty($popr->delivery_datetime) ? NULL : $po->delivery_datetime;
				$po->note               = $popr->note;
				$po->dana_tp            = $popr->dana_tp;
				
				$po->po_st              = 'INV_TRX_ST_1';
				$po->po_tp             	= $popr->po_tp;
				$po->unit_cd          	= $popr->unit_cd;
				$po->data_no          	= $dataNo;
				$po->po_source          = $popr->po_no;
				
				$po->entry_by          	= Auth::user()->user_nm;
				$po->created_by         = Auth::user()->user_id;
				$po->save();
				
				/* $popr->po_st		= 'INV_TRX_ST_3';
				$popr->updated_by 	= Auth::user()->user_id;
				$popr->save(); */
				//});
			
				$poprDetail = InvPoPoDetail::where('po_cd',$pocd)->get();
				foreach ($poprDetail as $item) {
					$pod                = new InvPoPoDetail;
					$pod->po_cd         = $po->po_cd;
					$pod->item_cd       = $item->item_cd;
					$pod->item_desc     = $item->item_desc;
					
					$pod->assettp_cd    = $item->assettp_cd;
					$pod->assettp_desc  = $item->assettp_desc;
					
					$pod->unit_cd       = $item->unit_cd;
					$pod->quantity      = $item->quantity;
					$pod->unit_price    = $item->unit_price;
					$pod->trx_amount    = $item->trx_amount;
					$pod->quantity_hs   = $item->quantity;
					$pod->unit_price_hs = $item->unit_price;
					$pod->trx_amount_hs = $item->trx_amount;
					$pod->created_by    = Auth::user()->user_id;
					$pod->save();
				}
				
				DB::commit();
			
			}
			catch (\Exception $e) {
				DB::rollback();
				return response()->json(['status' => 'error','error' => $e->getMessage()],200); 
			}
		}	
    }
	
	function getApproval($trxcd){
		try {
			/* $data = PublicTrxApproval::select(
						"trx_cd",
						"approve_no",
						"approve_by",
						"approve_date"
					)
					->where('trx_cd','PO' .$trxcd)
					->orderBy('approve_no', 'asc')->get(); */
			$data = PublicTrxApproval::select(
						"trx_cd",
						"approve_no",
						DB::Raw("concat(
						case coalesce(approval_1,null,'') when '' then approve_by else usr1.user_nm end,
						case coalesce(approval_2,null,'') when '' then '' else concat('<br>',usr2.user_nm) end,
						case coalesce(approval_3,null,'') when '' then '' else concat('<br>',usr3.user_nm) end
						) as approve_by"),
						"approve_date"
					)
					->where('trx_cd','PO' .$trxcd)
					->leftJoin('auth.users as usr1','usr1.user_id','trx_approval.approval_1')
					->leftJoin('auth.users as usr2','usr2.user_id','trx_approval.approval_2')
					->leftJoin('auth.users as usr3','usr3.user_id','trx_approval.approval_3')
					->orderBy('approve_no', 'asc')->get();
					
			//return DataTables::of($data)->make(true);
			return response()->json(['status' => 'ok', 'data' => $data],200);
		} catch (\Exception $e) {
            return response()->json(['status' => 'error','error' => $e],200); 
        }
    }
	
	function getApprovalmode($pocd){
		$approvalmode = '1';
		
		/*
		DANA_TP_01	OPEX
		DANA_TP_02	BOS
		DANA_TP_03	BOSDA
		DANA_TP_04	BOP
		DANA_TP_05	Recovery
		DANA_TP_06	Dana Kegiatan Siswa
		DANA_TP_07	CSR
		DANA_TP_08	Dana Sumbangan
		DANA_TP_09	House Rent
		*/
		$amountmode1	= 0;
		$amountmode2	= 0;
		$amountmode3	= 0;
		
		$potp = '';
		$danatp = '';
		$amount = 0;
		$po = InvPoPurchaseOrder::find($pocd);
		if ($po) {
			$potp 	= $po->po_tp;
			$danatp = $po->dana_tp;
			$amount = $po->total_amount;
		}
			
		if (in_array($danatp, array('DANA_TP_01','DANA_TP_07','DANA_TP_08'))) {	
			$amountmode1 = $amount;
		}
		elseif (in_array($danatp, array('DANA_TP_05','DANA_TP_09'))) {	
			$amountmode2 = $amount;
		}
		else {	
			$amountmode3 = $amount;
		}
		
		if ($amountmode1 > $amountmode2) {
			if ($amountmode1 > $amountmode3) {	
				$approvalmode = '1';
			}
			else {
				$approvalmode = '3';
			}
		}
		elseif ($amountmode2 > $amountmode3) {	
			$approvalmode = '2';
		}
		else {
			$approvalmode = '3';
		}
		
		if ($amountmode1 > 15000000) {
			$approvalmode = '1';
		}
		if ( $amountmode2 > 15000000 and ($amountmode1 <= 15000000) ) {
			$approvalmode = '2';
		}
		
		if ($potp == '1') {
			if ($amountmode1 > $amountmode2) {	
				$approvalmode = '1';
			}
			else {
				$approvalmode = '2';
			}
		}
		
		return $approvalmode;
    }
	
	function prosesApproval($pocd){
		$approvalmode = $this->getApprovalmode($pocd);
		/*
		$approvalmode = 1
		OPEX / CSR / DANA SUMBANGAN
		1. Kepala Sekolah		<1jt
		2. Manager Pendidikan 	1jt - 3jt
		3. Manager Bisnis		3jt - 7jt
		4. Direktur				7jt - 15jt
		5. Ketua Yayasan		15jt - 40jt
		6. > 40jt (4 Pengurus)
		
		$approvalmode = 2
		RECOVERY / HOUSE RENT
		1. Kepala Sekolah		<1jt
		2. Manager Pendidikan 	1jt - 3jt
		3. Manager Bisnis		3jt - 7jt
		4. Direktur				7jt - 15jt
		5. 2 Pengurus			15jt - 40jt
		6. > 40jt (4 Pengurus)
		
		$approvalmode = 3
		OTHER
		1. Kepala Sekolah		<1jt
		2. Manager Pendidikan 	1jt - 3jt
		3. Manager Bisnis		3jt - 7jt
		4. Direktur				>7jt
		*/
		
		$amount = 0;
		$post 	= '';
		
		$po 	= InvPoPurchaseOrder::find($pocd);
		if ($po) {
			$amount = $po->total_amount;
		}
		
		$approval = PublicTrxApproval::select('*')
					->where('trx_cd','PO'.$pocd)
					->where('updated_by',Auth::user()->user_id)
					->first();
		/* $approvalmax = 0;
		$approvalst = '';
		$approval1 = '';
		$approval2 = '';
		$approval3 = '';
		$approval = PublicTrxApproval::select(
						"trx_cd","approve_no","approval_st",
						DB::Raw("coalesce(approval_1,null,'') as approval_1"),
						DB::Raw("coalesce(approval_2,null,'') as approval_2"),
						DB::Raw("coalesce(approval_3,null,'') as approval_3"),
					)
					->where('trx_cd','PO'.$pocd)
					->where('updated_by',Auth::user()->user_id)
					->orderBy('approve_no', 'desc')
					->first();
		if ($approval) {
			$approvalmax = $approval->approve_no;
			$approvalst = $approval->approval_st;
			
			$approval1 = $approval->approval_1;
			$approval2 = $approval->approval_2;
			$approval3 = $approval->approval_3;
		} */			
		
		switch ($approvalmode) {
			case ($approvalmode == 1):
				switch (roleUser()) {
					case ('supervisor'):
						if ($amount >= 0 && $amount <= 1000000) {
							$post = 'INV_TRX_ST_3';
							
							if (in_array($po->unit_cd, array('LOGISTIK','AKUNTING','PERSONALIA','PERPUSTAKAAN','SERVICE','LITBANG','IT'))) {
								$post = 'INV_TRX_ST_2';
							}
						}
						
						break;
					case ('manager'):
						if ($amount >= 0 && $amount <= 1000000) {
							$post = 'INV_TRX_ST_3';
							
							/* //--Manager RSP
							if (Auth::user()->user_id == 'manager2' and in_array($po->unit_cd, array('LITBANG','IT'))) {
								$post = 'INV_TRX_ST_2';
							}
							//--Manager Bisnis
							if (Auth::user()->user_id == 'manager3' and in_array($po->unit_cd, array('LOGISTIK','AKUNTING','PERSONALIA','PERPUSTAKAAN','SERVICE'))) {
								$post = 'INV_TRX_ST_2';
							} */
						}
						
						if ($amount > 1000000 && $amount <= 3000000) {
							//--Manager Pendidikan
							/* if (Auth::user()->user_id == 'manager1') {
								$post = 'INV_TRX_ST_3';
							} */
							if (in_array(Auth::user()->user_id, array('manager1','manager2','manager3'))) {
								$post = 'INV_TRX_ST_3';
							}
						}
						
						if ($amount > 3000000 && $amount <= 7000000) {
							$post = 'INV_TRX_ST_3';
							
							if ($approval->approval_1 == '') {
								/* //--Manager Pendidikan
								if (Auth::user()->user_id == 'manager1') {
									$post = 'INV_TRX_ST_2';
									
									$approval->approval_1 = Auth::user()->user_id;
									$approval->approval_st = '1';
									$approval->save();
								}
								//--Manager RSP
								if (Auth::user()->user_id == 'manager2') {
									$post = 'INV_TRX_ST_2';
									
									$approval->approval_1 = Auth::user()->user_id;
									$approval->approval_st = '1';
									$approval->save();
								}
								//--Manager Bisnis
								if (Auth::user()->user_id == 'manager3') {
									$post = 'INV_TRX_ST_2';
									
									$approval->approval_1 = Auth::user()->user_id;
									$approval->approval_st = '1';
									$approval->save();
								} */
								//--Manager Pendidikan | Manager RSP
								if (in_array(Auth::user()->user_id, array('manager1','manager2'))) {
									$post = 'INV_TRX_ST_2';
									
									$approval->approval_1 = Auth::user()->user_id;
									$approval->approval_st = '1';
									$approval->save();
								}
								//--Manager Bisnis
								if (Auth::user()->user_id == 'manager3') {
									$post = 'INV_TRX_ST_3';
								}
							}
							else {
								$post = 'INV_TRX_ST_2';
								
								if ($approval->approval_2 == '') {
									//--Manager Bisnis
									if (Auth::user()->user_id == 'manager3') {
										if ($approval->approval_1 != 'manager3') {
											$post = 'INV_TRX_ST_3';
											
											$approval->approval_2  = Auth::user()->user_id;
											$approval->approval_st = '';
											$approval->save();
										}
									}
								}
							}
						}	
						else if ($amount > 7000000) {
							$post = 'INV_TRX_ST_2';
							
							if ($approval->approval_1 == '') {
								/* //--Manager Pendidikan
								if (Auth::user()->user_id == 'manager1') {
									$post = 'INV_TRX_ST_2';
									
									$approval->approval_1 = Auth::user()->user_id;
									$approval->approval_st = '1';
									$approval->save();
								}
								//--Manager RSP
								if (Auth::user()->user_id == 'manager2') {
									$post = 'INV_TRX_ST_2';
									
									$approval->approval_1 = Auth::user()->user_id;
									$approval->approval_st = '1';
									$approval->save();
								}
								//--Manager Bisnis
								if (Auth::user()->user_id == 'manager3') {
									$post = 'INV_TRX_ST_2';
									
									$approval->approval_1 = Auth::user()->user_id;
									$approval->approval_st = '1';
									$approval->save();
								} */
								//--Manager Pendidikan | Manager RSP
								if (in_array(Auth::user()->user_id, array('manager1','manager2'))) {
									$post = 'INV_TRX_ST_2';
									
									$approval->approval_1 = Auth::user()->user_id;
									$approval->approval_st = '1';
									$approval->save();
								}
								//--Manager Bisnis
								if (Auth::user()->user_id == 'manager3') {
									$post = 'INV_TRX_ST_2';
								}
							}
							else {
								if ($approval->approval_2 == '') {
									//--Manager Bisnis
									if (Auth::user()->user_id == 'manager3') {
										if ($approval->approval_1 != 'manager3') {
											$post = 'INV_TRX_ST_2';
											
											$approval->approval_2  = Auth::user()->user_id;
											$approval->approval_st = '';
											$approval->save();
										}
									}
								}
							}
						}
						
						break;
					case ('direktur'):	
						if ($amount > 7000000 && $amount <= 15000000) {
							$post = 'INV_TRX_ST_3';
						}
						else if ($amount > 15000000) {
							$post = 'INV_TRX_ST_2';
						}
						
						break;
					case ('wketua'):
						if ($amount > 40000000) {
							$post = 'INV_TRX_ST_3';
							if ($approval->approval_1 == '') {
								if (in_array(Auth::user()->user_id, array('wketua1','wketua2','wketua3'))) {
									$post = 'INV_TRX_ST_2';
									
									$approval->approval_1 = Auth::user()->user_id;
									$approval->approval_st = '1';
									$approval->save();
								}
							}
							elseif ($approval->approval_2 == '') {
								$post = 'INV_TRX_ST_2';
								if (Auth::user()->user_id == 'wketua1') {
									if ($approval->approval_1 != 'wketua1') {
										$post = 'INV_TRX_ST_2';
										
										$approval->approval_2 = Auth::user()->user_id;
										$approval->approval_st = '1';
										$approval->save();
									}
								}
								if (Auth::user()->user_id == 'wketua2') {
									if ($approval->approval_1 != 'wketua2') {
										$post = 'INV_TRX_ST_2';
										
										$approval->approval_2 = Auth::user()->user_id;
										$approval->approval_st = '1';
										$approval->save();
									}
								}
								if (Auth::user()->user_id == 'wketua3') {
									if ($approval->approval_1 != 'wketua3') {
										$post = 'INV_TRX_ST_2';
										
										$approval->approval_2 = Auth::user()->user_id;
										$approval->approval_st = '1';
										$approval->save();
									}
								}
							}
							else {
								$post = 'INV_TRX_ST_2';
								if ($approval->approval_3 == '') {
									if (Auth::user()->user_id == 'wketua1') {
										if ($approval->approval_1 != 'wketua1' and $approval->approval_2 != 'wketua1') {
											$post = 'INV_TRX_ST_2';
											
											$approval->approval_3  = Auth::user()->user_id;
											$approval->approval_st = '';
											$approval->save();
										}
									}
									if (Auth::user()->user_id == 'wketua2') {
										if ($approval->approval_1 != 'wketua2' and $approval->approval_2 != 'wketua2') {
											$post = 'INV_TRX_ST_2';
											
											$approval->approval_3  = Auth::user()->user_id;
											$approval->approval_st = '';
											$approval->save();
										}
									}
									if (Auth::user()->user_id == 'wketua3') {
										$post = 'INV_TRX_ST_2';
										
										$approval->approval_3  = Auth::user()->user_id;
										$approval->approval_st = '';
										$approval->save();
									}
								}
							}
						}	
						
						break;
					case ('ketua'):
						if ($amount > 15000000 && $amount <= 40000000) {
							$post = 'INV_TRX_ST_3';
						}
						if ($amount > 40000000) {
							$post = 'INV_TRX_ST_3';
						}
						
						break;
					default:
						
						break;
				}
				
				break;
			case ($approvalmode == 2):
				switch (roleUser()) {
					case ('supervisor'):
						if ($amount >= 0 && $amount <= 1000000) {
							$post = 'INV_TRX_ST_3';
						}
						
						break;
					case ('manager'):	
						if ($amount > 1000000 && $amount <= 3000000) {
							//--Manager Pendidikan
							if (Auth::user()->user_id == 'manager1') {
								$post = 'INV_TRX_ST_3';
							}
						}
						
						if ($amount > 3000000 && $amount <= 7000000) {
							$post = 'INV_TRX_ST_3';
							
							if ($approval->approval_1 == '') {
								//--Manager Pendidikan
								if (Auth::user()->user_id == 'manager1') {
									$post = 'INV_TRX_ST_2';
									
									$approval->approval_1 = Auth::user()->user_id;
									$approval->approval_st = '1';
									$approval->save();
								}
								//--Manager Bisnis
								if (Auth::user()->user_id == 'manager3') {
									$post = 'INV_TRX_ST_2';
									
									$approval->approval_1 = Auth::user()->user_id;
									$approval->approval_st = '1';
									$approval->save();
								}
							}
							else {
								$post = 'INV_TRX_ST_2';
								
								if ($approval->approval_2 == '') {
									//--Manager Bisnis
									if (Auth::user()->user_id == 'manager3') {
										if ($approval->approval_1 != 'manager3') {
											$post = 'INV_TRX_ST_3';
											
											$approval->approval_2  = Auth::user()->user_id;
											$approval->approval_st = '';
											$approval->save();
										}
									}
								}
							}
						}	
						else if ($amount > 7000000) {
							$post = 'INV_TRX_ST_2';
							
							if ($approval->approval_1 == '') {
								//--Manager Pendidikan
								if (Auth::user()->user_id == 'manager1') {
									$post = 'INV_TRX_ST_2';
									
									$approval->approval_1 = Auth::user()->user_id;
									$approval->approval_st = '1';
									$approval->save();
								}
								//--Manager Bisnis
								if (Auth::user()->user_id == 'manager3') {
									$post = 'INV_TRX_ST_2';
									
									$approval->approval_1 = Auth::user()->user_id;
									$approval->approval_st = '1';
									$approval->save();
								}
							}
							else {
								if ($approval->approval_2 == '') {
									//--Manager Bisnis
									if (Auth::user()->user_id == 'manager3') {
										if ($approval->approval_1 != 'manager3') {
											$post = 'INV_TRX_ST_2';
											
											$approval->approval_2  = Auth::user()->user_id;
											$approval->approval_st = '';
											$approval->save();
										}
									}
								}
							}
						}
						
						break;
					case ('direktur'):	
						if ($amount > 7000000 && $amount <= 15000000) {
							$post = 'INV_TRX_ST_3';
						}
						else if ($amount > 15000000) {
							$post = 'INV_TRX_ST_2';
						}
						
						break;
					case ('wketua'):	
						if ($amount > 15000000 && $amount <= 40000000) {
							$post = 'INV_TRX_ST_3';
							
							if ($approval->approval_1 == '') {
								if (in_array(Auth::user()->user_id, array('wketua1','wketua2','wketua3'))) {
									$post = 'INV_TRX_ST_2';
									
									$approval->approval_1 = Auth::user()->user_id;
									$approval->approval_st = '1';
									$approval->save();
								}
							}
							else {
								if ($approval->approval_2 == '') {
									if (in_array(Auth::user()->user_id, array('wketua1','wketua2','wketua3'))) {
										$post = 'INV_TRX_ST_3';
												
										$approval->approval_2  = Auth::user()->user_id;
										$approval->approval_st = '';
										$approval->save();
									}	
								}
							}
						}
						
						if ($amount > 40000000) {
							$post = 'INV_TRX_ST_3';
							
							if ($approval->approval_1 == '') {
								if (in_array(Auth::user()->user_id, array('wketua1','wketua2','wketua3'))) {
									$post = 'INV_TRX_ST_2';
									
									$approval->approval_1 = Auth::user()->user_id;
									$approval->approval_st = '1';
									$approval->save();
								}
							}
							elseif ($approval->approval_2 == '') {
								$post = 'INV_TRX_ST_2';
								if (Auth::user()->user_id == 'wketua1') {
									if ($approval->approval_1 != 'wketua1') {
										$post = 'INV_TRX_ST_2';
										
										$approval->approval_2 = Auth::user()->user_id;
										$approval->approval_st = '1';
										$approval->save();
									}
								}
								if (Auth::user()->user_id == 'wketua2') {
									if ($approval->approval_1 != 'wketua2') {
										$post = 'INV_TRX_ST_2';
										
										$approval->approval_2 = Auth::user()->user_id;
										$approval->approval_st = '1';
										$approval->save();
									}
								}
								if (Auth::user()->user_id == 'wketua3') {
									if ($approval->approval_1 != 'wketua3') {
										$post = 'INV_TRX_ST_2';
										
										$approval->approval_2 = Auth::user()->user_id;
										$approval->approval_st = '1';
										$approval->save();
									}
								}
							}
							else {
								$post = 'INV_TRX_ST_2';
								if ($approval->approval_3 == '') {
									if (Auth::user()->user_id == 'wketua1') {
										if ($approval->approval_1 != 'wketua1' and $approval->approval_2 != 'wketua1') {
											$post = 'INV_TRX_ST_2';
											
											$approval->approval_3  = Auth::user()->user_id;
											$approval->approval_st = '';
											$approval->save();
										}
									}
									if (Auth::user()->user_id == 'wketua2') {
										if ($approval->approval_1 != 'wketua2' and $approval->approval_2 != 'wketua2') {
											$post = 'INV_TRX_ST_2';
											
											$approval->approval_3  = Auth::user()->user_id;
											$approval->approval_st = '';
											$approval->save();
										}
									}
									if (Auth::user()->user_id == 'wketua3') {
										$post = 'INV_TRX_ST_2';
										
										$approval->approval_3  = Auth::user()->user_id;
										$approval->approval_st = '';
										$approval->save();
									}
								}
							}
						}	
						
						break;
					case ('ketua'):	
						if ($amount > 15000000 && $amount <= 40000000) {
							$post = 'INV_TRX_ST_3';
							
							if ($approval->approval_1 != '' and $approval->approval_2 == '') {
								$post = 'INV_TRX_ST_3';
										
								$approval->approval_2  = Auth::user()->user_id;
								$approval->approval_st = '';
								$approval->save();
							}
						}
						
						if ($amount > 40000000) {
							$post = 'INV_TRX_ST_3';
						}
						
						break;
					default:
						
						break;
				}
				
				break;
			case ($approvalmode == 3):
				switch (roleUser()) {
					case ('supervisor'):
						if ($amount >= 0 && $amount <= 1000000) {
							$post = 'INV_TRX_ST_3';
						}	
					
						break;
					case ('manager'):
						if ($amount > 1000000 && $amount <= 3000000) {
							//--Manager Pendidikan
							if (Auth::user()->user_id == 'manager1') {
								$post = 'INV_TRX_ST_3';
							}
						}
						
						if ($amount > 3000000 && $amount <= 7000000) {
							$post = 'INV_TRX_ST_3';
							
							if ($approval->approval_1 == '') {
								//--Manager Pendidikan
								if (Auth::user()->user_id == 'manager1') {
									$post = 'INV_TRX_ST_2';
									
									$approval->approval_1 = Auth::user()->user_id;
									$approval->approval_st = '1';
									$approval->save();
								}
								//--Manager Bisnis
								if (Auth::user()->user_id == 'manager3') {
									$post = 'INV_TRX_ST_2';
									
									$approval->approval_1 = Auth::user()->user_id;
									$approval->approval_st = '1';
									$approval->save();
								}
							}
							else {
								$post = 'INV_TRX_ST_2';
								
								if ($approval->approval_2 == '') {
									//--Manager Bisnis
									if (Auth::user()->user_id == 'manager3') {
										if ($approval->approval_1 != 'manager3') {
											$post = 'INV_TRX_ST_3';
											
											$approval->approval_2  = Auth::user()->user_id;
											$approval->approval_st = '';
											$approval->save();
										}
									}
								}
							}
						}	
						else if ($amount > 7000000) {
							$post = 'INV_TRX_ST_2';
							
							if ($approval->approval_1 == '') {
								//--Manager Pendidikan
								if (Auth::user()->user_id == 'manager1') {
									$post = 'INV_TRX_ST_2';
									
									$approval->approval_1 = Auth::user()->user_id;
									$approval->approval_st = '1';
									$approval->save();
								}
								//--Manager Bisnis
								if (Auth::user()->user_id == 'manager3') {
									$post = 'INV_TRX_ST_2';
									
									$approval->approval_1 = Auth::user()->user_id;
									$approval->approval_st = '1';
									$approval->save();
								}
							}
							else {
								if ($approval->approval_2 == '') {
									//--Manager Bisnis
									if (Auth::user()->user_id == 'manager3') {
										if ($approval->approval_1 != 'manager3') {
											$post = 'INV_TRX_ST_2';
											
											$approval->approval_2  = Auth::user()->user_id;
											$approval->approval_st = '';
											$approval->save();
										}
									}
								}
							}
						}
						
						break;
					case ('direktur'):	
						if ($amount > 7000000) {
							$post = 'INV_TRX_ST_3';
						}
						
						break;
					default:
						
						break;
				}
			break;
		}	
		
		if ($post != '') {
			$po->po_st			= $post;
			$po->updated_by   	= Auth::user()->user_id;
			$po->save();
		}
    }
	
	//--Proses Approval V.1.0
	function prosesApproval_1($pocd){
		/*
		1. Kepala Sekolah		<1jt
		2. Manager Pendidikan 	1jt - 3jt	| Manager Pendidikan 	: manager1
		3. Manager Bisnis		3jt - 7jt	| Manager Bisnis 		: manager3
											  Manager Pendidikan & Manager Bisnis [Paralel]
		4. Direktur				7jt - 15jt
		5. Ketua Yayasan		15jt - 40jt
		6. > 40jt (4 Pengurus)
		*/
		
		$amount = 0;
		$post 	= '';
		$unit 	= '';
		
		$po 		= InvPoPurchaseOrder::find($pocd);
		if ($po) {
			$amount = $po->total_amount;
			$unit 	= $po->unit_cd;
		}
		
		switch ($amount) {
			//case 0:
			//	break;
			case ( ($amount >= 0 && $amount <= 1000000) && (roleUser() == 'supervisor') ):
				$post = 'INV_TRX_ST_3';
				//$post = 'INV_TRX_ST_1';
				
				break;
			case ( ($amount > 1000000 && $amount <= 3000000) && (roleUser() == 'manager') ):
				//Auth::user()->user_id == manager1
				$post = 'INV_TRX_ST_3';
				//$post = 'INV_TRX_ST_1';
				
				break;
			case ( ($amount > 3000000 && $amount <= 7000000) && (roleUser() == 'manager') ):
				//Auth::user()->user_id == manager3
				$post = 'INV_TRX_ST_3';
				//$post = 'INV_TRX_ST_1';
				
				$approval	= PublicTrxApproval::select('*')
							->where('trx_cd','PO'.$pocd)
							->where('updated_by',Auth::user()->user_id)
							->first();
				if ($approval->approval_1 == '') {
					if (in_array(Auth::user()->user_id, array('manager1'))) {
						$post = 'INV_TRX_ST_2';
						
						$approval->approval_1 = Auth::user()->user_id;
						$approval->approval_st = '1';
						$approval->save();
					}
					if (in_array(Auth::user()->user_id, array('manager3'))) {
						/* $post = 'INV_TRX_ST_2';
						
						$approval->approval_1 = Auth::user()->user_id;
						$approval->approval_st = '1';
						$approval->save(); */
						
						if (!in_array($unit, array('TK','SD1','SD2','SD3','SMP'))) {
							$post = 'INV_TRX_ST_3';
							
							$approval->approval_1 = Auth::user()->user_id;
							$approval->approval_st = '';
							$approval->save();
						}
						else {
							$post = 'INV_TRX_ST_2';
						
							$approval->approval_1 = Auth::user()->user_id;
							$approval->approval_st = '1';
							$approval->save();
						}
					}
				}
				else {
					$post = 'INV_TRX_ST_2';
					if ($approval->approval_2 == '') {
						if (in_array(Auth::user()->user_id, array('manager3'))) {
							if ($approval->approval_1 != 'manager3') {
								$post = 'INV_TRX_ST_3';
								
								$approval->approval_2  = Auth::user()->user_id;
								$approval->approval_st = '';
								$approval->save();
							}
						}
					}
				}
				
				break;
			case ( ($amount > 7000000 && $amount <= 15000000) && (roleUser() == 'direktur') ):
				$post = 'INV_TRX_ST_3';
				//$post = 'INV_TRX_ST_1';
				
				break;
			case ( ($amount > 15000000 && $amount <= 40000000) && (roleUser() == 'ketua') ):
				$post = 'INV_TRX_ST_3';
				//$post = 'INV_TRX_ST_1';
				
				break;
			case ( ($amount > 40000000) && (roleUser() == 'wketua') ):
				//Auth::user()->user_id == wketua1
				$post = 'INV_TRX_ST_3';
				//$post = 'INV_TRX_ST_1';
				
				$approval	= PublicTrxApproval::select('*')
							->where('trx_cd','PO'.$pocd)
							->where('updated_by',Auth::user()->user_id)
							->first();
				if ($approval->approval_1 == '') {
					if (in_array(Auth::user()->user_id, array('wketua1'))) {
						$post = 'INV_TRX_ST_2';
						
						$approval->approval_1 = Auth::user()->user_id;
						$approval->approval_st = '1';
						$approval->save();
					}
					if (in_array(Auth::user()->user_id, array('wketua2'))) {
						$post = 'INV_TRX_ST_2';
						
						$approval->approval_1 = Auth::user()->user_id;
						$approval->approval_st = '1';
						$approval->save();
					}
					if (in_array(Auth::user()->user_id, array('wketua3'))) {
						$post = 'INV_TRX_ST_2';
						
						$approval->approval_1 = Auth::user()->user_id;
						$approval->approval_st = '1';
						$approval->save();
					}
				}
				elseif ($approval->approval_2 == '') {
					$post = 'INV_TRX_ST_2';
					if (in_array(Auth::user()->user_id, array('wketua1'))) {
						if ($approval->approval_1 != 'wketua1') {
							$post = 'INV_TRX_ST_2';
							
							$approval->approval_2 = Auth::user()->user_id;
							$approval->approval_st = '1';
							$approval->save();
						}
					}
					if (in_array(Auth::user()->user_id, array('wketua2'))) {
						if ($approval->approval_1 != 'wketua2') {
							$post = 'INV_TRX_ST_2';
							
							$approval->approval_2 = Auth::user()->user_id;
							$approval->approval_st = '1';
							$approval->save();
						}
					}
					if (in_array(Auth::user()->user_id, array('wketua3'))) {
						if ($approval->approval_1 != 'wketua3') {
							$post = 'INV_TRX_ST_2';
							
							$approval->approval_2 = Auth::user()->user_id;
							$approval->approval_st = '1';
							$approval->save();
						}
					}
				}
				else {
					$post = 'INV_TRX_ST_2';
					if ($approval->approval_3 == '') {
						if (in_array(Auth::user()->user_id, array('wketua1'))) {
							if ($approval->approval_1 != 'wketua1' and $approval->approval_2 != 'wketua1') {
								$post = 'INV_TRX_ST_2';
								
								$approval->approval_3  = Auth::user()->user_id;
								$approval->approval_st = '';
								$approval->save();
							}
						}
						if (in_array(Auth::user()->user_id, array('wketua2'))) {
							if ($approval->approval_1 != 'wketua2' and $approval->approval_2 != 'wketua2') {
								$post = 'INV_TRX_ST_2';
								
								$approval->approval_3  = Auth::user()->user_id;
								$approval->approval_st = '';
								$approval->save();
							}
						}
						if (in_array(Auth::user()->user_id, array('wketua3'))) {
							$post = 'INV_TRX_ST_2';
							
							$approval->approval_3  = Auth::user()->user_id;
							$approval->approval_st = '';
							$approval->save();
						}
					}
				}
				
				break;
			case ( ($amount > 40000000) && (roleUser() == 'ketua') ):
				$post = 'INV_TRX_ST_3';
				//$post = 'INV_TRX_ST_1';
				
				break;
			default:
				
				break;
		}
		
		if ($post != '') {
			$po->po_st		= $post;
			$po->updated_by	= Auth::user()->user_id;
			$po->save();
		}
		
		if ($post == 'INV_TRX_ST_3') {
			//--Generate PO from PR
			//$this->generatePo($pocd);
			if ($po->popr_st == '1') {
				$this->generatePo($pocd);
			}
		}
    }
}
