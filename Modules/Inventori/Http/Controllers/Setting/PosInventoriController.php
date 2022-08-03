<?php

namespace Modules\Inventori\Http\Controllers\Setting;

use Illuminate\Http\Request;

use Auth;
use DataTables;
use App\Http\Controllers\Controller;
use App\Models\InvInvPosInventori;

class PosInventoriController extends Controller{
    private $folder_path = 'setting.pos-inventori';
    
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
        $title         = 'Data UMKM';
        
        return view('inventori::' . $this->folder_path . '.' . $filename_page, compact('title'));
    }

    /**
     * Display a listing of the resource for DataTables.
     *
     * @return \Illuminate\Http\Response
     */
    function getData(){
        $data = InvInvPosInventori::select('pos_cd','pos_nm','description','postrx_st');
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
            //'pos_cd' => 'required|unique:pgsql.inv.inv_pos_inventori|max:20',
            'pos_nm' => 'required|max:255',
        ]);
        
        $pos            = new InvInvPosInventori;
        //$pos->pos_cd    = strtoupper($request->pos_cd);
		$pos->pos_cd 	= InvInvPosInventori::getPosCd();
        $pos->pos_nm    = $request->pos_nm;
        $pos->description   = $request->description;
        if($request->checkbox_transaksi == 'on'){
            $pos->postrx_st = '1';
        } else {
			$pos->postrx_st = '0';
		}
        $pos->created_by= Auth::user()->user_id;
        $pos->save();

        return response()->json(['status' => 'ok'],200); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function show($id){
        $pos = InvInvPosInventori::find($id);

        if($pos){
            return response()->json(['status' => 'ok', 'data' => $pos],200);
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
            'pos_nm' => 'required',
        ]);
        
        $pos = InvInvPosInventori::find($id);
        $pos->pos_cd     = $request->pos_cd;
        $pos->pos_nm     = $request->pos_nm;
        $pos->description   = $request->description;
        if($request->checkbox_transaksi == 'on'){
            $pos->postrx_st = '1';
        } else {
			$pos->postrx_st = '0';
		}
        $pos->updated_by = Auth::user()->user_id;

        $pos->save();

        return response()->json(['status' => 'ok'],200); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function destroy($id){
        InvInvPosInventori::destroy($id);

        return response()->json(['status' => 'ok'],200);
    }

     /**
     * Display a listing of the resource for select2.
     *
     * @return \Illuminate\Http\Response
     */
    function getListData(Request $request){
        $searchParam = $request->get('term');
        $poss       = InvInvPosInventori::select("pos_cd as id", "pos_nm as text") 
                        ->where("pos_nm", "ILIKE", "%$searchParam%")
                        ->get()
                        ->toArray();

        array_unshift($poss,array('id' => '','text'=>'=== Pilih Pos Inventori ==='));
        return response()->json($poss);
    }
}
