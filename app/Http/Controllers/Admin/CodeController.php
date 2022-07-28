<?php
namespace App\Http\Controllers\Admin;

use DB;
use Auth;
use DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PublicComCode;

class CodeController extends Controller{
    private $folder_path = 'admin.code';
    
    function __construct(){
        $this->middleware('auth');
    }

    /**
     * Index
     *
     * @return \Illuminate\Http\Response
     */
    function index($id = NULL){
        $filename_page 	= 'index';
        $title 			= 'Kode Sistem';
		
		$groups			= PublicComCode::getAllGroup();
		
        return view('sistem.' . $this->folder_path . '.' . $filename_page, compact('title','groups'));
    }

    /**
     * Show : DataTables
     *
     * @return \Illuminate\Http\Response
     */
    function getData(Request $request){
		$data = PublicComCode::query()
				->orderBy('code_group','asc')
				->orderBy('com_cd','asc');

        return DataTables::of($data)
		->addColumn('actions',function($data){
            $actions = '';
            $actions .= "<button type='button' id='ubah'  class='btn btn-warning btn-flat btn-sm' data-toggle='tooltip' data-placement='top' title='Ubah Data'><i class='icon icon-pencil7'></i> </button> &nbsp";
            $actions .= "<button type='button' id='hapus' class='btn btn-danger btn-flat btn-sm' data-toggle='tooltip' data-placement='top' title='Hapus Data'><i class='icon icon-trash'></i> </button> &nbsp";
            
            return $actions;
        })
        ->rawColumns(['actions'])
        ->make(true);
    }

    /**
     * Create
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    function store(Request $request){
		$this->validate($request,[
            'com_cd'      => 'required',
            'code_nm'     => 'required',
			'code_group'  => 'required'
        ]);
		
        $kode             = new PublicComCode;
        $kode->com_cd     = str_replace(' ','',$request->com_cd);
        $kode->code_nm    = ucwords($request->code_nm);
        $kode->code_group = ucwords($request->code_group);
		$kode->code_value = $request->code_value;
		$kode->created_by = Auth::user()->user_id;
        $kode->save();

        return response()->json(['status' => 'ok'],200); 
    }

    /**
     * Show by id
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function show($id){
        $kode = PublicComCode::find($id);

        if($kode){
            return response()->json(['status' => 'ok', 'data' => $kode],200);
        }else{
            return response()->json(['status' => 'failed', 'data' => 'not found'],200);
        }
    }

    /**
     * Update
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function update(Request $request, $id){
        $this->validate($request,[
            'com_cd'       => 'required',
			'code_nm'      => 'required',
			'code_group'   => 'required'
        ]);
        
        $kode             = PublicComCode::find($id);
        $kode->code_nm    = ucwords($request->code_nm);
		$kode->code_group = ucwords($request->code_group);
		$kode->code_value = ucwords($request->code_value);
		$kode->updated_by = Auth::user()->user_id;

        $kode->save();

        return response()->json(['status' => 'ok'],200); 
    }

    /** 
     * Delete
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function destroy($id){
        PublicComCode::destroy($id);

        return response()->json(['status' => 'ok'],200);
    }

    function getListData(Request $request, $id=NULL){
        $searchParam = $request->get('term');
        $kodes = PublicComCode::select("com_cd as id", "code_nm as text") 
                        ->where("code_nm", "ILIKE", "%$searchParam%")
                        ->get()
                        ->toArray();

        array_unshift($kodes,array('id' => '','text'=>'=== Pilih Kode ==='));
        return response()->json($kodes);
    }
}
