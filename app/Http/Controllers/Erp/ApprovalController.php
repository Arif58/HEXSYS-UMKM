<?php

namespace App\Http\Controllers\Erp;

use DB;
use Auth;
use DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\PublicComApproval;
use App\Models\PublicComApprovalDetail;

class ApprovalController extends Controller{
    private $folder_path = 'sistem.erp.approval';

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
        $title        = 'Data Approval';

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
        $data = PublicComApproval::select(
                    "com_approval.approval_cd as approval_cd",
                    "com_approval.approval_nm as approval_nm",
                    "com_approval.approval_tp as approval_tp",
                    "approvaltp.code_nm as approval_tp_nm",
                )
                ->leftjoin('public.com_code as approvaltp','approvaltp.com_cd','com_approval.approval_tp');

        return DataTables::of($data)
                ->addColumn('actions', function($data){
                    $actions = '';
                    $actions .= "<button type='button' class='detail btn btn-info btn-flat btn-sm' data-toggle='tooltip' data-placement='top' title='Approval Detail'><i class='icon-clipboard3'></i> </button> &nbsp";
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
            'approval_cd' => 'required|unique:pgsql.public.com_approval|max:20',
            'approval_nm' => 'required|max:200',
            'approval_tp' => 'required|max:20',
        ]);
        
        DB::beginTransaction();
        try {

            $data               = new PublicComApproval;
            $data->approval_cd  = $request->approval_cd;
            $data->approval_nm  = $request->approval_nm;
            $data->approval_tp  = $request->approval_tp;
            $data->created_by   = Auth::user()->user_id;
            $data->save();

            \LogActivityHelpers::saveLog(
                $logTp   = 'create', 
                $logNm   = "Menambah Data Approval $data->approval_cd - $data->approval_nm", 
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
        $data= PublicComApproval::find($id);

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
            // 'approval_cd' => 'sometimes|required|unique:pgsql.erp.com_approval|max:20',
            'approval_cd' => 'required|max:20',
            'approval_nm' => 'required|max:200',
            'approval_tp' => 'required|max:20',
        ]);

        DB::beginTransaction();
        try {

            $data               = PublicComApproval::find($id);
            $oldData = $data;

            $data->approval_cd  = $request->approval_cd;
            $data->approval_nm  = $request->approval_nm;
            $data->approval_tp  = $request->approval_tp;
            $data->updated_by   = Auth::user()->user_id;
            $data->save();

            \LogActivityHelpers::saveLog(
                $logTp   = 'update', 
                $logNm   = "Mengubah Data Approval $data->approval_cd - $data->approval_nm", 
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
            $data= PublicComApproval::find($id);
            
            if ($data) {
                \LogActivityHelpers::saveLog(
                    $logTp   = 'delete', 
                    $logNm   = "Menghapus Data Approval $data->approval_cd - $data->approval_nm", 
                    $table   = $data->getTable(), 
                    $oldData = $data
                );

                PublicComApproval::destroy($id);

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

        $data        = PublicComApproval::select(
                                "approval_cd as id",
                                DB::Raw("concat(approval_cd,' - ',approval_nm) as text")
                            )
                            ->orderBy('approval_cd')
                            ->where("approval_nm", "ILIKE", "%$searchParam%")
                            ->get()
                            ->toArray();

        array_unshift($data,array('id' => '','text'=>'=== Pilih Data ==='));
        return response()->json($data);
    }

    /**
     * Display a listing of the resource for select2.
     *
     * @return \Illuminate\Http\Response
     */
    function getDataListBank(Request $request, $id=NULL){
        $searchParam  = $request->get('term');

        $data        = PublicComBank::select(
                                "bank_cd as id",
                                DB::Raw("concat(bank_cd,' - ',bank_nm) as text")
                            )
                            ->orderBy('bank_cd')
                            ->where("bank_nm", "ILIKE", "%$searchParam%")
                            ->get()
                            ->toArray();

        array_unshift($data,array('id' => '','text'=>'=== Pilih Data ==='));
        return response()->json($data);
    }
}
