<?php

namespace Modules\Inventori\Http\Controllers\Setting;

use Illuminate\Http\Request;

use DB;
use Auth;
use DataTables;
use App\Http\Controllers\Controller;
use App\Models\InvInvItemKategori;

class KategoriController extends Controller{
    private $folder_path = 'setting.kategori';
    
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
        $title         = 'Data Kategori';

        return view('inventori::' . $this->folder_path . '.' . $filename_page, compact('title'));
    }

    /**
     * Display a listing of the resource for DataTables.
     *
     * @return \Illuminate\Http\Response
     */
    function getData(){
        $data = InvInvItemKategori::select('kategori_cd','kategori_nm');
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
            'kategori_cd' => 'required|unique:pgsql.inv.po_kategori|max:20',
            'kategori_nm' => 'required|max:255',
        ]);
        
        $kategori              = new InvInvItemKategori;
        $kategori->kategori_cd = $request->kategori_cd;
        $kategori->kategori_nm = $request->kategori_nm;
        $kategori->root_cd     = $request->root_cd;
        $kategori->type_cd     = $request->type_cd;
        $kategori->level_no    = $request->level_no;
        $kategori->created_by  = Auth::user()->user_id;
        $kategori->save();

        return response()->json(['status' => 'ok'],200); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function show($id){
        $kategori = InvInvItemKategori::find($id);

        if($kategori){
            return response()->json(['status' => 'ok', 'data' => $kategori],200);
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
            'kategori_nm' => 'required',
        ]);
        
        $kategori              = InvInvItemKategori::find($id);
        $kategori->kategori_cd = $request->kategori_cd;
        $kategori->kategori_nm = $request->kategori_nm;
        $kategori->root_cd     = $request->root_cd;
        $kategori->type_cd     = $request->type_cd;
        $kategori->level_no    = $request->level_no;
        $kategori->created_by  = Auth::user()->user_id;

        $kategori->save();

        return response()->json(['status' => 'ok'],200); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function destroy($id){
        InvInvItemKategori::destroy($id);

        return response()->json(['status' => 'ok'],200);
    }

     /**
     * Display a listing of the resource for select2.
     *
     * @return \Illuminate\Http\Response
     */
    function getListData(Request $request, $root=NULL){
        $searchParam = $request->get('term');
        $kategoris   = InvInvItemKategori::select("kategori_cd as id", "kategori_nm as text") 
                        ->where("kategori_nm", "ILIKE", "%$searchParam%")
                        ->whereRaw(DB::Raw("coalesce(root_cd,'') = '$root'"))
                        ->get();
                        
        return response()->json($kategoris);
    }
}
