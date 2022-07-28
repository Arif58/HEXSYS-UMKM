<?php

namespace Modules\Inventori\Http\Controllers\Setting;

use Illuminate\Http\Request;

use Auth;
use DataTables;
use App\Http\Controllers\Controller;
use App\Models\InvInvUnit;

class InvUnitController extends Controller{
    private $folder_path = 'setting.unit';
    
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
        $title         = 'Data Satuan Inventori';

        return view('inventori::' . $this->folder_path . '.' . $filename_page, compact('title'));
    }

    /**
     * Display a listing of the resource for DataTables.
     *
     * @return \Illuminate\Http\Response
     */
    function getData(){
        $data = InvInvUnit::select('unit_cd','unit_nm');
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
            'unit_cd' => 'required|unique:pgsql.inv.inv_unit|max:20',
            'unit_nm' => 'required|max:255',
        ]);
        
        $unit             = new InvInvUnit;
        $unit->unit_cd    = strtoupper($request->unit_cd);
        $unit->unit_nm    = $request->unit_nm;
        $unit->created_by = Auth::user()->user_id;
        $unit->save();

        return response()->json(['status' => 'ok'],200); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function show($id){
        $unit = InvInvUnit::find($id);

        if($unit){
            return response()->json(['status' => 'ok', 'data' => $unit],200);
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
            'unit_nm' => 'required',
        ]);
        
        $unit = InvInvUnit::find($id);
        $unit->unit_cd    = $request->unit_cd;
        $unit->unit_nm    = $request->unit_nm;
        $unit->created_by = Auth::user()->user_id;

        $unit->save();

        return response()->json(['status' => 'ok'],200); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function destroy($id){
        InvInvUnit::destroy($id);

        return response()->json(['status' => 'ok'],200);
    }

    /**
     * Display a listing of the resource for select2.
     *
     * @return \Illuminate\Http\Response
     */
    function getListData(Request $request){
        $searchParam = $request->get('term');
        $units       = InvInvUnit::select("unit_cd as id", "unit_nm as text") 
                        ->where("unit_nm", "ILIKE", "%$searchParam%")
                        ->get()
                        ->toArray();

        array_unshift($units,array('id' => '','text'=>'=== Pilih Satuan ==='));
        return response()->json($units);
    }
}
