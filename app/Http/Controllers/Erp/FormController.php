<?php

namespace App\Http\Controllers\Erp;

use DB;
use Auth;
use DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\PublicComForm;

class FormController extends Controller{
    private $folder_path = 'sistem.erp.form';

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
        $title        = 'Data Form';

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
        $data = PublicComForm::query();

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
            'form_cd'   => 'required|unique:pgsql.public.com_form|max:20',
            'form_nm'   => 'required|max:200',
            'form_file' => 'sometimes',
        ]);
        
        DB::beginTransaction();
        try {

            $data               = new PublicComForm;
            $data->comp_cd      = configuration('COMP_CD');
            $data->form_cd      = $request->form_cd;
            $data->form_nm      = $request->form_nm;
            $data->form_file    = $request->form_file;
            $data->created_by   = Auth::user()->user_id;
            $data->save();

            \LogActivityHelpers::saveLog(
                $logTp   = 'create', 
                $logNm   = "Menambah Data Form $data->form_cd - $data->form_nm", 
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
        $data= PublicComForm::find($id);

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
            // 'form_cd'     => 'sometimes|required|unique:pgsql.public.com_form|max:20',
            'form_cd'   => 'required|max:20',
            'form_nm'   => 'required|max:200',
            'form_file' => 'sometimes',
        ]);

        DB::beginTransaction();
        try {

            $data                   = PublicComForm::find($id);
            $oldData = $data;

            $data->comp_cd      = configuration('COMP_CD');
            $data->form_cd      = $request->form_cd;
            $data->form_nm      = $request->form_nm;
            $data->form_file    = $request->form_file;
            $data->updated_by   = Auth::user()->user_id;
            $data->save();

            \LogActivityHelpers::saveLog(
                $logTp   = 'update', 
                $logNm   = "Mengubah Data Form $data->form_cd - $data->form_nm", 
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
            $data= PublicComForm::find($id);
            
            if ($data) {
                \LogActivityHelpers::saveLog(
                    $logTp   = 'delete', 
                    $logNm   = "Menghapus Data Form $data->form_cd - $data->form_nm", 
                    $table   = $data->getTable(), 
                    $oldData = $data
                );

                PublicComForm::destroy($id);

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

        $data        = PublicComForm::select(
                                "form_cd as id",
                                DB::Raw("concat(form_cd,' - ',form_nm) as text")
                            )
                            ->orderBy('form_cd')
                            ->where("form_nm", "ILIKE", "%$searchParam%")
                            ->get()
                            ->toArray();

        array_unshift($data,array('id' => '','text'=>'=== Pilih Data ==='));
        return response()->json($data);
    }
}
