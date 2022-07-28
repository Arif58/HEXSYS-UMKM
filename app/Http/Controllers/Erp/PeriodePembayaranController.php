<?php

namespace App\Http\Controllers\Erp;

use DB;
use Auth;
use DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\PublicComAging;
use App\Models\PublicComAgingDetail;

class PeriodePembayaranController extends Controller{
    private $folder_path = 'sistem.erp.periode-pembayaran';

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
        $title        = 'Data Periode Pembayaran';

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
        $data = PublicComAging::with('com_aging_details');

        return DataTables::of($data)
                ->addColumn('actions', function($data){
                    $actions = '';
                    $actions .= "<button type='button' class='ubah btn btn-warning btn-flat btn-sm' data-toggle='tooltip' data-placement='top' title='Ubah Data'><i class='icon icon-pencil7'></i> </button> &nbsp";
                    $actions .= "<button type='button' class='hapus btn btn-danger btn-flat btn-sm' data-toggle='tooltip' data-placement='top' title='Hapus Data'><i class='icon icon-trash'></i> </button>";
                    
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
            'aging_cd'     => 'required|unique:pgsql.public.com_aging|max:20',
            'aging_nm'     => 'required|max:200',
        ]);
        
        DB::beginTransaction();
        try {
            $data               = new PublicComAging;
            $data->aging_cd     = $request->aging_cd;
            $data->aging_nm     = $request->aging_nm;
            $data->created_by   = Auth::user()->user_id;
            $data->save();

            $details = array();

            for ($i=1; $i <= 4 ; $i++) { 
                $key = 'input_aging_detail_'.$i;
                if ($request->$key) {
                    $detail               = new PublicComAgingDetail;
                    $detail->aging_cd     = $data->aging_cd;
                    $detail->aging_no     = $request->$key;
                    $detail->value        = $request->$key;
                    $detail->created_by   = Auth::user()->user_id;
                    $detail->save();

                    array_push($details, $detail);
                }
            }

            \LogActivityHelpers::saveLog(
                $logTp   = 'create', 
                $logNm   = "Menambah Data Periode Pembayaran $data->aging_cd - $data->aging_nm", 
                $table   = 'data = '.$data->getTable().', detail = '.$data->getTable().'_detail', 
                $newData = ['data' => $data, 'detail' => $details]
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
        $data= PublicComAging::find($id);

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
            'aging_cd'     => 'required|max:20',
            'aging_nm'     => 'required|max:200',
        ]);

        DB::beginTransaction();
        try {
            $data               = PublicComAging::find($id);
            $oldData = $data;

            $data->aging_cd     = $request->aging_cd;
            $data->aging_nm     = $request->aging_nm;
            $data->updated_by   = Auth::user()->user_id;
            $data->save();

            $oldDetails         = PublicComAgingDetail::where('aging_cd', $data->aging_cd)->get();
            $oldDetailsDelete   = PublicComAgingDetail::where('aging_cd', $data->aging_cd)->delete();

            $details = array();

            for ($i=1; $i <= 4 ; $i++) { 
                $key = 'input_aging_detail_'.$i;
                if ($request->$key) {
                    $detail               = new PublicComAgingDetail;
                    $detail->aging_cd     = $data->aging_cd;
                    $detail->aging_no     = $request->$key;
                    $detail->value        = $request->$key;
                    $detail->created_by   = Auth::user()->user_id;
                    $detail->save();

                    array_push($details, $detail);
                }
            }

            \LogActivityHelpers::saveLog(
                $logTp   = 'update', 
                $logNm   = "Mengubah Data Periode Pembayaran $data->aging_cd - $data->aging_nm", 
                $table   = 'data = '.$data->getTable().', detail = '.$data->getTable().'_detail', 
                $oldData = ['data' => $oldData, 'detail' => $oldDetails], 
                $newData = ['data' => $data, 'detail' => $details]
            );

            DB::commit();
            return response()->json(['status' => 'ok'],200); 
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
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
            $data= PublicComAging::find($id);
            
            if ($data) {
                \LogActivityHelpers::saveLog(
                    $logTp   = 'delete', 
                    $logNm   = "Menghapus Data Periode Pembayaran $data->aging_cd - $data->aging_nm", 
                    $table   = $data->getTable(), 
                    $oldData = $data
                );

                PublicComAging::destroy($id);

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

        $data        = PublicComAging::select(
                                "aging_cd as id",
                                DB::Raw("concat(aging_cd,' - ',aging_nm) as text")
                            )
                            ->orderBy('aging_cd')
                            ->where("aging_nm", "ILIKE", "%$searchParam%")
                            ->get()
                            ->toArray();

        array_unshift($data,array('id' => '','text'=>'=== Pilih Data ==='));
        return response()->json($data);
    }
}
