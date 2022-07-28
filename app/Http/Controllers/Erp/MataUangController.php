<?php

namespace App\Http\Controllers\Erp;

use DB;
use Auth;
use DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\PublicComCurrency;
use App\Models\PublicComBank;

class MataUangController extends Controller{
    private $folder_path = 'sistem.erp.mata-uang';

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
        $title        = 'Data Mata Uang';

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
        $data = PublicComCurrency::query();

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
            'currency_cd'     => 'required|unique:pgsql.public.com_currency|max:20',
            'currency_nm'     => 'required|max:200',
            'currency_symbol' => 'required|max:20',
            'current_rate'    => 'required',
        ]);
        
        DB::beginTransaction();
        try {

            $data                   = new PublicComCurrency;
            $data->currency_cd      = $request->currency_cd;
            $data->currency_nm      = $request->currency_nm;
            $data->currency_symbol  = $request->currency_symbol;
            $data->current_rate     = uang($request->current_rate);
            $data->created_by       = Auth::user()->user_id;
            $data->save();

            \LogActivityHelpers::saveLog(
                $logTp   = 'create', 
                $logNm   = "Menambah Data Mata Uang $data->currency_cd - $data->currency_nm", 
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
        $data= PublicComCurrency::find($id);

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
            // 'currency_cd'     => 'sometimes|required|unique:pgsql.public.com_currency|max:20',
            'currency_cd'     => 'required|max:20',
            'currency_nm'     => 'required|max:200',
            'currency_symbol' => 'required|max:20',
            'current_rate'    => 'required',
        ]);

        DB::beginTransaction();
        try {

            $data                   = PublicComCurrency::find($id);
            $oldData = $data;

            $data->currency_cd      = $request->currency_cd;
            $data->currency_nm      = $request->currency_nm;
            $data->currency_symbol  = $request->currency_symbol;
            $data->current_rate     = uang($request->current_rate);
            $data->updated_by       = Auth::user()->user_id;
            $data->save();

            \LogActivityHelpers::saveLog(
                $logTp   = 'update', 
                $logNm   = "Mengubah Data Mata Uang $data->currency_cd - $data->currency_nm", 
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
            $data= PublicComCurrency::find($id);
            
            if ($data) {
                \LogActivityHelpers::saveLog(
                    $logTp   = 'delete', 
                    $logNm   = "Menghapus Data Mata Uang $data->currency_cd - $data->currency_nm", 
                    $table   = $data->getTable(), 
                    $oldData = $data
                );

                PublicComCurrency::destroy($id);

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

        $data        = PublicComCurrency::select(
                                "currency_cd as id",
                                DB::Raw("concat(currency_cd,' - ',currency_nm) as text"),
                                "current_rate"
                            )
                            ->orderBy('currency_cd')
                            ->where("currency_nm", "ILIKE", "%$searchParam%")
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
