<?php

namespace App\Http\Controllers\Erp;

use DB;
use Auth;
use DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\PublicComCompanyBank;

class RekeningBankController extends Controller{
    private $folder_path = 'sistem.erp.rekening-bank';

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
        $title        = 'Data Rekening Bank';

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
        $data = PublicComCompanyBank::with('com_company', 'com_bank', 'com_currency');
        // $data = PublicComCompanyBank::select(
        //     'com_company_bank.*',
        //     'com_company.comp_nm',
        //     'com_bank.bank_nm',
        //     'com_currency.currency_nm'
        // )
        //     ->join('com_company','com_company.comp_cd','com_company_bank.comp_cd')
        //     ->join('com_bank','com_bank.bank_cd','com_company_bank.bank_cd')
        //     ->join('com_currency','com_currency.currency_cd','com_company_bank.currency_cd');

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
            'account_cd'    => 'required',
            'bank_cd'       => 'required',
            'branch_nm'     => 'required',
            'account_nm'    => 'required',
            'currency_cd'   => 'required',
        ]);
        
        DB::beginTransaction();
        try {

            $data               = new PublicComCompanyBank;
            $data->comp_cd      = configuration('COMP_CD');
            $data->account_cd   = $request->account_cd;
            $data->bank_cd      = $request->bank_cd;
            $data->branch_nm    = $request->branch_nm;
            $data->account_nm   = $request->account_nm;
            $data->account_no   = $request->account_cd;
            $data->currency_cd  = $request->currency_cd;
            $data->created_by   = Auth::user()->user_id;
            $data->save();

            \LogActivityHelpers::saveLog(
                $logTp   = 'create', 
                $logNm   = "Menambah Data Rekening Bank $data->account_cd - $data->account_nm", 
                $table   = $data->getTable(), 
                $newData = $data
            );

            DB::commit();
            return response()->json(['status' => 'ok'],200); 
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => 'error','error' => $e->getMessage()],200); 
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function show($id){
        $data= PublicComCompanyBank::find($id);

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
            'account_cd'    => 'required',
            'bank_cd'       => 'required',
            'branch_nm'     => 'required',
            'account_nm'    => 'required',
            'currency_cd'   => 'required',
        ]);

        DB::beginTransaction();
        try {

            $data               = PublicComCompanyBank::find($id);
            $oldData = $data;

            $data->account_cd   = $request->account_cd;
            $data->bank_cd      = $request->bank_cd;
            $data->branch_nm    = $request->branch_nm;
            $data->account_nm   = $request->account_nm;
            $data->account_no   = $request->account_cd;
            $data->currency_cd  = $request->currency_cd;
            $data->updated_by   = Auth::user()->user_id;
            $data->save();

            \LogActivityHelpers::saveLog(
                $logTp   = 'update', 
                $logNm   = "Mengubah Data Rekening Bank $data->account_cd - $data->account_nm", 
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
            $data= PublicComCompanyBank::find($id);
            
            if ($data) {
                \LogActivityHelpers::saveLog(
                    $logTp   = 'delete', 
                    $logNm   = "Menghapus Data Rekening Bank $data->account_cd - $data->account_nm", 
                    $table   = $data->getTable(), 
                    $oldData = $data
                );

                PublicComCompanyBank::destroy($id);

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

        $data        = PublicComCompanyBank::select(
                                "account_cd as id",
                                DB::Raw("concat(account_cd,' - ',account_nm) as text")
                            )
                            ->orderBy('account_cd')
                            ->where("account_nm", "ILIKE", "%$searchParam%")
                            ->get()
                            ->toArray();

        array_unshift($data,array('id' => '','text'=>'=== Pilih Data ==='));
        return response()->json($data);
    }
}
