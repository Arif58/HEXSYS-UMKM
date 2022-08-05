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
use App\Models\InvPoPurchaseRequest;
use App\Models\InvPoPrDetail;
use App\Models\InvInvPosInventori;
use App\Models\InvPoSupplier;
use App\Models\InvVwInvPrDetail;

use App\Models\InvInvItemMove;
use App\Models\InvInvBatchItem;

class PurchaseRequestController extends Controller{
    private $folder_path = 'pembelian.purchase-request';
    
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
        $gudangs	= InvInvPosInventori::all()->sortBy('pos_nm');//->where('pos_root','');
        $types      = InvInvItemType::all();
        
        if ($id) {
            $units         = InvInvUnit::all();
            $pageFileName  = 'data';
            $defaultPrNo   = InvPoPurchaseRequest::getDataCd(date('y'), date('m'));

            if ($id == 'tambah') {
                $title          = 'Tambah Permintaan Barang';
                $pr             = NULL;
                
                return view('inventori::' . $this->folder_path . '.' . $pageFileName, compact('title','gudangs', 'suppliers', 'types', 'units', 'pr', 'defaultPrNo'));
            }else{
                $title  = 'Data Permintaan Barang';
                $pr     = InvPoPurchaseRequest::find($id);
    
                if ($pr) {
                    return view('inventori::' . $this->folder_path . '.' . $pageFileName, compact('title','gudangs', 'suppliers', 'types', 'units', 'pr', 'defaultPrNo'));
                }else{
                    return redirect('inventori/pembelian/purchase-request')->with('error', 'Purchase Request Tidak Ditemukan!');
                }
            }
        }else{
            $pageFileName  = 'index';
            $title         = 'Permintaan Barang';

            return view('inventori::' . $this->folder_path . '.' . $pageFileName, compact('title','gudangs', 'suppliers'));
        }
    }

    /**
     * Display a listing of the resource for DataTables.
     *
     * @return \Illuminate\Http\Response
     */
    function getData(Request $request){
        if ($request->type == 'data') {
            $data = InvPoPurchaseRequest::select(
                "pr_cd",
                "pr_no",
                "po_purchase_request.pos_cd",
                "pos.pos_nm",
                //DB::Raw("fn_formatdate(po_purchase_request.trx_date) as trx_date"), 
				"po_purchase_request.trx_date as trx_date", 
                "note",
                "pr_st"
            )
			->where(function($where) use($request){
				$unit = empty(Auth::user()->unit_cd) ? '' : Auth::user()->unit_cd;
				if ($unit !== '') {
					$where->where('pos.pos_cd',[$unit]);
				}
				
				if ($request->has('trx_date_param')) {
					$splitTanggal = explode("-",$request->trx_date_param);
					$tanggalStart = formatDate($splitTanggal[0]);
					$tanggalEnd   = formatDate($splitTanggal[1]);
		
					$where->whereRaw("trx_date::date between '$tanggalStart' and '$tanggalEnd'");
				}
			})
            ->leftJoin('inv.inv_pos_inventori as pos','pos.pos_cd','po_purchase_request.pos_cd')
            ->orderBy('trx_date','asc');;

            return DataTables::of($data)
				->addColumn('actions', function($data){
                    $actions = '';
					
					$actions .= "<button type='button' class='detail btn btn-warning btn-flat btn-sm' data-toggle='tooltip' data-placement='top' title='Detail'><i class='icon icon-pencil7'></i> </button> &nbsp";
                    if ($data->pr_st == 'INV_TRX_ST_1') {
					$actions .= "<button type='button' class='hapus btn btn-danger btn-flat btn-sm' data-toggle='tooltip' data-placement='top' title='Hapus'><i class='icon icon-trash'></i> </button> &nbsp";
					}
                    return $actions;
                })
                ->addColumn('pr_st_nm',function($data){
                    switch ($data->pr_st) {
                        case 'INV_TRX_ST_0':
                            return '<span class="badge badge-success badge-icon"><i class="icon icon-check"></i> Close</span>';
                            break;
                        case 'INV_TRX_ST_1':
                            return '<span class="badge badge-info badge-icon"><i class="icon icon-pencil"></i> Input</span>';
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
                        
                        default:
                            return '<span class="badge badge-danger badge-icon"><i class="icon-cancel-circle2"></i> Cancel</span>';
                            break;
                    }
            
                })
                ->rawColumns(['pr_st_nm','actions'])
                ->make(true);
        }else{
            $data = InvVwInvPrDetail::where('pr_cd', $request->id)
					->orderBy('date_trx','asc');

            return DataTables::of($data)
				->addColumn('info_st_nm', function($data){
                    switch ($data->info_st) {
                        case '0': 
                            return "";
							break;
                        case '1':
                            return "Reject";
							break;
                        default:
                            return ""; 
                            break;
                    }
                })
                ->addColumn('action',function($data){
                    if($data->pr_st == 'INV_TRX_ST_1'){
						$actions = '';
						
						$actions .= "<button type='button' class='ubah-item btn btn-warning btn-flat btn-sm' data-toggle='tooltip' data-placement='top' title='Ubah Data'><i class='icon icon-pencil7'></i> </button> &nbsp";
						
                        $actions .= "<button type='button' id='hapus-item' class='btn btn-danger btn-flat btn-sm' data-toggle='tooltip' data-placement='top' title='Hapus Data'><i class='icon icon-trash'></i> </button> &nbsp";
						
						if ( ($data->created_by == Auth::user()->user_id) or (in_array(roleUser(), array('superuser','adminv'))) ) {
						$actions .= "<button type='button' id='update-wh' class='btn btn-info btn-flat btn-sm' data-toggle='tooltip' data-placement='top' title='Update Gudang'><i class='icon icon-basket'></i> </button>";
						}
                    }else{
                        $actions = '';
                    }
                    return $actions;
                })
                ->rawColumns(['info_st_nm','action'])
                ->make(true);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    function store(Request $request){
        /* $this->validate($request,[
            //'pr_no'    => 'required',
            //'pos_cd'   => 'required',
        ]); */

        $savePr = DB::transaction(function () use($request) {
            $trxDate = formatDateTime($request->trx_date);
			
			$defaultPrNo   = InvPoPurchaseRequest::getDataCd(date("Y", strtotime($trxDate)), date("n", strtotime($trxDate)));
            $pr                     = new InvPoPurchaseRequest;
            // $pr->pr_no              = $request->pr_no;
            if(!is_null($request->pr_no)){
                $pr->pr_no              = $request->pr_no;
            } else {
                $pr->pr_no              = $defaultPrNo;
            }
			$pr->pos_cd        		= $request->pos_cd;
            //$pr->supplier_cd      = $request->supplier_cd;
			$pr->trx_year           = date("Y", strtotime($trxDate));
            $pr->trx_month          = date("n", strtotime($trxDate));
            $pr->trx_date           = $trxDate;
            $pr->note               = $request->note;
            $pr->pr_st              = 'INV_TRX_ST_1';
            $pr->pos_cd = Auth::user()->unit_cd;
			//$pr->entry_by         = Auth::user()->user_id;
			$pr->entry_by          	= Auth::user()->user_nm;
            $pr->created_by         = Auth::user()->user_id;
            $pr->save();

            return $pr->pr_cd;
        });

        return redirect('/inventori/pembelian/purchase-request/'.$savePr);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    function storeItem(Request $request, $id){
		$this->validate($request,[
            'item_cd'       => 'required',
            'unit_cd'       => 'required',
            'quantity'      => 'required',
        ]);

        $savePrd = DB::transaction(function () use($request, $id) {
            $pr                 = InvPoPurchaseRequest::find($id);

            $prd                = new InvPoPrDetail;
            $prd->pr_cd         = $id;
            $prd->item_cd       = $request->item_cd;
            $prd->unit_cd       = $request->unit_cd;
            $prd->quantity      = $request->quantity;
			$prd->quantity_hs   = $request->quantity;
			$prd->info_note     = $request->info_note;
			if ($request->info_st == "on") {
			$prd->info_st     	= '1';
			}
			else {
			$prd->info_st     	= '0';
			}
            
            $prd->created_by    = Auth::user()->user_id;
            $prd->save();
			
			//$pr->trx_date       = $request->trx_date;
			$pr->trx_date		= formatDateTime($request->trx_date);
			
			$pr->pos_cd        	= $request->pos_cd;
			$pr->updated_by     = Auth::user()->user_id;
            $pr->save();

            return $pr;
        });

        return response()->json(['status' => 'ok', 'pr'=> $savePrd],200); 
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
        ]);

        $savePrd = DB::transaction(function () use($request, $id) {
            $prd                = InvPoPrDetail::find($id);
			
            $prd->quantity      = $request->quantity;
			$prd->info_note     = $request->info_note;
			if ($request->info_st == "on") {
			$prd->info_st     	= '1';
			}
			else {
			$prd->info_st     	= '0';
			}
            $prd->updated_by    = Auth::user()->user_id;
            $prd->save();

            return $prd;
        });

        return response()->json(['status' => 'ok', 'prd'=> $savePrd],200); 
    }
	
	function updatePos(Request $request, $id){    
        /* $this->validate($request,[
            'pos_source'      => 'required',
        ]); */
		
		$prd = InvPoPrDetail::find($id);
		//--Check stok
		$positemunit = InvInvPosItemUnit::select()
						->where('pos_cd',$request->pos_source)
						->where('item_cd',$prd->item_cd)
						->where('unit_cd',$prd->unit_cd)
						->first();
		if($positemunit){
			if($positemunit->quantity < $prd->quantity){
				return response()->json(['status' => 'no', 'msg'=> $positemunit->quantity],200);
			}
		}
		//--End Check stok
			
        //$savePrd = DB::transaction(function () use($request, $id) {
        //    $prd                = InvPoPrDetail::find($id);
		$savePrd = DB::transaction(function () use($request, $prd) {
            $prd->pos_source    = $request->pos_source;
            $prd->pos_cd = Auth::user()->unit_cd;
            $prd->updated_by    = Auth::user()->user_id;
            $prd->save();

            return $prd;
        });
		
		return response()->json(['status' => 'ok', 'prd'=> $savePrd],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function destroyItem($id){
        $deletePrd = DB::transaction(function () use($id) {
            $prd    = InvPoPrDetail::find($id);
            $prCd   = $prd->pr_cd;
            
            $prd    = InvPoPrDetail::destroy($id);

            $pr             	= InvPoPurchaseRequest::find($prCd);
            $pr->updated_by     = Auth::user()->user_id;
            $pr->save();

            return $pr;
        });

        return response()->json(['status' => 'ok', 'pr' => $deletePrd],200);
    }

    /*
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function update(Request $request, $id){
		if($request->pos_source){
			$posWh = $request->pos_source;
		} else {
			$posWh = configuration('WHPOS_TRX');
		}
		
        DB::beginTransaction();
		try {
			$pr             = InvPoPurchaseRequest::find($id);
			$pr->pr_st     	= 'INV_TRX_ST_0';
			$pr->pos_source	= $posWh;
            $pr->pos_cd = Auth::user()->unit_cd;
			$pr->updated_by = Auth::user()->user_id;
			$pr->save();
			
			//--Proses stok
			$pos = $pr->pos_cd;
			$requestDetail	= InvPoPrDetail::where('pr_cd',$id)
								->where('info_st','<>','1')
								->get();
		
			foreach ($requestDetail as $item) {
				if($item->pos_source){
					$posWhItem = $item->pos_source;
				} else {
					$posWhItem = $posWh;
				}
		
				$whItemUnit = InvInvPosItemUnit::select()
								//->where('pos_cd',$posWh)
								->where('pos_cd',$posWhItem)
								->where('item_cd',$item->item_cd)
								->where('unit_cd',$item->unit_cd)
								->first();
								
				$positemunit = InvInvPosItemUnit::select()
								->where('pos_cd',$pr->pos_cd)
								->where('item_cd',$item->item_cd)
								->where('unit_cd',$item->unit_cd)
								->first();
								
				if($positemunit){
					$oldStock             = InvInvPosItemUnit::find($positemunit->positemunit_cd);
					
					$newStock             = InvInvPosItemUnit::find($positemunit->positemunit_cd);
					$newStock->quantity   = $oldStock->quantity + $item->quantity;
					$newStock->updated_by = Auth::user()->user_id;
					$newStock->save();
					
					//--WH Source | Stock Out
					$newMove                  = new InvInvItemMove;
					//$newMove->pos_cd          = $posWh;
					$newMove->pos_cd          = $posWhItem;
					$newMove->pos_destination = $pr->pos_cd;
					$newMove->unit_cd         = $item->unit_cd;
					$newMove->item_cd         = $item->item_cd;
					$newMove->trx_by          = Auth::user()->user_id;
					$newMove->trx_datetime    = date('Y-m-d H:i:s');
					$newMove->trx_qty         = $item->quantity;
					$newMove->move_tp         = 'MOVE_TP_2';
					$newMove->old_stock       = $whItemUnit->quantity;
					$newMove->new_stock       = $whItemUnit->quantity - $item->quantity;
					$newMove->created_by      = Auth::user()->user_id;
					$newMove->save();
					
					//--WH Destination  | Stock In
					$newMove                  = new InvInvItemMove;
					$newMove->pos_cd          = $oldStock->pos_cd;
					$newMove->pos_destination = $oldStock->pos_cd;
					$newMove->unit_cd         = $oldStock->unit_cd;
					$newMove->item_cd         = $oldStock->item_cd;
					$newMove->trx_by          = Auth::user()->user_id;
					$newMove->trx_datetime    = date('Y-m-d H:i:s');
					$newMove->trx_qty         = $item->quantity;
					$newMove->move_tp         = 'MOVE_TP_1';
					$newMove->old_stock       = $oldStock->quantity;
					$newMove->new_stock       = $oldStock->quantity + $item->quantity;
					$newMove->created_by      = Auth::user()->user_id;
					$newMove->save();
				} else {
					$posItemUnit = new InvInvPosItemUnit;
					$posItemUnit->item_cd    = $item->item_cd;
					$posItemUnit->pos_cd     = $pr->pos_cd;
					$posItemUnit->unit_cd    = $item->unit_cd;
					$posItemUnit->quantity   = $item->quantity;
					$posItemUnit->created_by = Auth::user()->user_id;
					$posItemUnit->save();
					
					//--WH Source | Stock Out
					$newMove                  = new InvInvItemMove;
					//$newMove->pos_cd          = $posWh;
					$newMove->pos_cd          = $posWhItem;
					$newMove->pos_destination = $pr->pos_cd;
					$newMove->unit_cd         = $item->unit_cd;
					$newMove->item_cd         = $item->item_cd;
					$newMove->trx_by          = Auth::user()->user_id;
					$newMove->trx_datetime    = date('Y-m-d H:i:s');
					$newMove->trx_qty         = $item->quantity;
					$newMove->move_tp         = 'MOVE_TP_2';
					$newMove->old_stock       = $whItemUnit->quantity;
					$newMove->new_stock       = $whItemUnit->quantity - $item->quantity;
					$newMove->created_by      = Auth::user()->user_id;
					$newMove->save();
					
					//--WH Destination  | Stock In
					$newMove                  = new InvInvItemMove;
					$newMove->pos_cd          = $pr->pos_cd;
					$newMove->pos_destination = $pr->pos_cd;
					$newMove->unit_cd         = $item->unit_cd;
					$newMove->item_cd         = $item->item_cd;
					$newMove->trx_by          = Auth::user()->user_id;
					$newMove->trx_datetime    = date('Y-m-d H:i:s');
					$newMove->trx_qty         = $item->quantity;
					$newMove->move_tp         = 'MOVE_TP_1';
					$newMove->old_stock       = 0;
					$newMove->new_stock       = $item->quantity;
					$newMove->created_by      = Auth::user()->user_id;
					$newMove->save();
				}
				
				$oldStockSource             = InvInvPosItemUnit::find($whItemUnit->positemunit_cd);
				$newStockSource             = InvInvPosItemUnit::find($whItemUnit->positemunit_cd);
				$newStockSource->quantity   = $oldStockSource->quantity - $item->quantity;
				$newStockSource->updated_by = Auth::user()->user_id;
				$newStockSource->save();
			}
			
			DB::commit();
		} catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => 'error','error' => $e],200); 
        }

        return response()->json(['status' => 'ok'],200); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function destroy($id){
        InvPoPurchaseRequest::destroy($id);

        return response()->json(['status' => 'ok'],200);
    }

    function print(Request $request)
    {
        $pageFileName  = 'cetak';
        $title         = 'Purchase Order';
            
        //$data = DB::select("select inv.sp_inv_get_pr_detail('".$request->id."','pr_cd')");
        $data   = DB::table(DB::Raw("inv.sp_inv_get_pr_detail('$request->id','pr_cd')"))->get();

        return view('inventori::' . $this->folder_path . '.' . $pageFileName, compact('title','data'));
        // return response()->json(['status' => 'ok', 'data'=> 'print'],200);
    }
}
