<?php

namespace App\Http\Controllers\Admin;

use DB;
use Auth;
use Datatables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PublicComNation;

class NationController extends Controller{
    private $folder_path = 'nation';
    
    function __construct(){
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function index($id = NULL){
        $filename_page  = 'index';
        $judul          = 'Kelola Data Negara';
        $root           = $id;

        return view('datamaster::' . $this->folder_path . '.' . $filename_page, compact('judul', 'root'));
    }

    /**
     * Display a listing of the resource for datatables.
     *
     * @return \Illuminate\Http\Response
     */
    function getData(Request $request){
        $data   = PublicComNation::select('nation_cd','nation_nm','capital');

        return Datatables::of($data)->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    function store(Request $request){
        $this->validate($request,[
            'nation_cd' => 'required|unique:com_nation',
            'nation_nm' => 'required',
            'capital'   => 'nullable',
        ]);
        
        $nation = PublicComNation::create([
            'nation_cd'  => $request->nation_cd,
            'nation_nm'  => $request->nation_nm,
            'capital'    => $request->capital,
            'created_by' => Auth::user()->user_id
        ]);

        return response()->json(['status' => 'ok'],200); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function show($id){
        $nation = PublicComNation::find($id);

        if($nation){
            return response()->json(['status' => 'ok', 'data' => $nation],200);
        }else{
            return response()->json(['status' => 'failed', 'data' => 'not found'],200);
        }
    }

     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function update(Request $request, $id){
        $this->validate($request,[
            'nation_nm'=> 'required',
            'capital'  => 'nullable',
        ]);
        
        
        $nation = PublicComNation::find($id);

        $nation->nation_nm     = $request->nation_nm;
        $nation->capital       = $request->capital;
        $nation->updated_by    = Auth::user()->user_id;

        $nation->save();

        return response()->json(['status' => 'ok'],200); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function destroy($id){
        Nation::destroy($id);

        return response()->json(['status' => 'ok'],200);
    }

    /**
     * Display a listing of the resource for select2.
     *
     * @return \Illuminate\Http\Response
     */
    function getNationList(Request $request, $id=NULL){
        $nationNmParam  = $request->get('term');

        $nations        = PublicComNation::select(
                            "nation_cd as id", 
                            "nation_nm as text",
                            )
                            ->where("nation_nm", "ILIKE", "%$nationNmParam%");

        $nations->limit(100);
        
        return response()->json($nations->get());
    }

    public static function getNationById($id){
        return PublicComNation::find($id);
    }
}
