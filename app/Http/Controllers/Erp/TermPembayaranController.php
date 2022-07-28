<?php

namespace App\Http\Controllers\Erp;

use DB;
use Auth;
use DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\PublicComPaymentType;

class TermPembayaranController extends Controller{
    private $folder_path = 'sistem.erp.term-pembayaran';

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
        $title        = 'Data Term Pembayaran';

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
        $data = PublicComPaymentType::query();

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
            'top_cd'          => 'required|unique:pgsql.public.com_payment_type|max:20',
            'top_nm'          => 'required|max:200',
            'top_total_day'   => 'sometimes',
            'top_total_month' => 'sometimes',
        ]);
        
        DB::beginTransaction();
        try {

            $data                   = new PublicComPaymentType;
            $data->top_cd           = $request->top_cd;
            $data->top_nm           = $request->top_nm;
            $data->top_total_day    = $request->top_total_day ? $request->top_total_day : 0;
            $data->top_total_month  = $request->top_total_month ? $request->top_total_month : 0;
            $data->created_by       = Auth::user()->user_id;
            $data->save();

            \LogActivityHelpers::saveLog(
                $logTp   = 'create', 
                $logNm   = "Menambah Data Term Pembayaran $data->top_cd - $data->top_nm", 
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
        $data= PublicComPaymentType::find($id);

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
            // 'top_cd'     => 'sometimes|required|unique:pgsql.public.com_payment_type|max:20',
            'top_cd'          => 'required|max:20',
            'top_nm'          => 'required|max:200',
            'top_total_day'   => 'sometimes',
            'top_total_month' => 'sometimes',
        ]);

        DB::beginTransaction();
        try {

            $data                   = PublicComPaymentType::find($id);
            $oldData = $data;

            $data->top_cd           = $request->top_cd;
            $data->top_nm           = $request->top_nm;
            $data->top_total_day    = $request->top_total_day ? $request->top_total_day : 0;
            $data->top_total_month  = $request->top_total_month ? $request->top_total_month : 0;
            $data->updated_by       = Auth::user()->user_id;
            $data->save();

            \LogActivityHelpers::saveLog(
                $logTp   = 'update', 
                $logNm   = "Mengubah Data Term Pembayaran $data->top_cd - $data->top_nm", 
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
            $data= PublicComPaymentType::find($id);
            
            if ($data) {
                \LogActivityHelpers::saveLog(
                    $logTp   = 'delete', 
                    $logNm   = "Menghapus Data Term Pembayaran $data->top_cd - $data->top_nm", 
                    $table   = $data->getTable(), 
                    $oldData = $data
                );

                PublicComPaymentType::destroy($id);

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

        $data        = PublicComPaymentType::select(
                                "top_cd as id",
                                DB::Raw("concat(top_cd,' - ',top_nm) as text")
                            )
                            ->orderBy('top_cd')
                            ->where("top_nm", "ILIKE", "%$searchParam%")
                            ->get()
                            ->toArray();

        array_unshift($data,array('id' => '','text'=>'=== Pilih Data ==='));
        return response()->json($data);
    }
}
