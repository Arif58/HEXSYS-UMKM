<?php

namespace Modules\Inventori\Http\Controllers\Setting;

use Illuminate\Http\Request;

use Auth;
use DataTables;
use App\Http\Controllers\Controller;
use App\Models\InvPoPrincipal;

class PrincipalController extends Controller{
    private $folder_path = 'setting.principal';
    
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
        $title         = 'Data Principal';

        return view('inventori::' . $this->folder_path . '.' . $filename_page, compact('title'));
    }

    /**
     * Display a listing of the resource for DataTables.
     *
     * @return \Illuminate\Http\Response
     */
    function getData(){
        $data = InvPoPrincipal::select('principal_cd','principal_nm');
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
            'principal_cd' => 'required|unique:pgsql.inv.po_principal|max:20',
            'principal_nm' => 'required|max:255',
        ]);
        
        $principal               = new InvPoPrincipal;
        $principal->principal_cd = strtoupper($request->principal_cd);
        $principal->principal_nm = $request->principal_nm;
        $principal->created_by   = Auth::user()->user_id;
        $principal->save();

        return response()->json(['status' => 'ok'],200); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function show($id){
        $principal = InvPoPrincipal::find($id);

        if($principal){
            return response()->json(['status' => 'ok', 'data' => $principal],200);
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
            'principal_nm' => 'required',
        ]);
        
        $principal               = InvPoPrincipal::find($id);
        $principal->principal_cd = $request->principal_cd;
        $principal->principal_nm = $request->principal_nm;
        $principal->created_by   = Auth::user()->user_id;

        $principal->save();

        return response()->json(['status' => 'ok'],200); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function destroy($id){
        InvPoPrincipal::destroy($id);

        return response()->json(['status' => 'ok'],200);
    }

     /**
     * Display a listing of the resource for select2.
     *
     * @return \Illuminate\Http\Response
     */
    function getListData(Request $request){
        $searchParam = $request->get('term');
        $principals  = InvPoPrincipal::select("principal_cd as id", "principal_nm as text") 
                        ->where("principal_nm", "ILIKE", "%$searchParam%")
                        ->get()
                        ->toArray();

        array_unshift($principals,array('id' => '','text'=>'=== Pilih Pos Inventori ==='));
        return response()->json($principals);
    }
}
