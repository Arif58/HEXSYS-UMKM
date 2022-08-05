<?php

namespace Modules\Inventori\Http\Controllers\Pembelian;

use DB;
use Auth;
use DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\InvInvItemMaster;
use App\Models\InvInvPosItemUnit;
use App\Models\InvInvItemType;
use App\Models\InvInvUnit;
use App\Models\InvPoReceiveItem;
use App\Models\InvPoReceiveDetail;
use App\Models\InvInvPosInventori;
use App\Models\InvPoSupplier;
use App\Models\InvPoPrincipal;
use App\Models\InvVwInvPoDetail;

use App\Models\InvInvItemMove;
use App\Models\InvInvBatchItem;

class ReceiveItemController extends Controller{
    private $folder_path = 'pembelian.receive-item';
    
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
        //$gudangs    = InvInvPosInventori::all();
		$gudangs       = InvInvPosInventori::all()->sortBy('pos_nm');//->where('pos_root','');
        $types      = InvInvItemType::all();
        $principals = InvPoPrincipal::all();
        
        if ($id) {
            $units         = InvInvUnit::all();
            $pageFileName  = 'data';
            $defaultNo   = InvPoReceiveItem::getDataCd(date('Y'), date('n'));
			
            if ($id == 'tambah') {
                $title   = 'Tambah Receive';
                $receive = NULL;
                
                return view('inventori::' . $this->folder_path . '.' . $pageFileName, compact('title','gudangs', 'suppliers', 'principals', 'types', 'units', 'receive', 'defaultNo'));
            }else{
                $title   = 'Data Receive';
                $receive = InvPoReceiveItem::find($id);
    
                if ($receive) {
                    return view('inventori::' . $this->folder_path . '.' . $pageFileName, compact('title','gudangs', 'suppliers', 'principals', 'types', 'units', 'receive', 'defaultNo'));
                }else{
                    return redirect('inventori/pembelian/purchase-order')->with('error', 'Receive Tidak Ditemukan!');
                }
            }
        }else{
            $pageFileName  = 'index';
            $title         = 'Receive';

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
            $data = InvPoReceiveItem::select(
                "ri_cd",
                "ri_no",
                "po_receive_item.supplier_cd",
                "supplier.supplier_nm",
                //DB::Raw("fn_formatdatetime(po_receive_item.entry_date) as entry_date"),
				"po_receive_item.trx_date", 
                "note",
                "ri_st"
            )
			->where(function($where) use($request){
				if ($request->has('trx_date_param')) {
					$splitTanggal = explode("-",$request->trx_date_param);
					$tanggalStart = formatDate($splitTanggal[0]);
					$tanggalEnd   = formatDate($splitTanggal[1]);
		
					$where->whereRaw("trx_date::date between '$tanggalStart' and '$tanggalEnd'");
				}
			})
            ->leftJoin('inv.po_supplier as supplier','supplier.supplier_cd','po_receive_item.supplier_cd')
            ->orderBy('trx_date','desc');

            return DataTables::of($data)
				->addColumn('actions', function($data){
                    $actions = '';
					
					if ( ($data->created_by == Auth::user()->user_id) or (in_array(roleUser(), array('superuser','adminv'))) ) {
					$actions .= "<button type='button' class='detail btn btn-warning btn-flat btn-sm' data-toggle='tooltip' data-placement='top' title='Detail'><i class='icon icon-pencil7'></i> </button> &nbsp";
                    $actions .= "<button type='button' class='hapus btn btn-danger btn-flat btn-sm' data-toggle='tooltip' data-placement='top' title='Hapus'><i class='icon icon-trash'></i> </button> &nbsp";
					}
                    return $actions;
                })
                ->addColumn('ri_st_nm',function($data){
                    switch ($data->ri_st) {
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
                ->rawColumns(['ri_st_nm','actions'])
                ->make(true);
        }else{
            $data = InvPoReceiveDetail::where('po_receive_detail.ri_cd', $request->id)
                    ->join('inv.po_receive_item as ri','ri.ri_cd','po_receive_detail.ri_cd')
                    ->leftJoin('inv.inv_item_master as item','item.item_cd','po_receive_detail.item_cd')
                    ->leftJoin('inv.inv_unit as unit','unit.unit_cd','item.unit_cd')
                    ->orderBy('trx_date','desc');

            return DataTables::of($data)
                ->addColumn('action',function($data){
                    if($data->ri_st == 'INV_TRX_ST_1'){
						$actions = '';
						
						/* $actions .= "<button type='button' class='ubah-item btn btn-warning btn-flat btn-sm' data-toggle='tooltip' data-placement='top' title='Ubah Data'><i class='icon icon-pencil7'></i> </button> &nbsp"; */
						
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    function store(Request $request){
        $this->validate($request,[
            //'ri_no'         => 'required',
            'supplier_cd'   => 'required',
        ]);

        $savePo = DB::transaction(function () use($request) {
			$trxDate = formatDate($request->trx_date);
			$defaultNo   = InvPoReceiveItem::getDataCd(date("Y", strtotime($trxDate)), date("n", strtotime($trxDate)));
			
            $receive                    = new InvPoReceiveItem;
            
			//$receive->ri_no             = $request->ri_no;
			if(!is_null($request->ri_no)){
                $receive->ri_no              = $request->ri_no;
            } else {
                $receive->ri_no              = $defaultNo;
            }
			
            $receive->supplier_cd       = $request->supplier_cd;
            $receive->principal_cd      = $request->principal_cd;
            $receive->invoice_no        = $request->invoice_no;
			
            $receive->trx_year           = date("Y", strtotime($trxDate));
            $receive->trx_month          = date("n", strtotime($trxDate));
            $receive->trx_date           = $trxDate;
			
            $receive->currency_cd       = $request->currency_cd;
            $receive->rate              = $request->rate;
            $receive->total_price       = $request->total_price;
            $receive->total_discount    = $request->total_discount;
            $receive->total_amount      = $request->total_amount;
            $receive->vat_tp            = $request->vat_tp;
            $receive->percent_ppn       = $request->percent_ppn;
            $receive->ppn               = $request->ppn;
            $receive->note              = $request->note;
            $receive->pos_cd            = $request->pos_cd;
            $receive->ri_st             = 'INV_TRX_ST_1';
            $receive->pos_cd = Auth::user()->unit_cd;
            //$receive->entry_by          = Auth::user()->user_id;
			$receive->entry_by          = Auth::user()->user_nm;
            $receive->created_by        = Auth::user()->user_id;
            $receive->save();

            // $itemData   = InvInvPosItemUnit::query()->select(
            //                 DB::Raw("'$receive->inv_opname_id' as inv_opname_id"),
            //                 "inv_pos_itemunit.item_cd",
            //                 "inv_pos_itemunit.unit_cd",
            //                 "inv_pos_itemunit.quantity AS quantity_real",
            //                 "inv_pos_itemunit.quantity AS quantity_system",
            //                 DB::Raw("'$receive->created_by' as created_by"),
            //             )
            //             ->where(function ($query) use($request){
            //                 if($request->type_cd) $query->where('master.type_cd', $request->type_cd);
            //             })
            //             ->join('inv.inv_item_master as master','master.item_cd','inv_pos_itemunit.item_cd')
            //             ->orderBy('inv_pos_itemunit.item_cd')->get()->toArray();
            
            // $insert     = InvPoReceiveDetail::insert($itemData);
            return $receive->ri_cd;
        });

        return redirect('/inventori/pembelian/receive-item/'.$savePo);
    }

    /*
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function update(Request $request, $id){
		$receive				= InvPoReceiveItem::find($id);
		$receive->ri_st     	= 'INV_TRX_ST_0';
        $receive->updated_by	= Auth::user()->user_id;
        $receive->save();
		
		//--Proses stok | Update harga item
		$pos = $receive->pos_cd;
		$receivedDetail	= InvPoReceiveDetail::where('ri_cd',$id)->get();
		
		DB::beginTransaction();
		try {
			foreach ($receivedDetail as $item) {
				//--Proses stok
				$positemunit = InvInvPosItemUnit::select()
								->where('pos_cd',$receive->pos_cd)
								->where('item_cd',$item->item_cd)
								->where('unit_cd',$item->unit_cd)
								->first();
								
				$itemMaster = InvInvItemMaster::find($item->item_cd);
				
				if($itemMaster){
				if($itemMaster->inventory_st == '1')
				{//--Check inventori_st = barang inventori
				
				if($positemunit){
					$oldStock             = InvInvPosItemUnit::find($positemunit->positemunit_cd);
					
					$newStock             = InvInvPosItemUnit::find($positemunit->positemunit_cd);
					$newStock->quantity   = $oldStock->quantity + $item->quantity;
					$newStock->updated_by = Auth::user()->user_id;
					$newStock->save();
					
					$newMove                  = new InvInvItemMove;
					$newMove->pos_cd          = $oldStock->pos_cd;
					$newMove->pos_destination = $oldStock->pos_cd;
					$newMove->unit_cd         = $oldStock->unit_cd;
					$newMove->item_cd         = $oldStock->item_cd;
                    $newMove->pos_cd = Auth::user()->unit_cd;
					$newMove->trx_by          = Auth::user()->user_id;
					$newMove->trx_datetime    = date('Y-m-d H:i:s');
					$newMove->trx_qty         = $item->quantity;
					$newMove->move_tp         = 'MOVE_TP_1';
					$newMove->old_stock       = $oldStock->quantity;
					$newMove->new_stock       = $oldStock->quantity + $item->quantity;
					$newMove->created_by      = Auth::user()->user_id;
					$newMove->save();
					
					if ($item->expire_date) {
						$batch               = new InvInvBatchItem;
						$batch->batch_no     = $newMove->inv_item_move_id;
						$batch->item_cd      = $newMove->item_cd;
						$batch->trx_qty      = $newMove->trx_qty;
						$batch->expire_date  = formatDate($request->expire_date);
						$batch->created_by   = Auth::user()->user_id;
						$batch->save();
					}
				}
				else {
					
				}
				
				//--Update harga item
				if($itemMaster->item_price_buy == 0){
					$itemMaster->item_price     = $item->unit_price;
					$itemMaster->item_price_buy = $item->unit_price;
					
				} else {
					$itemMaster->item_price     = ($itemMaster->item_price_buy+$item->unit_price)/2;
					$itemMaster->item_price_buy = ($itemMaster->item_price_buy+$item->unit_price)/2;
				}
				$itemMaster->updated_by     = Auth::user()->user_id;
				$itemMaster->save();
				
				}}//--End Check inventori_st = barang inventori
			}
			
			DB::commit();
		} catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => 'error','error' => $e->getMessage()],200); 
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
        InvPoReceiveItem::destroy($id);

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

        $saveRD = DB::transaction(function () use($request, $id) {
            $receive                 = InvPoReceiveItem::find($id);

            $received                   = new InvPoReceiveDetail;
            $received->ri_cd            = $id;
            $received->po_cd            = $request->po_cd;
            $received->principal_cd     = $request->principal_cd;
            $received->item_cd          = $request->item_cd;
			
			$received->item_desc     	= $request->item_nm;
			//$received->assettp_cd    	= $request->assettp_cd;
            //$received->assettp_desc  	= $request->item_nm;
            
            $received->unit_cd          = $request->unit_cd;
            $received->quantity         = $request->quantity;
            $received->unit_price       = $request->unit_price;
            $received->trx_amount       = $request->trx_amount;
            $received->discount_percent = 0;
            $received->discount_amount  = 0;
            $received->currency_cd      = $request->currency_cd;
            $received->rate             = $request->rate;
            $received->faktur_no        = $request->faktur_no;
            $received->faktur_date      = formatDate($request->faktur_date);
            $received->batch_no         = $request->batch_no;
            $received->expire_date      = empty($request->expire_date) ? NULL : formatDate($request->expire_date);
			$received->note             = $request->note;
            $received->created_by       = Auth::user()->user_id;
            $received->save();

            $sumPoDetail    = InvPoReceiveDetail::where('ri_cd', $receive->ri_cd)->sum('trx_amount');
            
            $amountPpn      = $sumPoDetail * ($receive->percent_ppn/100);
            $sumPlusPpn     = $sumPoDetail + $amountPpn;

            $receive->total_price    = $sumPoDetail;
            $receive->total_amount   = $sumPlusPpn;
            $receive->ppn            = $amountPpn;
            $receive->updated_by     = Auth::user()->user_id;
            $receive->save();

            return $receive;
        });

        return response()->json(['status' => 'ok', 'po'=> $saveRD],200); 
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

        // return $request->all();

        $saveRD = DB::transaction(function () use($request, $id) {
            $received                   = InvPoReceiveDetail::find($id);
            $received->quantity         = $request->quantity;
            $received->unit_price       = $request->unit_price;
            $received->trx_amount       = $request->quantity * $request->unit_price;

            // cek perubahan diskon persen
            // if ($received->discount_percent != $request->discount_percent) {
                $received->discount_percent = $request->discount_percent;
                $received->discount_amount  = ($request->discount_percent / 100 ) * $received->trx_amount;
            // }

            // cek perubahan diskon angka
            // if ($received->discount_amount != $request->discount_amount) {
            //     $received->discount_percent = ($request->discount_amount / $received->trx_amount) * 100;
            //     $received->discount_amount  = $request->discount_amount;
            // }

            $received->updated_by       = Auth::user()->user_id;
            $received->save();

            // update tabel receive item
            $receive                = InvPoReceiveItem::find($received->ri_cd);
            $sumPoDetail            = InvPoReceiveDetail::where('ri_cd', $receive->ri_cd)->sum('trx_amount');
            $sumDiscAmountDetail    = InvPoReceiveDetail::where('ri_cd', $receive->ri_cd)->sum('discount_amount');

            $receive->total_discount = $sumDiscAmountDetail;
            $receive->total_price    = $sumPoDetail;

            $amountPpn              = $receive->total_price * ($receive->percent_ppn/100);
            $sumPlusPpn             = $receive->total_price + $amountPpn;

            $receive->total_amount   = $sumPlusPpn;
            $receive->ppn            = $amountPpn;
            $receive->updated_by     = Auth::user()->user_id;
            $receive->save();

            return $receive;
        });

        return response()->json(['status' => 'ok', 'po'=> $saveRD],200); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function destroyItem($id){
        $deletePod = DB::transaction(function () use($id) {
            $received    = InvPoReceiveDetail::find($id);
            $receiveCd   = $received->ri_cd;
            
            $received    = InvPoReceiveDetail::destroy($id);

            $receive        = InvPoReceiveItem::find($receiveCd);
            $sumPoDetail    = InvPoReceiveDetail::where('ri_cd', $receive->ri_cd)->sum('trx_amount');
            $amountPpn      = $sumPoDetail * ($receive->percent_ppn/100);
            $sumPlusPpn     = $sumPoDetail + $amountPpn;

            $receive->total_price    = $sumPoDetail;
            $receive->total_amount   = $sumPlusPpn;
            $receive->ppn            = $amountPpn;
            $receive->updated_by     = Auth::user()->user_id;
            $receive->save();

            return $receive;
        });

        return response()->json(['status' => 'ok', 'po' => $deletePod],200);
    }

    /**
     * Print specified resource
     */

    function print(Request $request)
    {
        $pageFileName  = 'cetak';
        $title         = 'Faktur Penerimaan Barang';
            
        $data   = DB::table(DB::Raw("inv.sp_inv_get_ri_detail('$request->id','ri_cd')"))->get();

        return view('inventori::' . $this->folder_path . '.' . $pageFileName, compact('title','data'));


        // return response()->json(['status' => 'ok', 'data'=> 'print'],200);
    }

    /**
     * Show resources for datatable 
     * @return Response
     */
    function getDataListPo(Request $request){
        $data   = DB::table(DB::Raw("inv.sp_inv_get_po_detail('$request->supplier','supplier_cd')"));

        return DataTables::of($data)->make(true);
    }
}
