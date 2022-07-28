<?php

namespace Modules\Inventori\Http\Controllers\Pembelian;

use DB;
use Auth;
use DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\InvInvPosItemUnit;
use App\Models\InvInvItemType;
use App\Models\InvInvUnit;
use App\Models\InvPoPurchaseOrder;
use App\Models\InvPoPoDetail;
use App\Models\InvInvPosInventori;
use App\Models\InvPoSupplier;
use App\Models\InvVwInvPoDetail;
use App\Models\PublicTrxFile;

class PurchaseOrderController extends Controller{
    private $folder_path = 'pembelian.purchase-order';
    
    function __construct(){
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function index($id = NULL){
		$suppliers  = InvPoSupplier::all();
        //$gudangs	= InvInvPosInventori::all();
		$gudangs	= InvInvPosInventori::all()->sortBy('pos_nm');//->where('pos_root','');
        $types      = InvInvItemType::all();
		
		if ($id) {
            $units         = InvInvUnit::all();
            $pageFileName  = 'data';
            $defaultPoNo   = InvPoPurchaseOrder::getDataCd(date('y'), date('m'));

            if ($id == 'tambah') {
                $title          = 'Tambah Purchase Order';
                $po             = NULL;
				$popr			= '';
				$file			= NULL;
                
                return view('inventori::' . $this->folder_path . '.' . $pageFileName, compact('title','gudangs', 'suppliers', 'types', 'units', 'po', 'defaultPoNo', 'popr', 'file'));
            }
			else if ($id == 'popr') {
                $title          = 'Tambah Permintaan Pembelian';
                $po             = NULL;
				$popr			= 'popr';
				$file			= NULL;
                
                return view('inventori::' . $this->folder_path . '.' . $pageFileName, compact('title','gudangs', 'suppliers', 'types', 'units', 'po', 'defaultPoNo', 'popr', 'file'));
            }
			else{
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
                }else{
                    return redirect('inventori/pembelian/purchase-order')->with('error', 'Purchase Order Tidak Ditemukan!');
                }
            }
        }else{
            $pageFileName  = 'index';
            $title         = 'Purchase Order';

            return view('inventori::' . $this->folder_path . '.' . $pageFileName, compact('title','gudangs', 'suppliers'));
        }
    }

    /**
     * Display a listing of the resource for DataTables.
     *
     * @return \Illuminate\Http\Response
     */
    function getData(Request $request){
		//return response()->json(['return' => $request->trx_date_param],200);
		if ($request->type == 'data') {
            /* $data = InvPoPurchaseOrder::select(
                "po_cd",
                "po_no",
                "po_purchase_order.supplier_cd",
                "supplier.supplier_nm",
                DB::Raw("fn_formatdate(po_purchase_order.trx_date) as trx_date"), 
                "note",
                "po_st" */
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
			})
            ->leftJoin('inv.po_supplier as supplier','supplier.supplier_cd','po_purchase_order.supplier_cd')
			->leftJoin('public.com_code as com','com.com_cd','po_purchase_order.dana_tp')
			->leftJoin('erp.gl_cost_center as unit','unit.cc_cd','po_purchase_order.unit_cd')
			->orderBy('trx_date','desc');

