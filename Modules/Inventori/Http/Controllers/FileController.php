<?php

namespace Modules\Inventori\Http\Controllers;

use DB;
use Auth;
use DataTables;
use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

use App\Models\PublicTrxFile;

class FileController extends Controller{

    function __construct(){
        $this->middleware('auth');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    function store(Request $request, $id){
        $this->validate($request,[
            'file_nm'   => 'required',
            'file_tp'   => 'required',
            'file'      => 'required',
            'file_desc' => 'nullable',
        ]);

        DB::beginTransaction();
        try {
            
            if ($request->hasFile('file')) {
                $data           = new PublicTrxFile;
                $data->trx_cd 	= $id;
                $data->file_nm  = $request->file_nm;
                $data->file_tp  = $request->file_tp;
                $data->note     = $request->file_desc;

                $file           = $request->file('file');
				
                $name              = Uuid::uuid4()->toString().'.'.$file->getClientOriginalExtension();
                $image['filePath'] = $name;     
                $file->move(storage_path('app/public/trx-file/'), $name);

                $data->file_path = $name;

                $data->created_by   = Auth::user()->user_id;
                $data->save();
                
                \LogActivityHelpers::saveLog(
                    $logTp = 'create', 
                    $logNm = "Menambahkan Data Berkas Transaksi $data->trx_file_id - $data->trx_cd - $data->file_nm", 
                    $table = $data->getTable(), 
                    $newData = $data
                );
                
                DB::commit();
            }

            return redirect()->back()->with(['success' => 'Berhasil Unggah Berkas']);
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
        $data= PublicTrxFile::find($id);
        
        if ($data) {
            \LogActivityHelpers::saveLog(
                $logTp   = 'delete', 
                $logNm   = "Menghapus Data File $id", 
                $table   = $data->getTable(), 
                $oldData = $data
            );

            $oldFile	 = $data->file_path;
			if(is_file(storage_path('/app/public/trx-file/'.$data->file_path))) {
				//Storage::delete('/app/public/trx-file/'.$data->file_path);
				unlink(storage_path('/app/public/trx-file/'.$data->file_path));
			}
            
			PublicTrxFile::destroy($id);
			
			return redirect("inventori/pembelian/purchase-order/$data->trx_cd")->with(['success' => 'Berhasil Hapus Berkas']);
        }else{
            return response()->json(['status' => 'error'],200); 
        }
    }
}
