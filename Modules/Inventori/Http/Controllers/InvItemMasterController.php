<?php

namespace Modules\Inventori\Http\Controllers;

use DB;
use Auth;
use DataTables;
use App\Models\AuthRole;
use App\Models\InvInvUnit;
use Illuminate\Support\Str;

use Illuminate\Http\Request;
use App\Models\InvInvFormula;
use App\Models\InvInvItemType;
use App\Models\InvInvItemUnit;
use App\Models\InvPoPrincipal;
use App\Models\InvTrxTipeAset;
use App\Models\InvInvItemMaster;
use App\Models\InvInvFormulaItem;
use App\Models\InvInvPosItemUnit;
use App\Models\InvInvPosInventori;
use App\Models\InvVwStockInventory;
use App\Http\Controllers\Controller;
use App\Models\InvVwItemMultiSatuan;

class InvItemMasterController extends Controller{
    private $folder_path = 'inv-item-master';

    function __construct(){
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	function index(){
        $pageFileName  = 'index';
        $title         = 'Data Inventori';
        $units         = InvInvUnit::all(['unit_cd','unit_nm']);
        $types         = InvInvItemType::all(['type_cd','type_nm']);
        $roots         = InvInvItemMaster::all(['item_cd','item_nm']);
        $principals    = InvPoPrincipal::all(['principal_cd','principal_nm']);
        $roles      = AuthRole::getAllRoles(Auth::user()->role->role_cd);
        
		//$formulas      = InvInvFormula::all(['formula_cd','formula_nm']);
		$formulas    	= InvInvItemMaster::select(
							'item_cd as formula_cd',
							'item_nm as formula_nm'
							)
							->orderBy('item_nm', 'asc')
							->get();
							
        //$item_cd       = Str::random(8);
		//$item_cd       = '';
		$item_cd       = InvInvItemMaster::getItemCd();
        $pos = Auth::user()->unit_cd;
        if ($pos != NULL){
            $types = InvInvItemType::select(['type_cd','type_nm'])->where('pos_cd', $pos)->get();
        } else {   
            $types = InvInvItemType::all(['type_cd','type_nm']);
        }

        return view('inventori::' . $this->folder_path . '.' . $pageFileName, compact('title','roles','units','types','roots','principals','item_cd','formulas'));
    
    }

    function detail($id){
        $pageName       = 'detail';
        $title          = 'Detail Inventori';
        $units          = InvInvUnit::all(['unit_cd','unit_nm']);
        $types          = InvInvItemType::all(['type_cd','type_nm']);
        $dataInventori  = InvInvItemMaster::select(
                            "inv_item_master.item_cd",
                            "inv_item_master.item_nm",
                            "inv_item_master.unit_cd",
                            "unit.unit_nm",
                            "inv_item_master.type_cd",
                            "type.type_nm",
                            "item_price",
                            "item_price_buy",
                            "inv_item_master.image",
                            "inv_item_master.ppn",
                            "inv_item_master.vat_tp",
                            "inv_item_master.maximum_stock",
                            "inv_item_master.minimum_stock",
                            "inv_item_master.golongan_cd",
                            "golongan.golongan_nm",
                            "inv_item_master.kategori_cd",
                            "kategori.kategori_nm",
                            "inv_item_master.dosis"
                        )
                        ->join('inv.inv_item_type as type','type.type_cd','=','inv_item_master.type_cd')
                        ->join('inv.inv_unit as unit','unit.unit_cd','=','inv_item_master.unit_cd')
                        ->leftJoin('inv.inv_item_golongan as golongan','golongan.golongan_cd','=','inv_item_master.golongan_cd')
                        ->leftJoin('inv.inv_item_kategori as kategori','kategori.kategori_cd','=','inv_item_master.kategori_cd')
                        ->where('item_cd', $id)
                        ->first();

        return view('inventori::' . $this->folder_path . '.' . $pageName, compact('title', 'dataInventori','units','types'));
    }

	function getDataList(Request $request, $id=NULL){
		$searchParam = $request->get('term');

        $data	= InvInvItemMaster::select(
					"item_cd as id",
					DB::Raw("concat(item_cd,' - ',item_nm) as text"),
					DB::Raw("unit_cd"),
					DB::Raw("item_price_buy")
				)
				->orderBy('item_nm')
				->where("item_nm", "ILIKE", "%$searchParam%")
				->get()
				->toArray();

        array_unshift($data,array('id' => '','text'=>'=== Pilih Item ===', 'disabled' => TRUE));
        return response()->json($data);
    }

	function getTipeAset(Request $request, $id=NULL){
		$searchParam = $request->get('term');

        $data	= InvTrxTipeAset::select(
					"asettp_cd as id",
					DB::Raw("concat(asettp_cd,' - ',asettp_nm) as text")
				)
				->orderBy('asettp_cd')
				->where("asettp_nm", "ILIKE", "%$searchParam%")
				->get()
				->toArray();

        array_unshift($data,array('id' => '','text'=>'=== Pilih Item ===', 'disabled' => TRUE));
        return response()->json($data);
    }

	function getSatuanList(Request $request, $id=NULL){
		$searchParam = $request->get('term');

        $data	= InvInvUnit::select(
					"unit_cd as id",
					"unit_nm as text",
				)
				->orderBy('unit_nm')
				->where("unit_nm", "ILIKE", "%$searchParam%")
				->get()
				->toArray();

        array_unshift($data,array('id' => '','text'=>'=== Pilih Item ===', 'disabled' => TRUE));
        return response()->json($data);
    }

    /**
     * Display a listing of the resource for DataTables.
     *
     * @return \Illuminate\Http\Response
     */
    function getData(){
        $pos = Auth::user()->unit_cd;
        // if ($pos != NULL){
        //     $types = InvInvItemType::select(['type_cd','type_nm'])->where('pos_cd', $pos)->get();
        // } else {   
        //     $types = InvInvItemType::all(['type_cd','type_nm']);
        // }
        if ($pos != null){
            $data = InvInvItemMaster::getAllData()->where('inv_item_master.pos_cd', $pos);
            return DataTables::of($data)->make(true);
        } else {
            $data = InvInvItemMaster::getAllData();
            return DataTables::of($data)->make(true);
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
            'item_cd'       => 'required|unique:pgsql.inv.inv_item_master|max:100',
            'item_nm'       => 'required|max:255',
            //'type_cd'       => 'required',
            'unit_cd'       => 'required',
            //'item_price'    => 'required',
            //'item_price_buy'=> 'required',
            'minimum_stock' => 'required',
            //'maximum_stock' => 'required'
        ]);

		DB::beginTransaction();
        DB::transaction(function () use($request) {

            $item                 = new InvInvItemMaster;
            //$item->item_cd        = strtoupper(str_replace(' ','',$request->item_cd));
			$item->item_cd        = strtoupper(str_replace(' ','',InvInvItemMaster::getItemCd()));
            $item->item_nm        = $request->item_nm;
            $item->item_root      = $request->item_root;
            $item->map_value      = $request->map_value;
            $item->type_cd        = $request->type_cd;
            $item->unit_cd        = $request->unit_cd;
            //$item->item_price     = uang($request->item_price);
            $item->item_price_buy = empty($request->item_price_buy) ? 0 : uang($request->item_price_buy);
            $item->minimum_stock  = uang($request->minimum_stock);
            //$item->maximum_stock  = uang($request->maximum_stock);
            $item->vat_tp         = $request->vat_tp;
            $item->kategori_cd    = $request->kategori_cd;
            $item->golongan_cd    = $request->golongan_cd;
            $item->golongansub_cd    = $request->golongansub_cd;
            $item->ppn            = uang($request->ppn);
            //$item->dosis          = uang($request->dosis);
            //$item->principal_cd   = $request->principal_cd;
            if($request->checkbox_inventori == 'on'){
                $item->inventory_st   = '1';
            } else {
                $item->inventory_st   = '0';
            }
            /*if($request->checkbox_generik == 'on'){
                $item->generic_st   = '1';
            }*/
            $item->pos_cd = Auth::user()->unit_cd;
            $item->created_by     = Auth::user()->user_id;
            $item->save();

			//--insert spesifik tipe inventori to spesifik warehouse
            // switch ($request->type_cd) {
            //     case 'TPXXX':
            //         $pos = InvInvPosInventori::where('pos_cd',configuration('WHXXX'))->get();
            //         break;
            //     case 'TPXXX':
            //         $pos = InvInvPosInventori::where('pos_cd',configuration('WHXXX'))->get();
            //         break;
            //     default:
			// 		//$pos = InvInvPosInventori::whereNotIn('pos_cd',[configuration('WHXXX'),configuration('WHXXX')])->get();
            //         $pos = InvInvPosInventori::where('pos_cd',configuration('WHPOS_TRX'))->get();
            //         break;
            // }
			
			if (Auth::user()->unit_cd != null) {
            // foreach ($pos as $wh) {
                $posItemUnit = new InvInvPosItemUnit;
                //$posItemUnit->item_cd    = strtoupper(str_replace(' ','',$request->item_cd));
				$posItemUnit->item_cd    = $item->item_cd;
                // $posItemUnit->pos_cd     = $wh->pos_cd;
                $posItemUnit->pos_cd     = Auth::user()->unit_cd;
                $posItemUnit->unit_cd    = $request->unit_cd;
                $posItemUnit->quantity   = 0;
                $posItemUnit->created_by = Auth::user()->user_id;
                $posItemUnit->save();
            // }
			}
        });
		DB::commit();

        return response()->json(['status' => 'ok'],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function show($id){
        $data = InvInvItemMaster::select(
            "inv_item_master.item_cd",
            "inv_item_master.item_nm",
            "inv_item_master.unit_cd",
            "unit.unit_nm",
            "inv_item_master.type_cd",
            "type.type_nm",
            "item_price",
            "item_price_buy",
            "inv_item_master.image",
            "inv_item_master.ppn",
            "inv_item_master.vat_tp",
            "inv_item_master.maximum_stock",
            "inv_item_master.minimum_stock",
            "inv_item_master.golongan_cd",
            "golongan.golongan_nm",
            "inv_item_master.kategori_cd",
            "kategori.kategori_nm"
        )
        ->join('inv.inv_item_type as type','type.type_cd','=','inv_item_master.type_cd')
        ->join('inv.inv_unit as unit','unit.unit_cd','=','inv_item_master.unit_cd')
        ->leftJoin('inv.inv_item_golongan as golongan','golongan.golongan_cd','=','inv_item_master.golongan_cd')
        ->leftJoin('inv.inv_item_kategori as kategori','kategori.kategori_cd','=','inv_item_master.kategori_cd')
        ->where('inv_item_master.item_cd', $id)
        ->first();

        if($data){
            return response()->json(['status' => 'ok', 'data' => $data],200);
        }else{
            return response()->json(['status' => 'failed', 'data' => 'not found'],200);
        }
    }

    /*
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function update(Request $request, $id){
        $this->validate($request,[
            'item_nm'        => 'required',
            //'type_cd'        => 'required',
            'unit_cd'        => 'required',
            //'item_price'     => 'required',
            //'item_price_buy' => 'required',
        ]);

        $item                 	= InvInvItemMaster::find($id);

		//--Update satuan pos
		$unitOld = $item->unit_cd;
		DB::table('inv.inv_pos_itemunit')
		->where('item_cd',$id)
		->where('unit_cd',$unitOld)
		->update(['unit_cd' => $request->unit_cd]);
		//--End Update satuan pos

        $item->item_nm        	= $request->item_nm;
        $item->type_cd        	= $request->type_cd;
        $item->unit_cd        	= $request->unit_cd;
        //$item->item_price     = uang($request->item_price);
        $item->item_price_buy 	= empty($request->item_price_buy) ? 0 : uang($request->item_price_buy);
        $item->minimum_stock  	= uang($request->minimum_stock);
        //$item->maximum_stock  = uang($request->maximum_stock);
        $item->vat_tp         	= $request->vat_tp;
        $item->kategori_cd    	= ($request->kategori_cd=='null') ? NULL : $request->kategori_cd;
        $item->golongan_cd    	= ($request->golongan_cd=='null') ? NULL : $request->golongan_cd;
        //$item->dosis          = $request->dosis;
        $item->ppn            	= uang($request->ppn);
        if($request->checkbox_inventori == 'on'){
            $item->inventory_st	= '1';
        } else {
            $item->inventory_st	= '0';
        }
        /*if($request->checkbox_generik == 'on'){
            $item->generic_st	= '1';
        } else {
            $item->generic_st   = '0';
        }*/
        $item->pos_cd = Auth::user()->unit_cd;
        $item->updated_by     	= Auth::user()->user_id;

        $item->save();

        return response()->json(['status' => 'ok'],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function destroy($id){
        InvInvItemMaster::destroy($id);

        return response()->json(['status' => 'ok'],200);
    }

    /*
     * Update the specified image produk resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    function updateImage(Request $request, $id){
        $item = InvInvItemMaster::find($id);

        $item->image = $request->image;

        $item->save();

        return response()->json(['status' => 'ok'],200);
    }

    /**
     * Display a listing of the resource for select2.
     *
     * @return \Illuminate\Http\Response
     */
    function getListData(Request $request){
        $paramString = $request->get('term');

        $data        = InvInvItemMaster::select(
                            "inv_item_master.item_cd as id",
                            "item_nm as text",
                            "unit_cd",
                            "item_price",
                            "item_price_buy",
                            "dosis"
                    )
                    ->where("item_nm", "ILIKE", "%$paramString%")
                    ->get();

        return response()->json($data);
    }

    /**
     * store new record multi satuan item
     * @return Response
     */
    function storeSatuan(Request $request){
        $this->validate($request,[
            'satuan_item_cd'       => 'required',
            'unit_cd_satuan'       => 'required',
            'satuan_conversion'    => 'required',
        ]);
        DB::transaction(function () use($request) {
            $itemUnit = new InvInvItemUnit;
            $itemUnit->item_cd = $request->satuan_item_cd;
            $itemUnit->unit_cd = $request->unit_cd_satuan;
            $itemUnit->conversion = $request->satuan_conversion;
            $itemUnit->save();

            $posItemUnit = new InvInvPosItemUnit;
            $posItemUnit->item_cd = $request->satuan_item_cd;
            $posItemUnit->unit_cd = $request->unit_cd_satuan;
            // $posItemUnit->pos_cd = configuration('WHPOS_TRX'); //--default/gudang utama
            $posItemUnit->pos_cd =  Auth::user()->unit_cd;
            $posItemUnit->quantity = 0;
            $posItemUnit->save();
        });

        return response()->json(['status' => 'ok'],200);
    }

    /**
     * get datatable multi satuan item
     * @return Response
     */
    function getDataSatuan(Request $request){
        $data = InvVwItemMultiSatuan::where('item_cd',$request->item_cd)->get();

        return DataTables::of($data)
        ->addColumn('action', function($data){
            return "<button type='button' id='hapus-satuan' class='btn btn-danger ml-3 legitRipple'>Hapus <i class='icon-bin ml-2'></i></button>";
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    /**
     * remove multi satuan record
     * @return Response
     */
    function deleteSatuan(Request $request){
        $this->validate($request,[
            'unit_item_cd'  => 'required',
            'item_cd'       => 'required',
        ]);
        DB::transaction(function () use($request) {
            $itemUnit = InvInvItemUnit::where('item_cd',$request->item_cd)->where('unit_cd',$request->unit_item_cd)->firstOrFail();
            $itemUnit->delete();

            $posItemUnit = InvInvPosItemUnit::where('item_cd',$request->item_cd)->where('unit_cd',$request->unit_item_cd)->firstOrFail();
            $posItemUnit->delete();
        });
        return response()->json(['status' => 'ok'],200);
    }

    /**
     * cek data satuan
     */
    function cekSatuan(Request $request){
        $this->validate($request,[
            'item_cd'  => 'required',
            'unit_cd'  => 'required',
        ]);

        //cek satuan
        $satuan = InvVwItemMultiSatuan::where('item_cd',$request->item_cd)
                    ->where('unit_item_cd',$request->unit_cd)
                    ->first();
        if($satuan){
            $tipe = 'satuan';
            $conversion = $satuan->konversi;
            return response()->json(['status' => 'ok','message' => $conversion, 'tipe' => $tipe],200);
        } else {
            return response()->json(['status' => 'error','message' => 'Bukan merupakan konversi satuan'],200);
        }
    }

    /**
     * get datatable formula item
     * @return Response
     */
    function getDataFormula(Request $request){
        //$data = InvInvFormulaItem::where('item_cd',$request->item_cd)->get();
		
		$data = InvInvFormulaItem::select(
				'inv_formula_item.formula_item_id',
				'inv_formula_item.formula_cd',
				'inv_formula_item.content',
				'inv_formula_item.unit_cd',
				'item.item_nm',
				'item.unit_cd as item_unit'
				)
				->join('inv.inv_item_master as item','item.item_cd','inv_formula_item.formula_cd')
				->where('inv_formula_item.item_cd',$request->item_cd)
				->get();
		
        return DataTables::of($data)
        ->addColumn('action', function($data){
            return "<button type='button' id='hapus-formula' class='btn btn-danger ml-3 legitRipple'><i class='icon-bin ml-2'></i></button>";
        })
        ->rawColumns(['action'])
        ->make(true);
    }
    /**
     * store new record formula item
     * @return Response
     */
    function storeFormula(Request $request){
        $this->validate($request,[
            'formula_item_cd'   => 'required',
            'formula_cd'        => 'required',
            //'formula_content'           => 'required',
            //'formula_unit_cd'           => 'required',
        ]);
        DB::transaction(function () use($request) {
            $formulaItem = new InvInvFormulaItem;
            $formulaItem->formula_cd = $request->formula_cd;
            $formulaItem->item_cd = $request->formula_item_cd;
            $formulaItem->content = $request->formula_content;
            $formulaItem->unit_cd = $request->formula_unit_cd;
            if($request->checkbox_formula == 'on'){
                $formulaItem->main_st     = '1';
            }
            $formulaItem->save();
        });

        return response()->json(['status' => 'ok'],200);
    }
    /**
     * remove formula item records
     * @return Response
     */
    function deleteFormula(Request $request){
        $this->validate($request,[
            'formula_item_id'  => 'required',
        ]);
        DB::transaction(function () use($request) {
            $formulaItem = InvInvFormulaItem::destroy($request->formula_item_id);
        });
        return response()->json(['status' => 'ok'],200);
    }
}