            return DataTables::of($data)
				->addColumn('actions', function($data){
                    $actions = '';
					
					if ( ($data->created_by == Auth::user()->user_id) or (in_array(roleUser(), array('superuser','adminv'))) ) {
					$actions .= "<button type='button' class='detail btn btn-warning btn-flat btn-sm' data-toggle='tooltip' data-placement='top' title='Detail'><i class='icon icon-pencil7'></i> </button>";
                    //if ($data->po_st == 'INV_TRX_ST_1') {
					$actions .= "&nbsp<button type='button' class='hapus btn btn-danger btn-flat btn-sm' data-toggle='tooltip' data-placement='top' title='Hapus'><i class='icon icon-trash'></i> </button>";
					//}
					}
					
					$actions .= "&nbsp<button type='button' class='view btn btn-success btn-flat btn-sm' data-toggle='tooltip' data-placement='top' title='View'><i class='icon icon-clipboard3'></i> </button>";
					
					if ( in_array(roleUser(), array('superuser','adminv')) ) {
					if ($data->po_st == 'INV_TRX_ST_3') {
					$actions .= "&nbsp<button type='button' class='closing btn btn-info btn-flat btn-sm' data-toggle='tooltip' data-placement='top' title='Close'><i class='icon icon-check'></i> </button>";
					}
					
					if ($data->po_st == 'INV_TRX_ST_3' & $data->popr_st == '1') {
					$actions .= "&nbsp<button type='button' class='generate btn bg-teal-600 btn-flat btn-sm' data-toggle='tooltip' data-placement='top' title='Generate PO'><i class='icon icon-basket'></i> </button>";
					}
					}
					
					if (Auth::user()->user_id == 'super') {
					$actions .= "&nbsp<button type='button' class='super btn bg-dark btn-flat btn-sm' data-toggle='tooltip' data-placement='top' title='Set'><i class='icon icon-warning'></i> </button>";
                    }
					
                    return $actions;
                })
                ->addColumn('po_st_nm',function($data){
                    switch ($data->po_st) {
                        case 'INV_TRX_ST_0':
                            return '<span class="badge badge-success badge-icon"><i class="icon icon-check"></i> Close</span>';
                            break;
                        case 'INV_TRX_ST_1':
                            return '<span class="badge badge-info badge-icon"><i class="icon icon-pencil"></i> Purchase Order</span>';//--Input
                            break;
                        case 'INV_TRX_ST_2':
                            return '<span class="badge badge-default badge-icon"><i class="icon icon-task"></i> Approval Open</span>';
                        break;
                        case 'INV_TRX_ST_3':
                            return '<span class="badge badge-default badge-icon"><i class="icon icon-enter"></i> Approval Close</span>';
                            break;
                        case 'INV_TRX_ST_4':
                            return '<span class="badge badge-primary badge-icon"><i class="icon icon-task"></i> Proses</span>';
                        break;
						case 'INV_TRX_ST_5':
                            return '<span class="badge badge-warning badge-icon"><i class="icon icon-list"></i> Permintaan Pembelian</span>';
                        break;
						case 'INV_TRX_ST_9':
                            return '<span class="badge badge-danger badge-icon"><i class="icon-cancel-circle2"></i> Reject</span>';
                        break;
                        
                        default:
                            return '<span class="badge badge-danger badge-icon"><i class="icon-cancel-circle2"></i> Cancel</span>';
                            break;
                    }
            
                })
                ->rawColumns(['po_st_nm','actions'])
                ->make(true);
        }else{
            $data = InvVwInvPoDetail::where('po_cd', $request->id)
					->orderBy('date_trx','desc');

            return DataTables::of($data)
                ->addColumn('action',function($data){
                    if( ($data->po_st == 'INV_TRX_ST_1') or ($data->po_st == 'INV_TRX_ST_5') ){
						$actions = '';
						
						$actions .= "<button type='button' class='ubah-item btn btn-warning btn-flat btn-sm' data-toggle='tooltip' data-placement='top' title='Ubah Data'><i class='icon icon-pencil7'></i> </button> &nbsp";
						
                        $actions .= "<button type='button' id='hapus-item' class='btn btn-danger btn-flat btn-sm' data-toggle='tooltip' data-placement='top' title='Hapus Data'><i class='icon icon-trash'></i> </button>";
                    }else{
                        $actions = '';
                    }
                    return $actions;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
	
	function getDataPo($id){
        $data= InvPoPurchaseOrder::find($id);

        return response()->json(['status' => 'ok', 'data' => $data],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    function store(Request $request){
        $this->validate($request,[
            //'po_no'       => 'required',
            //'supplier_cd'   => 'required',
        ]);
		
		$savePo = DB::transaction(function () use($request) {
            $trxDate = formatDate($request->trx_date);
			
            $defaultPoNo	= InvPoPurchaseOrder::getDataCd(date("Y", strtotime($trxDate)), date("n", strtotime($trxDate)));
			//$dataNo			= InvPoPurchaseOrder::getDataNo($request->cc_cd, date("Y", strtotime($trxDate)));
			$dataNo			= InvPoPurchaseOrder::getDataNo($request->cc_cd, $request->dana_tp, date("Y", strtotime($trxDate)));
			
			$po                     = new InvPoPurchaseOrder;
			//$po->po_no              = $request->po_no;
            if(!is_null($request->po_no)){
                $po->po_no              = $request->po_no;
            } else {
                $po->po_no              = $defaultPoNo;
            }
            //$po->supplier_cd        = $request->supplier_cd;
			if(!empty($request->supplier_cd)){
                $po->supplier_cd        = $request->supplier_cd;
            }
			
            //$po->invoice_no       = $request->invoice_no;
			$po->invoice_no         = '';
            $po->trx_year           = date("Y", strtotime($trxDate));
            $po->trx_month          = date("n", strtotime($trxDate));
            //$po->trx_date           = date("Y-m-d", strtotime($trxDate));
			$po->trx_date           = $trxDate;
            $po->top_cd             = $request->top_cd;
            $po->currency_cd        = $request->currency_cd;
            $po->total_price        = 0;
            $po->total_amount       = 0;
            $po->vat_tp             = $request->vat_tp;
            $po->percent_ppn        = $request->percent_ppn;
            //$po->ppn                = $request->ppn;
            $po->delivery_address   = $request->delivery_address;
            //$po->delivery_datetime  = formatDateTime($request->delivery_datetime);
			$po->delivery_datetime  = empty($request->delivery_datetime) ? NULL : formatDate($request->delivery_datetime);
            $po->note               = $request->note;
			$po->dana_tp            = $request->dana_tp;
            
			//$po->po_st			= 'INV_TRX_ST_1';
			if($request->popr != ''){
                $po->po_st			= 'INV_TRX_ST_5';
				$po->popr_st		= '1';
            } else {
                $po->po_st			= 'INV_TRX_ST_1';
				$po->popr_st		= '';
            }
			$po->po_tp             	= $request->po_tp;
			$po->unit_cd          	= $request->cc_cd;
			$po->data_no          	= $dataNo;
			$po->aktivitas_cd       = $request->aktivitas_cd;
			$po->aktivitas_tp       = $request->aktivitas_tp;
			
			//$po->entry_by         = Auth::user()->user_id;
			$po->entry_by          	= Auth::user()->user_nm;
            $po->created_by         = Auth::user()->user_id;
            $po->save();

            // $itemData   = InvInvPosItemUnit::query()->select(
            //                 DB::Raw("'$po->inv_opname_id' as inv_opname_id"),
            //                 "inv_pos_itemunit.item_cd",
            //                 "inv_pos_itemunit.unit_cd",
            //                 "inv_pos_itemunit.quantity AS quantity_real",
            //                 "inv_pos_itemunit.quantity AS quantity_system",
            //                 DB::Raw("'$po->created_by' as created_by"),
            //             )
            //             ->where(function ($query) use($request){
            //                 if($request->type_cd) $query->where('master.type_cd', $request->type_cd);
            //             })
            //             ->join('inv.inv_item_master as master','master.item_cd','inv_pos_itemunit.item_cd')
            //             ->orderBy('inv_pos_itemunit.item_cd')->get()->toArray();
            
            // $insert     = InvPoPoDetail::insert($itemData);
            return $po->po_cd;
        });

        return redirect('/inventori/pembelian/purchase-order/'.$savePo);
    }

    /*
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function update(Request $request, $id){    
        $po = InvPoPurchaseOrder::find($id);
		
        //$po->po_st = 'INV_TRX_ST_0';
		if ($po->po_st == 'INV_TRX_ST_5') {
			$po->po_st = 'INV_TRX_ST_1';
		} else {
			$po->po_st = 'INV_TRX_ST_0';
			$po->supplier_cd = $request->supplier_cd;
			$po->percent_ppn = $request->percent_ppn;
			$po->delivery_datetime  = empty($request->delivery_datetime) ? NULL : formatDate($request->delivery_datetime);
		}
					
        $po->updated_by = Auth::user()->user_id;
        $po->save();
		
		//if ($po->po_st == 'INV_TRX_ST_5') {
			$sumPoDetail    = InvPoPoDetail::where('po_cd', $po->po_cd)->sum('trx_amount');
            $amountPpn      = $sumPoDetail * ($po->percent_ppn/100);
            $sumPlusPpn     = $sumPoDetail + $amountPpn;
			//$sumPlusPpn     = $sumPoDetail;

            $po->total_price    = $sumPoDetail;
            $po->total_amount   = $sumPlusPpn;
            $po->ppn            = $amountPpn;
            $po->updated_by     = Auth::user()->user_id;
            $po->save();
		//}	
		
		return response()->json(['status' => 'ok'],200); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function destroy($id){
		/* try {
			DB::table('public.trx_approval')->where('trx_cd','=','PO' .$id)->delete();
		}
		catch (Exception $e) {
			return response()->json(['status' => 'error','error' => $e->getMessage()],200);
		} */
		
		DB::table('public.trx_approval')->where('trx_cd','=','PO' .$id)->delete();
		
        InvPoPurchaseOrder::destroy($id);

        return response()->json(['status' => 'ok'],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    function storeItem(Request $request, $id){
        $this->validate($request,[
            //'item_cd'       => 'required',
            //'unit_cd'       => 'required',
            'quantity'      => 'required',
            'unit_price'    => 'required',
            'trx_amount'    => 'required',
        ]);

        $savePod = DB::transaction(function () use($request, $id) {
            $po                 = InvPoPurchaseOrder::find($id);

            $pod                = new InvPoPoDetail;
            $pod->po_cd         = $id;
            $pod->item_cd       = $request->item_cd;
			$pod->item_desc     = $request->item_nm;
			
			if($po->po_tp == '1'){
				$pod->assettp_cd    = $request->assettp_cd;
                $pod->assettp_desc  = $request->item_nm;
            }
			
            $pod->unit_cd       = $request->unit_cd;
            $pod->quantity      = $request->quantity;
            $pod->unit_price    = $request->unit_price;
            $pod->trx_amount    = $request->trx_amount;
			$pod->info_note     = $request->info_note;
			$pod->quantity_hs   = $request->quantity;
            $pod->unit_price_hs = $request->unit_price;
            $pod->trx_amount_hs = $request->trx_amount;
            $pod->created_by    = Auth::user()->user_id;
            $pod->save();

            $sumPoDetail    = InvPoPoDetail::where('po_cd', $po->po_cd)->sum('trx_amount');
            $amountPpn      = $sumPoDetail * ($po->percent_ppn/100);
            $sumPlusPpn     = $sumPoDetail + $amountPpn;
			//$sumPlusPpn     = $sumPoDetail;
			
			//$po->trx_date           = $request->trx_date;
			$po->trx_date			= formatDate($request->trx_date);
			//$po->supplier_cd		= $request->supplier_cd;
            $po->delivery_address   = $request->delivery_address;
            $po->delivery_datetime  = empty($request->delivery_datetime) ? NULL : formatDate($request->delivery_datetime);
            
            $po->total_price    = $sumPoDetail;
            $po->total_amount   = $sumPlusPpn;
            $po->ppn            = $amountPpn;
            $po->updated_by     = Auth::user()->user_id;
            $po->save();

            return $po;
        });

        return response()->json(['status' => 'ok', 'po'=> $savePod],200); 
    }

     /*
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function updateItem(Request $request, $id){    
        $this->validate($request,[
            'quantity'      => 'required',
            'unit_price'    => 'required',
        ]);

        $savePod = DB::transaction(function () use($request, $id) {
            $pod                = InvPoPoDetail::find($id);
			$po             	= InvPoPurchaseOrder::find($pod->po_cd);
			
			$pod->item_cd       = $request->item_cd;
			$pod->item_desc     = $request->item_nm;
			
			if($po->po_tp == '1'){
				$pod->assettp_cd    = $request->assettp_cd;
                $pod->assettp_desc  = $request->item_nm;
            }
			
            $pod->unit_cd       = $request->unit_cd;
			$pod->quantity      = $request->quantity;
            $pod->unit_price    = $request->unit_price;
            $pod->trx_amount    = $request->quantity * $request->unit_price;
			$pod->info_note     = $request->info_note;
            $pod->updated_by    = Auth::user()->user_id;
            $pod->save();

            //$po             = InvPoPurchaseOrder::find($pod->po_cd);
            $sumPoDetail    = InvPoPoDetail::where('po_cd', $po->po_cd)->sum('trx_amount');
            $amountPpn      = $sumPoDetail * ($po->percent_ppn/100);
            $sumPlusPpn     = $sumPoDetail + $amountPpn;
			//$sumPlusPpn     = $sumPoDetail;

            $po->total_price    = $sumPoDetail;
            $po->total_amount   = $sumPlusPpn;
            $po->ppn            = $amountPpn;
            $po->updated_by     = Auth::user()->user_id;
            $po->save();

            return $po;
        });

        return response()->json(['status' => 'ok', 'po'=> $savePod],200); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function destroyItem($id){
        $deletePod = DB::transaction(function () use($id) {
            $pod    = InvPoPoDetail::find($id);
            $poCd   = $pod->po_cd;
            
            $pod    = InvPoPoDetail::destroy($id);

            $po             = InvPoPurchaseOrder::find($poCd);
            $sumPoDetail    = InvPoPoDetail::where('po_cd', $po->po_cd)->sum('trx_amount');
            $amountPpn      = $sumPoDetail * ($po->percent_ppn/100);
            $sumPlusPpn     = $sumPoDetail + $amountPpn;
			//$sumPlusPpn     = $sumPoDetail;

            $po->total_price    = $sumPoDetail;
            $po->total_amount   = $sumPlusPpn;
            $po->ppn            = $amountPpn;
            $po->updated_by     = Auth::user()->user_id;
            $po->save();

            return $po;
        });

        return response()->json(['status' => 'ok', 'po' => $deletePod],200);
    }
	
	function closing(Request $request, $id){

        DB::beginTransaction();
        try {
            $data               = InvPoPurchaseOrder::find($id);
			$oldData = $data;
			
            $data->po_st  		= 'INV_TRX_ST_0';
			$data->updated_by   = Auth::user()->user_id;
            $data->save();

            \LogActivityHelpers::saveLog(
                $logTp   = 'update', 
                $logNm   = "Closing Data Transaksi PO $data->po_cd", 
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
	
	function discount(Request $request, $id){    
        $po = InvPoPurchaseOrder::find($id);
		
        //$po->discount_amount = $request->discount_amount;
		//$po->discount_percent = $request->discount_percent;
		$po->data_10 = $request->data_10;
		$po->data_11 = $request->data_11;
		$po->data_12 = $request->data_12;
		$po->data_20 = $request->data_20;
		$po->data_21 = $request->data_21;
		$po->data_22 = $request->data_22;
					
        if (!($request->discount_amount == '' and $request->discount_percent == '')) {
			$discountPercent	= 0;
			$discountAmount		= 0;
				
			$sumPoDetail    	= InvPoPoDetail::where('po_cd', $po->po_cd)->sum('trx_amount');
            
			if ($request->discount_amount != '' and $request->discount_percent == '') {
				$discountAmount		= $request->discount_amount;
			}
			else if ($request->discount_amount == '' and $request->discount_percent != '') {
				$discountPercent	= $request->discount_percent;
				$discountAmount		= $sumPoDetail * ($discountPercent/100);
			}
			else {
				$discountPercent	= $request->discount_percent;
				$discountAmount		= $request->discount_amount;
			}
			
			$sumMinusDiscount	= $sumPoDetail - $discountAmount;

            //$po->total_price  	= $sumMinusDiscount;
            //$po->total_amount   	= $sumMinusDiscount;
			$po->discount_amount 	= $discountAmount;
			$po->discount_percent 	= $discountPercent;
		}
		$po->updated_by = Auth::user()->user_id;
        $po->save();
		
		return redirect()->back()->with(['success' => 'Berhasil Update Data Discount | Saksi']);
    }
	
	function generatePo(Request $request, $id){
		$popr = InvPoPurchaseOrder::find($id);
		
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
				
				$poprDetail = InvPoPoDetail::where('po_cd',$id)->get();
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
					$pod->info_note    	= $item->info_note;
					$pod->quantity_hs   = $item->quantity;
					$pod->unit_price_hs = $item->unit_price;
					$pod->trx_amount_hs = $item->trx_amount;
					$pod->created_by    = Auth::user()->user_id;
					$pod->save();
				}
				
				DB::commit();
				
				return response()->json(['status' => 'ok'],200);
			}
			catch (\Exception $e) {
				DB::rollback();
				return response()->json(['status' => 'error','error' => $e->getMessage()],200); 
			}
		}
    }
	
	function set(Request $request, $id){

        DB::beginTransaction();
        try {
            $data               = InvPoPurchaseOrder::find($id);
			$oldData = $data;
			
            $data->po_st  		= 'INV_TRX_ST_3';
			$data->updated_by   = Auth::user()->user_id;
            $data->save();

            \LogActivityHelpers::saveLog(
                $logTp   = 'update', 
                $logNm   = "Set Data Transaksi PO $data->po_cd", 
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

    function print(Request $request)
    {
        $pageFileName  = 'cetak';
        $title         = 'Purchase Order';
            
        // $data = DB::select("select inv.sp_inv_get_po_detail('".$request->id."','po_cd')");
        $data   = DB::table(DB::Raw("inv.sp_inv_get_po_detail('$request->id','po_cd')"))->get();
		
        return view('inventori::' . $this->folder_path . '.' . $pageFileName, compact('title','data'));
        // return response()->json(['status' => 'error', 'data'=> null],200);
    }
	
	function printRequest(Request $request)
    {
        $pageFileName  = 'request';
        $title         = 'Permintaan Pembelian';
            
        $data   = DB::table(DB::Raw("inv.sp_inv_get_po_detail('$request->id','po_cd')"))->get();

        return view('inventori::' . $this->folder_path . '.' . $pageFileName, compact('title','data'));
    }
	function printNota(Request $request)
    {
        $pageFileName  = 'nota';
        $title         = 'Nota Dinas';
            
        $data   = DB::table(DB::Raw("inv.sp_inv_get_po_detail('$request->id','po_cd')"))->get();

        return view('inventori::' . $this->folder_path . '.' . $pageFileName, compact('title','data'));
    }
	function printBast(Request $request)
    {
        $pageFileName  = 'bast';
        $title         = 'Berita Acara Serah Terima Barang';
            
        $data   = DB::table(DB::Raw("inv.sp_inv_get_po_detail('$request->id','po_cd')"))->get();

        return view('inventori::' . $this->folder_path . '.' . $pageFileName, compact('title','data'));
    }
	function printBacek(Request $request)
    {
        $pageFileName  = 'bacek';
        $title         = 'Berita Acara Pemeriksaan Barang';
            
        $data   = DB::table(DB::Raw("inv.sp_inv_get_po_detail('$request->id','po_cd')"))->get();

        return view('inventori::' . $this->folder_path . '.' . $pageFileName, compact('title','data'));
    }
	
	//--Invoice
	function invoice(){
        $pageFileName = 'invoice';
        $title        = 'Invoice';
		
		$suppliers  = InvPoSupplier::all();
        $gudangs	= InvInvPosInventori::all()->sortBy('pos_nm');//->where('pos_root','');
		
        \LogActivityHelpers::saveLog(
            $logTp = 'visit', 
            $logNm = "Membuka Menu $title"
        );
        
		return view('inventori::' . $this->folder_path . '.' . $pageFileName, compact('title','gudangs', 'suppliers'));
    }
	
	function getInvoice(Request $request){
        $data = InvPoPurchaseOrder::select(
				"po_cd",
                "po_no",
                "po_purchase_order.supplier_cd",
                "supplier.supplier_nm",
                "po_purchase_order.trx_date", 
                "note",
                "po_st",
				"invoice_st",
				"po_purchase_order.dana_tp",
                "com.code_nm as dana_tp_nm",
				"po_purchase_order.created_by",
				"unit.cc_cd",
				"po_purchase_order.total_amount",
				"po_purchase_order.reject_note"
				)
                ->where(function($where) use($request){
					$unit = empty(Auth::user()->unit_cd) ? '' : Auth::user()->unit_cd;
					if ($unit !== '') {
                        $where->where('unit_cd',[$unit]);
                    }
					/* if (Auth::user()->user_id == 'manager1') {
                        $where->whereIn('unit_cd',['TK','SD1','SD2','SD3','SMP']);
                    } */
					
                    if ($request->has('trx_date_param')) {
						$splitTanggal = explode("-",$request->trx_date_param);
						$tanggalStart = formatDate($splitTanggal[0]);
						$tanggalEnd   = formatDate($splitTanggal[1]);
			
						$where->whereRaw("trx_date::date between '$tanggalStart' and '$tanggalEnd'");
					}
					
                    $role = roleUser();
					$where->whereIn('po_st',['INV_TRX_ST_1','INV_TRX_ST_3']);
					$where->whereRaw("coalesce(popr_st,'')=''");
                    //$where->whereIn('invoice_st',['1','2']);
                })
				->leftJoin('inv.po_supplier as supplier','supplier.supplier_cd','po_purchase_order.supplier_cd')
				->leftJoin('public.com_code as com','com.com_cd','po_purchase_order.dana_tp')
				->leftJoin('erp.gl_cost_center as unit','unit.cc_cd','po_purchase_order.unit_cd')
				->orderBy('trx_date','desc');

        return DataTables::of($data)
                ->addColumn('actions', function($data){
                    $actions = '';
					
					switch ($data->invoice_st) {
					case '1':	
						$actions .= "<button type='button' class='invoice-close btn btn-info btn-flat btn-sm' data-toggle='tooltip' data-placement='top' title='Invoice Close'><i class='icon icon-check'></i> </button>";
						break;
						
					/* case '2':
						$actions .= "<button type='button' class='invoice-close btn btn-info btn-flat btn-sm' data-toggle='tooltip' data-placement='top' title='Invoice Close'><i class='icon icon-check'></i> </button>";
						break;	 */				
					
					default:
						$actions .= "<button type='button' class='invoice btn btn-info btn-flat btn-sm' data-toggle='tooltip' data-placement='top' title='Invoice'><i class='icon icon-check'></i> </button>";
						break;
                    }
					
					$actions .= "&nbsp<button type='button' class='view btn btn-success btn-flat btn-sm' data-toggle='tooltip' data-placement='top' title='View'><i class='icon icon-clipboard3'></i> </button>";
					
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
                ->addColumn('invoice_st_nm', function($data){
                    switch ($data->invoice_st) {
                        case '0': 
                            return "Invoice-Close";
							break;
                        case '1':
                            return "Invoice";
							break;
                        case '2':
                            return "Invoice Belum Lengkap";
							break;
                        default:
                            return "Belum Invoice"; 
                            break;
                    }
                })
                ->rawColumns(['po_tp_nm','invoice_st_nm','actions'])
                ->make(true);
    }
	
	function setInvoice(Request $request, $id){

        DB::beginTransaction();
        try {
            $data               = InvPoPurchaseOrder::find($id);
			$oldData = $data;
			
            $data->invoice_st	= '1';
			$data->reject_note	= '';
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
	
	function rejectInvoice(Request $request, $id){

        DB::beginTransaction();
        try {
            $data               = InvPoPurchaseOrder::find($id);
			$oldData = $data;
			
            $data->invoice_st	= '2';
			$data->reject_note	= $request->reject_note;
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
	
	function closeInvoice(Request $request, $id){

        DB::beginTransaction();
        try {
            $data               = InvPoPurchaseOrder::find($id);
			$oldData = $data;
			
            $data->invoice_st	= '0';
			$data->reject_note	= '';
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
	//--End Invoice
	
	//--Asset
	function asset(){
        $pageFileName = 'asset';
        $title        = 'Informasi Aset Baru';
		
		$suppliers  = InvPoSupplier::all();
        $gudangs	= InvInvPosInventori::all()->sortBy('pos_nm');//->where('pos_root','');
		
        \LogActivityHelpers::saveLog(
            $logTp = 'visit', 
            $logNm = "Membuka Menu $title"
        );
        
		return view('inventori::' . $this->folder_path . '.' . $pageFileName, compact('title','gudangs', 'suppliers'));
    }
	
	function getAsset(Request $request){
        $data = InvPoPurchaseOrder::select(
				"po_cd",
                "po_no",
                "po_purchase_order.supplier_cd",
                "supplier.supplier_nm",
                "po_purchase_order.trx_date", 
                "note",
                "po_st",
				"asset_st",
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
					
                    $role = roleUser();
					$where->whereIn('po_st',['INV_TRX_ST_1']);
					$where->whereRaw("coalesce(popr_st,'')=''");
                    $where->where('po_tp','1');
					//$where->where('asset_st','<>','0');
                })
				->leftJoin('inv.po_supplier as supplier','supplier.supplier_cd','po_purchase_order.supplier_cd')
				->leftJoin('public.com_code as com','com.com_cd','po_purchase_order.dana_tp')
				->leftJoin('erp.gl_cost_center as unit','unit.cc_cd','po_purchase_order.unit_cd')
				->orderBy('trx_date','desc');

        return DataTables::of($data)
                ->addColumn('actions', function($data){
                    $actions = '';
					
					if ($data->asset_st !='0') {
					$actions .= "<button type='button' class='asset-close btn btn-info btn-flat btn-sm' data-toggle='tooltip' data-placement='top' title='Register Aset'><i class='icon icon-check'></i> </button>";
					}
					
					$actions .= "&nbsp<button type='button' class='view btn btn-success btn-flat btn-sm' data-toggle='tooltip' data-placement='top' title='View'><i class='icon icon-clipboard3'></i> </button>";
					
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
                ->addColumn('asset_st_nm', function($data){
                    switch ($data->asset_st) {
                        case '0': 
                            return "Sudah Register";
							break;
                        case '1':
                            return "Belum Register";
							break;
                        default:
                            return "Belum Register"; 
                            break;
                    }
                })
                ->rawColumns(['po_tp_nm','invoice_st_nm','actions'])
                ->make(true);
    }
	
	function closeAsset(Request $request, $id){

        DB::beginTransaction();
        try {
            $data               = InvPoPurchaseOrder::find($id);
			$oldData = $data;
			
            $data->asset_st	= '0';
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
	//--End Asset
}
