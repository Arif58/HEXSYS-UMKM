<?php

namespace Modules\Inventori\Http\Controllers\Setting;

use Auth;
use DataTables;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\InvInvFormula;


class FormulaController extends Controller
{
    private $folder_path = 'setting.formula-obat';
    
    function __construct(){
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    function index()
    {
        $filename_page = 'index';
        $title         = 'Formula Obat';
        $formula_obat    = InvInvFormula::all(['formula_cd','formula_nm']);

        return view('inventori::' . $this->folder_path . '.' . $filename_page, compact('title','formula_obat'));
    }

    /**
     * Display a listing of the resource for DataTables.
     *
     * @return \Illuminate\Http\Response
     */
    function getData(){
        $data = InvInvFormula::select('formula_cd','formula_nm');
        return DataTables::of($data)->make(true);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    function store(Request $request)
    {
        $this->validate($request,[
            'formula_cd' => 'required|unique:pgsql.inv.inv_formula|max:20',
            'formula_nm' => 'required|max:255',
        ]);
        
        $pos                = new InvInvFormula;
        $pos->formula_cd    = strtoupper($request->formula_cd);
        $pos->formula_nm    = $request->formula_nm;
        $pos->created_by    = Auth::user()->user_id;
        $pos->save();

        return response()->json(['status' => 'ok'],200); 
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    function show($id)
    {
        $pos = InvInvFormula::find($id);

        if($pos){
            return response()->json(['status' => 'ok', 'data' => $pos],200);
        }else{
            return response()->json(['status' => 'failed', 'data' => 'not found'],200);
        }
    }


    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'formula_nm' => 'required',
        ]);
        
        $pos = InvInvFormula::find($id);
        $pos->formula_cd     = $request->formula_cd;
        $pos->formula_nm     = $request->formula_nm;
        $pos->updated_by = Auth::user()->user_id;

        $pos->save();

        return response()->json(['status' => 'ok'],200); 
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        InvInvFormula::destroy($id);

        return response()->json(['status' => 'ok'],200);
    }
}
