<?php

namespace App\Http\Controllers\Admin;

use DB;
use Auth;
use DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PublicComRegion;
use App\Models\PublicVwRegion;

class RegionController extends Controller{
    private $folder_path = 'admin.region';
    
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
        $title          = 'Data Daerah';
        $level          = NULL;
        $root           = "";
        if($id){
            $region         = PublicComRegion::find($id);
            $level          = $region->region_level;
            $title         = "Data Wilayah " . $region->region_nm;
            $root           = $region->region_root;
        }
        switch ($level) {
            case '1':
                $type = "Kabupaten";
                break;
            case '2':
                $type = "Kecamatan";
                break;
            case '3':
                $type = "Kelurahan";
                break;
            default:
                $type = "Propinsi";
                break;
        }
        \LogActivityHelpers::saveLog(
            $logTp = 'visit', 
            $logNm = "Membuka Menu $title"
        );

        return view('sistem.' . $this->folder_path . '.' . $filename_page, compact('title','type','id','root'));
    }

    /**
     * Display a listing of the resource for datatables.
     *
     * @return \Illuminate\Http\Response
     */
    function getData(Request $request){
        $data   = PublicComRegion::query();
        
        if(!empty($request->root)) {
            $data->where('com_region.region_root', $request->root);
        }else{
            $data->where('com_region.region_level', 1);
        }

        return DataTables::of($data)
            ->addColumn('actions',function($data){
                $actions = '';
                $actions .= "<button id='hapus' class='btn btn-danger btn-flat btn-sm' title='hapus'>
                                <i class='icon icon-trash'></i>
                        </button>  &nbsp";
                $actions .= "<button id='ubah' class='btn btn-warning btn-flat btn-sm' title='ubah'>
                                <i class='icon icon-pencil'></i>
                        </button>  &nbsp";
                if($data->region_level != 4){
                    $actions .= "<button id='detail' class='btn btn-info btn-flat btn-sm' title='detail'>
                            <i class='icon icon-file-text2'></i>
                    </button>";
                };
                return $actions;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    function store(Request $request){
        $this->validate($request,[
            'region_cd'      => 'required|unique:com_region|alpha_num',
            'region_nm'      => 'required',
            'region_capital' => 'nullable',
            'region_root'    => 'nullable',
        ]);
        
        if (!empty($request->region_root)) {
            $regionRoot=PublicComRegion::find($request->region_root);
            $regionLevel=$regionRoot->region_level+1;
        }else{
            $regionLevel=1;
        }
        
        $region = PublicComRegion::create([
            'region_cd'     => $request->region_cd,
            'region_nm'     => $request->region_nm,
            'region_root'   => $request->region_root,
            'region_capital'=> $request->region_capital,
            'default_st'    => '1',
            'region_level'  => $regionLevel,
            'created_by'    => Auth::user()->user_id
        ]);

        \LogActivityHelpers::saveLog(
            $logTp = 'create', 
            $logNm = "Menambah Data Daerah $region->region_cd - $region->region_nm", 
            $table = $region->getTable(), 
            $newData = $region
        );

        return response()->json(['status' => 'ok'],200); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function show($id){
        $region = PublicVwRegion::select(DB::Raw("*, trim(concat(region_nm_kel, ', ', region_nm_kec, ', ', region_nm_kab, ', ', region_nm_prop),', ') as long_region"))->find($id);

        if($region){
            return response()->json(['status' => 'ok', 'data' => $region],200);
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
            'region_nm'      => 'required',
            'region_capital' => 'nullable',
            'region_root'    => 'nullable',
        ]);
        
        if (!empty($request->region_root)) {
            $regionRoot=PublicComRegion::find($request->region_root);
            $regionLevel=$regionRoot->region_level+1;
        }else{
            $regionLevel=1;
        }
        
        $region = PublicComRegion::find($id);
        $oldData = clone $region;

        $region->region_nm     = $request->region_nm;
        $region->region_root   = $request->region_root;
        $region->region_capital= $request->region_capital;
        $region->region_level  = $regionLevel;
        $region->updated_by    = Auth::user()->user_id;

        $region->save();

        \LogActivityHelpers::saveLog(
            $logTp   = 'update', 
            $logNm   = "Mengubah Data Daerah $region->region_cd - $region->region_nm", 
            $table   = $region->getTable(), 
            $newData = $region,
            $oldData = $oldData
        );

        return response()->json(['status' => 'ok'],200); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function destroy($id){
        $data = PublicComRegion::find($id);
            \LogActivityHelpers::saveLog(
                $logTp   = 'delete', 
                $logNm   = "Menghapus Data Daerah $id",
                $table   = $data->getTable(), 
                $newData = NULL,
                $oldData = $data
            );
        PublicComRegion::destroy($id);

        return response()->json(['status' => 'ok'],200);
    }

    /**
     * Display a listing of the resource for select2.
     *
     * @return \Illuminate\Http\Response
     */
    function getRegionList(Request $request, $id=NULL){
        $regionNmParam  = $request->get('term');
        $level          = $request->get('level');
        $action         = $request->route()->getAction();

        $regions        = PublicVwRegion::select(DB::raw("region_cd as id, 
                            region_nm as text, 
                            region_root,
                            region_cd_prop,
                            region_nm_prop,
                            region_cd_kab,
                            region_nm_kab,
                            region_cd_kec,
                            region_nm_kec,
                            region_cd_kel,
                            region_nm_kel,
                            trim(concat(region_nm_kel, ', ', region_nm_kec, ', ', region_nm_kab, ', ', region_nm_prop),', ') as long_region"))
                            ->where("region_nm", "ILIKE", "%$regionNmParam%");

        if (!empty($action['region_level'])) {
            $regions->where('region_level','=',$action['region_level']);
        }

        if ($id) {
            $regions->where('region_root', $id);
        }

        $regions->limit(100);
        
        return response()->json($regions->get());
    }

    public static function getRegionById($id){
        return PublicVwRegion::find($id);
    }

    function getRegionName($id){
        return response()->json(regionName($id));
    }
}
