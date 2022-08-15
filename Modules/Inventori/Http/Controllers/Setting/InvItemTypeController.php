<?php

namespace Modules\Inventori\Http\Controllers\Setting;

use Illuminate\Http\Request;

use Auth;
use DataTables;
use App\Http\Controllers\Controller;
use App\Models\InvInvItemType;

class InvItemTypeController extends Controller{
    private $folder_path = 'setting.item-type';

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
        $title = 'Data Jenis Inventori';

        return view('inventori::' . $this->folder_path . '.' . $filename_page, compact('title'));
    }

    /**
     * Display a listing of the resource for DataTables.
     *
     * @return \Illuminate\Http\Response
     */
    function getData(){
        $pos = Auth::user()->unit_cd;
        if($pos != null) {
            $data = InvInvItemType::select('type_cd','type_nm')->where('pos_cd', $pos);
            return DataTables::of($data)->make(true);
        } else {
            $data = InvInvItemType::select('type_cd','type_nm');
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
            'type_cd' => 'required|unique:pgsql.inv.inv_item_type|max:20',
            'type_nm' => 'required|max:255',
        ]);

        $type             = new InvInvItemType;
        $type->type_cd    = strtoupper($request->type_cd);
        $type->type_nm    = $request->type_nm;
        $type->pos_cd     = Auth::user()->unit_cd;
        $type->created_by = Auth::user()->user_id;
        $type->save();

        return response()->json(['status' => 'ok'],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function show($id){
        $type = InvInvItemType::find($id);

        if($type){
            return response()->json(['status' => 'ok', 'data' => $type],200);
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
            'type_nm' => 'required',
        ]);

        $type = InvInvItemType::find($id);
        $type->type_cd    = $request->type_cd;
        $type->type_nm    = $request->type_nm;
        $type->pos_cd = Auth::user()->unit_cd;
        $type->created_by = Auth::user()->user_id;

        $type->save();

        return response()->json(['status' => 'ok'],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function destroy($id){
        InvInvItemType::destroy($id);

        return response()->json(['status' => 'ok'],200);
    }

     /**
     * Display a listing of the resource for select2.
     *
     * @return \Illuminate\Http\Response
     */
    function getListData(Request $request){
        $searchParam = $request->get('term');
        $types       = InvInvItemType::select("type_cd as id", "type_nm as text")
                        ->where("type_nm", "ILIKE", "%$searchParam%")
                        ->get()
                        ->toArray();

        array_unshift($types,array('id' => '','text'=>'=== Pilih Satuan ==='));
        return response()->json($types);
    }
}
