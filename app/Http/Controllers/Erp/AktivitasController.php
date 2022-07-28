<?php
namespace App\Http\Controllers\Erp;

use DB;
use Auth;
use DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\PublicComAktivitas;

class AktivitasController extends Controller{
    private $folder_path = 'sistem.erp.aktivitas';

    function __construct(){
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function index(){
        $pageFileName = 'index';
        $title        = 'Data Kegiatan';

        \LogActivityHelpers::saveLog(
            $logTp = 'visit', 
            $logNm = "Membuka Menu $title"
        );
        
        return view($this->folder_path . '.' . $pageFileName, compact('title'));
    }

    /**
     * Display a listing of the resource for DataTables.
     *
     * @return \Illuminate\Http\Response
     */
    function getData(){
        //$data = PublicComAktivitas::query();
		$data = PublicComAktivitas::select(
                    "com_aktivitas.aktivitas_cd as aktivitas_cd",
                    "com_aktivitas.aktivitas_nm as aktivitas_nm",
                    "com_aktivitas.aktivitas_tp as aktivitas_tp",
                    "aktivitastp.code_nm as aktivitas_tp_nm",
					"com_aktivitas.standar_tp as standar_tp",
                    "standartp.code_nm as standar_tp_nm",
					"com_aktivitas.note as note",
                )
                ->leftjoin('public.com_code as aktivitastp','aktivitastp.com_cd','com_aktivitas.aktivitas_tp')
				->leftjoin('public.com_code as standartp','standartp.com_cd','com_aktivitas.standar_tp');

        return DataTables::of($data)
                ->addColumn('actions', function($data){
                    $actions = '';
                    $actions .= "<button type='button' class='ubah btn btn-warning btn-flat btn-sm' data-toggle='tooltip' data-placement='form' title='Ubah Data'><i class='icon icon-pencil7'></i> </button> &nbsp";
                    $actions .= "<button type='button' class='hapus btn btn-danger btn-flat btn-sm' data-toggle='tooltip' data-placement='form' title='Hapus Data'><i class='icon icon-trash'></i> </button>";
                    
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
            'aktivitas_cd'   => 'required|unique:pgsql.public.com_aktivitas|max:20',
            'aktivitas_nm'   => 'required|max:200'
        ]);
        
        DB::beginTransaction();
        try {

            $data               = new PublicComAktivitas;
            $data->aktivitas_cd = $request->aktivitas_cd;
            $data->aktivitas_nm = $request->aktivitas_nm;
            $data->aktivitas_tp = $request->aktivitas_tp;
			$data->standar_tp 	= $request->standar_tp;
			$data->note 		= $request->note;
            $data->created_by   = Auth::user()->user_id;
            $data->save();

            \LogActivityHelpers::saveLog(
                $logTp   = 'create', 
                $logNm   = "Menambah Data Kegiatan $data->aktivitas_cd - $data->aktivitas_nm", 
                $table   = $data->getTable(), 
                $newData = $data
            );

            DB::commit();
            return response()->json(['status' => 'ok'],200); 
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => 'error','error' => $e],200); 
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function show($id){
        $data= PublicComAktivitas::find($id);

        return response()->json(['status' => 'ok', 'data' => $data],200); 
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
            'aktivitas_cd'   => 'required|max:20',
            'aktivitas_nm'   => 'required|max:200'
        ]);

        DB::beginTransaction();
        try {

            $data                   = PublicComAktivitas::find($id);
            $oldData = $data;

            $data->aktivitas_cd = $request->aktivitas_cd;
            $data->aktivitas_nm = $request->aktivitas_nm;
            $data->aktivitas_tp = $request->aktivitas_tp;
			$data->standar_tp 	= $request->standar_tp;
			$data->note 		= $request->note;
            $data->updated_by   = Auth::user()->user_id;
            $data->save();

            \LogActivityHelpers::saveLog(
                $logTp   = 'update', 
                $logNm   = "Mengubah Data Kegiatan $data->aktivitas_cd - $data->aktivitas_nm", 
                $table   = $data->getTable(), 
                $oldData = $oldData, 
                $newData = $data
            );

            DB::commit();
            return response()->json(['status' => 'ok'],200); 
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => 'error','error' => $e],200); 
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function destroy($id){
        DB::beginTransaction();
        try {
            $data= PublicComAktivitas::find($id);
            
            if ($data) {
                \LogActivityHelpers::saveLog(
                    $logTp   = 'delete', 
                    $logNm   = "Menghapus Data Kegiatan $data->aktivitas_cd - $data->aktivitas_nm", 
                    $table   = $data->getTable(), 
                    $oldData = $data
                );

                PublicComAktivitas::destroy($id);

                DB::commit();
                return response()->json(['status' => 'ok'],200); 
            }else{
                return response()->json(['status' => 'error', 'msg' => 'data not found'],200); 
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => 'error','error' => $e],200); 
        }
    }

    /**
     * Display a listing of the resource for select2.
     *
     * @return \Illuminate\Http\Response
     */
    function getDataList(Request $request, $id=NULL){
        $searchParam  = $request->get('term');

        $data        = PublicComAktivitas::select(
                                "aktivitas_cd as id",
                                DB::Raw("concat(aktivitas_cd,' - ',aktivitas_nm) as text")
                            )
                            ->orderBy('aktivitas_cd')
                            ->where("aktivitas_nm", "ILIKE", "%$searchParam%")
                            ->get()
                            ->toArray();

        array_unshift($data,array('id' => '','text'=>'=== Pilih Data ==='));
        return response()->json($data);
    }
	
	function getDataInfo($id){
        $data= PublicComAktivitas::find($id);

        //return $data->aktivitas_nm;
		return response()->json(['status' => 'ok', 'data' => $data],200);
    }
}
