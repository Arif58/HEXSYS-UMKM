<?php

namespace Modules\Inventori\Http\Controllers\Setting;

use Illuminate\Http\Request;

use DB;
use Auth;
use DataTables;
use App\Http\Controllers\Controller;
use App\Models\InvInvItemGolongan;

class GolonganController extends Controller{
    private $folder_path = 'setting.golongan';
    
    function __construct(){
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function index(){
        $filename_page = 'index';
        $title         = 'Data Golongan';

        return view('inventori::' . $this->folder_path . '.' . $filename_page, compact('title'));
    }

    /**
     * Display a listing of the resource for DataTables.
     *
     * @return \Illuminate\Http\Response
     */
    function getData(){
        $data = InvInvItemGolongan::select('golongan_cd','golongan_nm');
        return DataTables::of($data)->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    function store(Request $request){
        $this->validate($request,[
            'golongan_cd' => 'required|unique:pgsql.inv.po_golongan|max:20',
            'golongan_nm' => 'required|max:255',
        ]);
        
        $golongan              = new InvInvItemGolongan;
        $golongan->golongan_cd = $request->golongan_cd;
        $golongan->golongan_nm = $request->golongan_nm;
        $golongan->root_cd     = $request->root_cd;
        $golongan->type_cd     = $request->type_cd;
        $golongan->level_no    = $request->level_no;
        $golongan->created_by  = Auth::user()->user_id;
        $golongan->save();

        return response()->json(['status' => 'ok'],200); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function show($id){
        $golongan = InvInvItemGolongan::find($id);

        if($golongan){
            return response()->json(['status' => 'ok', 'data' => $golongan],200);
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
            'golongan_nm' => 'required',
        ]);
        
        $golongan              = InvInvItemGolongan::find($id);
        $golongan->golongan_cd = $request->golongan_cd;
        $golongan->golongan_nm = $request->golongan_nm;
        $golongan->root_cd     = $request->root_cd;
        $golongan->type_cd     = $request->type_cd;
        $golongan->level_no    = $request->level_no;
        $golongan->created_by  = Auth::user()->user_id;

        $golongan->save();

        return response()->json(['status' => 'ok'],200); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function destroy($id){
        InvInvItemGolongan::destroy($id);

        return response()->json(['status' => 'ok'],200);
    }

     /**
     * Display a listing of the resource for select2.
     *
     * @return \Illuminate\Http\Response
     */
    function getListData(Request $request, $root=NULL){
        $searchParam = $request->get('term');
        $golongans   = InvInvItemGolongan::select(
                            "golongan_cd as id", 
                            DB::Raw("case when root_cd is null then golongan_nm else concat('    ',golongan_nm) end as text") 
                        ) 
                        ->where("golongan_nm", "ILIKE", "%$searchParam%")
                        ->whereRaw("coalesce(root_cd,'') = '$root'")
                        ->orderBy('golongan_cd')
                        ->get();

        return response()->json($golongans);
    }
}
