<?php

namespace Modules\Inventori\Http\Controllers\MutasiInventori;

use DB;
use Auth;
use DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\InvInvProduksi;
use App\Models\InvInvProduksiDetail;
use App\Models\InvVwInvProdDetail;

use App\Models\InvInvPosItemUnit;
use App\Models\InvInvItemType;
use App\Models\InvInvUnit;
use App\Models\InvInvPosInventori;
use App\Models\InvInvItemMove;
use App\Models\InvInvBatchItem;
use App\Models\InvInvFormulaItem;

class ProduksiController extends Controller{
    private $folder_path = 'mutasi-inventori.produksi';
    
    function __construct(){
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function index($id = NULL){
        $gudangs    = InvInvPosInventori::all()->sortBy('pos_nm');//->where('pos_root','');
        $types      = InvInvItemType::all();
        
        if ($id) {
            $units         	= InvInvUnit::all();
            $pageFileName  	= 'data';
            $defaultProdNo	= InvInvProduksi::getDataCd(date('y'), date('m'));

            if ($id == 'tambah') {
                $title		= 'Tambah Produksi';
                $prod		= NULL;
                
                return view('inventori::' . $this->folder_path . '.' . $pageFileName, compact('title','gudangs', 'types', 'units', 'prod', 'defaultProdNo'));
            }else{
                $title  	= 'Data Produksi';
                $prod     	= InvInvProduksi::find($id);
    
                if ($prod) {
                    return view('inventori::' . $this->folder_path . '.' . $pageFileName, compact('title','gudangs', 'types', 'units', 'prod', 'defaultProdNo'));
                }else{
                    return redirect('/inventori/mutasi-inventori/produksi')->with('error', 'Produksi Tidak Ditemukan!');
                }
            }
        }else{
            $pageFileName  = 'index';
            $title         = 'Produksi';

            return view('inventori::' . $this->folder_path . '.' . $pageFileName, compact('title','gudangs'));
        }
    }

    /**
     * Display a listing of the resource for DataTables.
     *
     * @return \Illuminate\Http\Response
     */
    function getData(Request $request){
        if ($request->type == 'data') {
            $data = InvInvProduksi::select(
                "prod_cd",
                "prod_no",
				"prod_item",
				"item_nm as prod_item_nm",
				"quantity",
                "inv_produksi.pos_cd",
                "pos.pos_nm",
                //DB::Raw("fn_formatdate(inv_produksi.trx_date) as trx_date"), 
				"inv_produksi.trx_date as trx_date", 
                "note",
                "prod_st"
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
			->join('inv.inv_item_master as item','item.item_cd','inv_produksi.prod_item')
            ->leftJoin('inv.inv_pos_inventori as pos','pos.pos_cd','inv_produksi.pos_cd')
            ->orderBy('trx_date','asc');;

            return DataTables::of($data)
				->addColumn('actions', function($data){
                    $actions = '';
					
					$actions .= "<button type='button' class='detail btn btn-warning btn-flat btn-sm' data-toggle='tooltip' data-placement='top' title='Detail'><i class='icon icon-pencil7'></i> </button> &nbsp";
                    //if ($data->prod_st == 'INV_TRX_ST_1') {
					$actions .= "<button type='button' class='hapus btn btn-danger btn-flat btn-sm' data-toggle='tooltip' data-placement='top' title='Hapus'><i class='icon icon-trash'></i> </button> &nbsp";
					//}
                    return $actions;
                })
                ->addColumn('prod_st_nm',function($data){
                    switch ($data->prod_st) {
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
                ->rawColumns(['prod_st_nm','actions'])
                ->make(true);
        }else{
            $data = InvVwInvProdDetail::where('prod_cd', $request->id)
					->orderBy('date_trx','asc');

            return DataTables::of($data)
                ->addColumn('action',function($data){
                    if($data->prod_st == 'INV_TRX_ST_1'){
						$actions = '';
						
						$actions .= "<button type='button' class='ubah-item btn btn-warning btn-flat btn-sm' data-toggle='tooltip' data-placement='top' title='Ubah Data'><i class='icon icon-pencil7'></i> </button> &nbsp";
						
                        $actions .= "<button type='button' id='hapus-item' class='btn btn-danger btn-flat btn-sm' data-toggle='tooltip' data-placement='top' title='Hapus Data'><i class='icon icon-trash'></i> </button> &nbsp";
						
						if ( ($data->created_by == Auth::user()->user_id) or (in_array(roleUser(), array('superuser','adminv'))) ) {
						//$actions .= "<button type='button' id='update-wh' class='btn btn-info btn-flat btn-sm' data-toggle='tooltip' data-placement='top' title='Update Gudang'><i class='icon icon-basket'></i> </button>";
						}
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
        /* $this->validate($request,[
            //'prod_no'    => 'required',
            //'pos_cd'   => 'required',
        ]); */

        $saveProd = DB::transaction(function () use($request) {
            $trxDate = formatDateTime($request->trx_date);
			
			$defaultProdNo   = InvInvProduksi::getDataCd(date("Y", strtotime($trxDate)), date("n", strtotime($trxDate)));
            $prod                     	= new InvInvProduksi;
            //$prod->prod_no          	= $request->prod_no;
            if(!is_null($request->prod_no)){
                $prod->prod_no			= $request->prod_no;
            } else {
                $prod->prod_no			= $defaultProdNo;
            }
			$prod->prod_item        	= $request->prod_item;
			$prod->quantity        		= $request->prod_quantity;
			$prod->pos_cd        		= $request->pos_cd;
			$prod->trx_year           	= date("Y", strtotime($trxDate));
            $prod->trx_month          	= date("n", strtotime($trxDate));
            $prod->trx_date           	= $trxDate;
            $prod->note               	= $request->note;
            $prod->prod_st            	= 'INV_TRX_ST_1';
            $prod->pos_cd 				= Auth::user()->unit_cd;
			//$prod->entry_by         	= Auth::user()->user_id;
			$prod->entry_by          	= Auth::user()->user_nm;
            $prod->created_by         	= Auth::user()->user_id;
            $prod->save();
			
			//--Insert item produksi
			$formula = InvInvFormulaItem::select(
						'inv_formula_item.formula_cd as item_cd',
						'item.unit_cd as unit_cd',
						'inv_formula_item.content as quantity'
						)
						->join('inv.inv_item_master as item','item.item_cd','inv_formula_item.formula_cd')
						->where('inv_formula_item.item_cd',$prod->prod_item)
						->get();
			foreach ($formula as $item) {
				$proddt                	= new InvInvProduksiDetail;
				$proddt->prod_cd       	= $prod->prod_cd;
				$proddt->item_cd       	= $item->item_cd;
				$proddt->unit_cd       	= $item->unit_cd;
				//$proddt->quantity      	= $item->quantity;
				$proddt->quantity      	= 0;
				$proddt->created_by    	= Auth::user()->user_id;
				$proddt->save();
            }

            return $prod->prod_cd;
        });

        return redirect('/inventori/mutasi-inventori/produksi/'.$saveProd);
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

        $saveProd = DB::transaction(function () use($request, $id) {
            $prod                 = InvInvProduksi::find($id);

            $proddt                = new InvInvProduksiDetail;
            $proddt->prod_cd       = $id;
            $proddt->item_cd       = $request->item_cd;
            $proddt->unit_cd       = $request->unit_cd;
            $proddt->quantity      = $request->quantity;
            $proddt->created_by    = Auth::user()->user_id;
            $proddt->save();
			
			//$prod->trx_date       = $request->trx_date;
			$prod->trx_date		= formatDateTime($request->trx_date);
			
			$prod->pos_cd        	= $request->pos_cd;
			$prod->updated_by     = Auth::user()->user_id;
            $prod->save();

            return $prod;
        });

        return response()->json(['status' => 'ok', 'prod'=> $saveProd],200); 
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

        $saveProd = DB::transaction(function () use($request, $id) {
            $proddt                = InvInvProduksiDetail::find($id);
			
            $proddt->quantity      = $request->quantity;
            $proddt->updated_by    = Auth::user()->user_id;
            $proddt->save();

            return $proddt;
        });

        return response()->json(['status' => 'ok', 'prod'=> $saveProd],200); 
    }
	
	function updatePos(Request $request, $id){    
        /* $this->validate($request,[
            'pos_source'      => 'required',
        ]); */
		
		$proddt = InvInvProduksiDetail::find($id);
		//--Check stok
		$positemunit = InvInvPosItemUnit::select()
						->where('pos_cd',$request->pos_source)
						->where('item_cd',$proddt->item_cd)
						->where('unit_cd',$proddt->unit_cd)
						->first();
		if($positemunit){
			if($positemunit->quantity < $proddt->quantity){
				return response()->json(['status' => 'no', 'msg'=> $positemunit->quantity],200);
			}
		}
		//--End Check stok
			
        $saveProd = DB::transaction(function () use($request, $proddt) {
            $proddt->pos_source    = $request->pos_source;
            $proddt->updated_by    = Auth::user()->user_id;
            $proddt->save();

            return $proddt;
        });
		
		return response()->json(['status' => 'ok', 'prod'=> $saveProd],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function destroyItem($id){
        $deleteProd = DB::transaction(function () use($id) {
            $proddt    = InvInvProduksiDetail::find($id);
            $prodCd   = $proddt->prod_cd;
            
            $proddt    = InvInvProduksiDetail::destroy($id);

            $prod				= InvInvProduksi::find($prodCd);
            $prod->updated_by	= Auth::user()->user_id;
            $prod->save();

            return $prod;
        });

        return response()->json(['status' => 'ok', 'pr' => $deleteProd],200);
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
			$prod             	= InvInvProduksi::find($id);
			$prod->quantity		= $request->prod_quantity;
			$prod->prod_st     	= 'INV_TRX_ST_0';
			$prod->pos_source	= $posWh;
			$prod->updated_by 	= Auth::user()->user_id;
			$prod->save();
			
			//--Proses stok
			$pos = $prod->pos_cd;
			$requestDetail	= InvInvProduksiDetail::where('prod_cd',$id)->get();
		
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
								->where('pos_cd',$prod->pos_cd)
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
					$newMove->pos_destination = $prod->pos_cd;
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
					$posItemUnit->pos_cd     = $prod->pos_cd;
					$posItemUnit->unit_cd    = $item->unit_cd;
					$posItemUnit->quantity   = $item->quantity;
					$posItemUnit->created_by = Auth::user()->user_id;
					$posItemUnit->save();
					
					//--WH Source | Stock Out
					$newMove                  = new InvInvItemMove;
					//$newMove->pos_cd          = $posWh;
					$newMove->pos_cd          = $posWhItem;
					$newMove->pos_destination = $prod->pos_cd;
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
					$newMove->pos_cd          = $prod->pos_cd;
					$newMove->pos_destination = $prod->pos_cd;
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
        InvInvProduksi::destroy($id);

        return response()->json(['status' => 'ok'],200);
    }

    function print(Request $request)
    {
        $pageFileName  = 'cetak';
        $title         = 'Produksi';
            
        $data   = DB::table(DB::Raw("inv.sp_inv_get_prod_detail('$request->id')"))->get();

        return view('inventori::' . $this->folder_path . '.' . $pageFileName, compact('title','data'));
    }
}
