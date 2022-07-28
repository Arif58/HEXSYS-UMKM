<?php

namespace Modules\Inventori\Http\Controllers;

use DB;
use Auth;
use DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\InvInvPosItemUnit;
use App\Models\InvInvItemType;
use App\Models\InvInvUnit;
use App\Models\InvInvOpname;
use App\Models\InvInvOpnameDetail;
use App\Models\InvInvPosInventori;

class StockOpnameController extends Controller{
    private $folder_path = 'stock-opname';
    
    function __construct(){
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function index($id = NULL){
        $gudangs       = InvInvPosInventori::all()->sortBy('pos_nm');//->where('pos_root','');
        $types         = InvInvItemType::all();
        
        if ($id) {
            $units         = InvInvUnit::all();
            $pageFileName  = 'data';

            if ($id == 'tambah') {
                $title  = 'Tambah Stock Opname';
                $opname = NULL;
                return view('inventori::' . $this->folder_path . '.' . $pageFileName, compact('title','gudangs', 'types', 'units', 'opname'));
            }else{
                $title         = 'Data Stock Opname';
                $opname        = InvInvOpname::select("*",
                                DB::Raw("fn_formatdate(date_start) date_start"),
                                DB::Raw("fn_formatdate(date_end) date_end"),
                                DB::Raw("fn_formatdatetime(inv_opname.created_at) as datetime_trx"), 
                                )->find($id);
    
                if ($opname) {
                    return view('inventori::' . $this->folder_path . '.' . $pageFileName, compact('title','gudangs', 'types', 'units', 'opname'));
                }else{
                    return redirect('inventori/stock-opname')->with('error', 'Stock Opname Tidak Ditemukan!');
                }
            }
        }else{
            $pageFileName  = 'index';
            $title         = 'Stock Opname';

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
            $data = InvInvOpname::select(
                "inv_opname_id",
                "inv_opname.pos_cd",
                "pos.pos_nm",
                DB::Raw("fn_formatdate(date_start) date_start"),
                DB::Raw("fn_formatdate(date_end) date_end"),
                DB::Raw("fn_formatdatetime(inv_opname.created_at) as datetime_trx"), 
                "note",
                "trx_st"
            )
            ->leftJoin('inv.inv_pos_inventori as pos','pos.pos_cd','inv_opname.pos_cd')
            ;

            return DataTables::of($data)
                ->addColumn('trx_st_nm',function($data){
                    if ($data->trx_st == '0') {
                        return '<span class="badge badge-danger badge-icon"><i class="icon icon-exclamation"></i> Belum Selesai</span>';
                    }else{
                        return '<span class="badge badge-success badge-icon"><i class="icon icon-task"></i> Sudah Selesai</span>';
                    }
                })
                ->rawColumns(['trx_st_nm'])
                ->make(true);
        }else{
            $data = InvInvOpnameDetail::where('inv_opname_id', $request->id)
                ->select(
                    "inv_opname_detail_id",
                    "inv_opname_detail.item_cd",
                    "master.item_nm",
                    "inv_opname_detail.unit_cd",
                    "unit.unit_nm",
                    "inv_opname_detail.quantity_system",
                    "inv_opname_detail.quantity_real",
                    DB::Raw("case when inv_opname_detail.quantity_system = inv_opname_detail.quantity_real then '1' else '0' end as order_st"),
                )
                ->join('inv.inv_item_master as master', 'master.item_cd','inv_opname_detail.item_cd')
                ->join('inv.inv_unit as unit', 'unit.unit_cd','inv_opname_detail.unit_cd')
                ;

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
            'pos_cd'     => 'required',
            'date_range' => 'required',
        ]);

        $saveOpname = DB::transaction(function () use($request) {
            $tanggal            = explode('-',$request->date_range);

            $opname             = new InvInvOpname;
            $opname->trx_no     = $request->trx_no;
            $opname->trx_nm     = $request->trx_nm;
            $opname->trx_year   = $request->trx_year;
            $opname->trx_month  = $request->trx_month;
            $opname->pos_cd     = $request->pos_cd;
            $opname->date_start = formatDate($tanggal[0]);
            $opname->date_end   = formatDate($tanggal[1]);
            $opname->note       = $request->note;
            $opname->created_by = Auth::user()->user_id;
            $opname->save();

            $itemData   = InvInvPosItemUnit::query()->select(
                            DB::Raw("'$opname->inv_opname_id' as inv_opname_id"),
                            "inv_pos_itemunit.item_cd",
                            "inv_pos_itemunit.unit_cd",
                            "inv_pos_itemunit.quantity AS quantity_real",
                            "inv_pos_itemunit.quantity AS quantity_system",
                            DB::Raw("'$opname->created_by' as created_by"),
                        )
                        ->where(function ($query) use($request){
                            if($request->type_cd) $query->where('master.type_cd', $request->type_cd);
                        })
                        ->where(function ($query) use($request){
                            if($request->pos_cd) $query->where('inv_pos_itemunit.pos_cd', $request->pos_cd);
                        })
                        ->join('inv.inv_item_master as master','master.item_cd','inv_pos_itemunit.item_cd')
                        ->orderBy('inv_pos_itemunit.item_cd')->get()->toArray();
            
            $insert = InvInvOpnameDetail::insert($itemData);
            return $opname->inv_opname_id;
        });

        return redirect('/inventori/stock-opname/'.$saveOpname);
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
            'quantity_real'=> 'required',
        ]);

        $opDetail                 = InvInvOpnameDetail::find($id);
        $opDetail->quantity_real  = $request->quantity_real;
        $opDetail->updated_by     = Auth::user()->user_id;
        $opDetail->save();

        return response()->json(['status' => 'ok'],200); 
    }

    /*
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function update(Request $request, $id){    
        $opname             = InvInvOpname::find($id);
        $opname->trx_st     = '1';
        $opname->updated_by = Auth::user()->user_id;
        $opname->save();

        $opnameDetail       = InvInvOpnameDetail::where('inv_opname_id',$id)->get();
        foreach($opnameDetail as $detail){
            $newStock = InvInvPosItemUnit::where('pos_cd',$opname->pos_cd)
                ->where('item_cd',$detail->item_cd)
                ->where('unit_cd',$detail->unit_cd)
                ->firstOrFail();
            $newStock->quantity = $detail->quantity_real;
            $newStock->save();
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
        InvInvOpname::destroy($id);

        return response()->json(['status' => 'ok'],200);
    }

    function print(Request $request)
    {
        return response()->json(['status' => 'ok', 'data'=> 'print'],200);
    }
}
