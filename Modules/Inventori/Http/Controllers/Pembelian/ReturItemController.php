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
use App\Models\InvPoRetur;
use App\Models\InvPoReturDetail;
use App\Models\InvInvPosInventori;
use App\Models\InvPoSupplier;
use App\Models\InvPoPrincipal;
use App\Models\InvVwInvPoDetail;

class ReturItemController extends Controller
{
    private $folder_path = 'pembelian.retur-item';
    
    function __construct(){
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index($id = NULL)
    {
        $suppliers  = InvPoSupplier::all();
        //$gudangs    = InvInvPosInventori::all();
		$gudangs       = InvInvPosInventori::all()->sortBy('pos_nm');//->where('pos_root','');
        $types      = InvInvItemType::all();
        $principals = InvPoPrincipal::all();
        
        if ($id) {
            $units         = InvInvUnit::all();
            $pageFileName  = 'data';
            $defaultNo   = InvPoRetur::getDataCd(date('Y'), date('n'));

            if ($id == 'tambah') {
                $title   = 'Tambah Retur';
                $retur   = NULL;
                
                return view('inventori::' . $this->folder_path . '.' . $pageFileName, compact('title','gudangs', 'suppliers', 'principals', 'types', 'units', 'retur', 'defaultNo'));
            }else{
                $title   = 'Data Retur';
                $retur = InvPoRetur::find($id);
    
                if ($retur) {
                    return view('inventori::' . $this->folder_path . '.' . $pageFileName, compact('title','gudangs', 'suppliers', 'principals', 'types', 'units', 'retur', 'defaultNo'));
                }else{
                    return redirect('inventori/pembelian/purchase-order')->with('error', 'Retur Tidak Ditemukan!');
                }
            }
        }else{
            $pageFileName  = 'index';
            $title         = 'Retur';

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
            $data = InvPoRetur::select(
                "retur_cd",
                "retur_no",
                "po_retur.supplier_cd",
                "supplier.supplier_nm",
                //DB::Raw("fn_formatdatetime(po_retur.entry_date) as entry_date"),
				"po_retur.trx_date as trx_date",
                "note",
                "retur_st"
            )
			->where(function($where) use($request){
				if ($request->has('trx_date_param')) {
					$splitTanggal = explode("-",$request->trx_date_param);
					$tanggalStart = formatDate($splitTanggal[0]);
					$tanggalEnd   = formatDate($splitTanggal[1]);
		
					$where->whereRaw("trx_date::date between '$tanggalStart' and '$tanggalEnd'");
				}
			})
            ->leftJoin('inv.po_supplier as supplier','supplier.supplier_cd','po_retur.supplier_cd')
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
                ->addColumn('retur_st_nm',function($data){
                    switch ($data->retur_st) {
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
                ->rawColumns(['retur_st_nm','actions'])
                ->make(true);
        }else{
            $data = InvPoReturDetail::where('po_retur_detail.retur_cd', $request->id)
                    ->join('inv.po_retur as ret','ret.retur_cd','po_retur_detail.retur_cd')
                    ->leftJoin('inv.inv_item_master as item','item.item_cd','po_retur_detail.item_cd')
                    ->leftJoin('inv.inv_unit as unit','unit.unit_cd','item.unit_cd')
                    ->orderBy('trx_date','desc');

            return DataTables::of($data)
                ->addColumn('action',function($data){
                    if($data->retur_st == 'INV_TRX_ST_1'){
                        $actions = "<button type='button' id='hapus-item' class='btn btn-danger btn-flat btn-sm' data-toggle='tooltip' data-placement='top' title='Hapus Data'><i class='icon icon-trash'></i> </button>";
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
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('inventori::create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    function store(Request $request){
        $this->validate($request,[
            //retur_no'      => 'required',
            'supplier_cd'   => 'required',
        ]);

        $saveRetur = DB::transaction(function () use($request) {
			$trxDate = formatDate($request->trx_date);
			$defaultNo   = InvPoRetur::getDataCd(date("Y", strtotime($trxDate)), date("n", strtotime($trxDate)));
			
            $retur                    = new InvPoRetur;
            
			//$retur->retur_no          = $request->retur_no;
			if(!is_null($request->retur_no)){
                $retur->retur_no              = $request->retur_no;
            } else {
                $retur->retur_no              = $defaultNo;
            }
			
            $retur->supplier_cd       = $request->supplier_cd;
            $retur->principal_cd      = $request->principal_cd;
            
			$retur->trx_year           = date("Y", strtotime($trxDate));
            $retur->trx_month          = date("n", strtotime($trxDate));
            $retur->trx_date           = $trxDate;
            
			$retur->currency_cd       = $request->currency_cd;
            $retur->rate              = $request->rate;
            $retur->total_price       = $request->total_price;
            $retur->total_amount      = $request->total_amount;
            $retur->vat_tp            = $request->vat_tp;
            $retur->percent_ppn       = $request->percent_ppn;
            $retur->ppn               = $request->ppn;
            $retur->note              = $request->note;
            $retur->retur_st          = 'INV_TRX_ST_1';
            //$retur->entry_by          = Auth::user()->user_id;
			$retur->entry_by          = Auth::user()->user_nm;
            $retur->created_by        = Auth::user()->user_id;
            $retur->save();

            // $itemData   = InvInvPosItemUnit::query()->select(
            //                 DB::Raw("'$retur->inv_opname_id' as inv_opname_id"),
            //                 "inv_pos_itemunit.item_cd",
            //                 "inv_pos_itemunit.unit_cd",
            //                 "inv_pos_itemunit.quantity AS quantity_real",
            //                 "inv_pos_itemunit.quantity AS quantity_system",
            //                 DB::Raw("'$retur->created_by' as created_by"),
            //             )
            //             ->where(function ($query) use($request){
            //                 if($request->type_cd) $query->where('master.type_cd', $request->type_cd);
            //             })
            //             ->join('inv.inv_item_master as master','master.item_cd','inv_pos_itemunit.item_cd')
            //             ->orderBy('inv_pos_itemunit.item_cd')->get()->toArray();
            
            // $insert     = InvPoReceiveDetail::insert($itemData);
            return $retur->retur_cd;
        });

        return redirect('/inventori/pembelian/retur-item/'.$saveRetur);
    }

    /*
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function update(Request $request, $id){    
        $retur             = InvPoRetur::find($id);
        $retur->retur_st   = 'INV_TRX_ST_0';
        $retur->updated_by = Auth::user()->user_id;
        $retur->save();

        return response()->json(['status' => 'ok'],200); 
    }
	
	/**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function destroy($id){
        InvPoRetur::destroy($id);

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
            $retur                    = InvPoRetur::find($id);

            $returd                   = new InvPoReturDetail;
            $returd->retur_cd         = $id;
            $returd->item_cd          = $request->item_cd;
			
			$returd->item_desc     	  = $request->item_nm;
			//$returd->assettp_cd     = $request->assettp_cd;
            //$returd->assettp_desc   = $request->item_nm;
			
            $returd->unit_cd          = $request->unit_cd;
            $returd->quantity         = $request->quantity;
            $returd->unit_price       = $request->unit_price;
            $returd->trx_amount       = $request->trx_amount;
            $returd->faktur_no        = $request->faktur_no;
            $returd->faktur_date      = formatDate($request->faktur_date);
            $returd->note             = $request->note;
            $returd->created_by       = Auth::user()->user_id;
            $returd->save();

            $sumPoDetail    = InvPoReturDetail::where('retur_cd', $retur->retur_cd)->sum('trx_amount');
            
            $amountPpn      = $sumPoDetail * ($retur->percent_ppn/100);
            $sumPlusPpn     = $sumPoDetail + $amountPpn;

            $retur->total_price    = $sumPoDetail;
            $retur->total_amount   = $sumPlusPpn;
            $retur->ppn            = $amountPpn;
            $retur->updated_by     = Auth::user()->user_id;
            $retur->save();

            return $retur;
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

        $saveRD = DB::transaction(function () use($request, $id) {
            $returd                   = InvPoReturDetail::find($id);
            $returd->quantity         = $request->quantity;
            $returd->unit_price       = $request->unit_price;
            $returd->trx_amount       = $request->quantity * $request->unit_price;
            $returd->updated_by       = Auth::user()->user_id;
            $returd->save();

            // update tabel retur item
            $retur                	= InvPoRetur::find($returd->retur_cd);
			
			$sumReturDetail		  	= InvPoReturDetail::where('retur_cd', $retur->retur_cd)->sum('trx_amount');
			$retur->total_price		= $sumReturDetail;
			$retur->total_amount   	= $sumReturDetail;
            $retur->updated_by     	= Auth::user()->user_id;
            $retur->save();
            
            return $retur;
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
            $returd    = InvPoReturDetail::find($id);
            $returCd   = $returd->retur_cd;
            
            $returd    = InvPoReturDetail::destroy($id);

            $retur             = InvPoRetur::find($returCd);
            $sumPoDetail    = InvPoReturDetail::where('retur_cd', $retur->retur_cd)->sum('trx_amount');
            $amountPpn      = $sumPoDetail * ($retur->percent_ppn/100);
            $sumPlusPpn     = $sumPoDetail + $amountPpn;

            $retur->total_price    = $sumPoDetail;
            $retur->total_amount   = $sumPlusPpn;
            $retur->ppn            = $amountPpn;
            $retur->updated_by     = Auth::user()->user_id;
            $retur->save();

            return $retur;
        });

        return response()->json(['status' => 'ok', 'po' => $deletePod],200);
    }
    
    function getDataListFaktur(Request $request){
        $data   = DB::table(DB::Raw("inv.sp_inv_get_ri_detail('$request->supplier','supplier_cd')"));

        return DataTables::of($data)->make(true);
    }

    function print(Request $request)
    {
        $pageFileName  = 'cetak';
        $title         = 'Retur';
            
        $data   = DB::table(DB::Raw("inv.sp_inv_get_retur_detail('$request->id','retur_cd')"))->get();

        return view('inventori::' . $this->folder_path . '.' . $pageFileName, compact('title','data'));


        // return response()->json(['status' => 'ok', 'data'=> 'print'],200);
    }
}
