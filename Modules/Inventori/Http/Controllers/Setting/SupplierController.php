<?php

namespace Modules\Inventori\Http\Controllers\Setting;

use Auth;

use DataTables;
use App\Models\AuthRole;
use Illuminate\Http\Request;
use App\Models\InvPoSupplier;
use App\Http\Controllers\Controller;

class SupplierController extends Controller{
    private $folder_path = 'setting.supplier';

    function __construct(){
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function index(){
        $filename_page = 'index';
        $title         = 'Data Supplier';
        $roles      = AuthRole::getAllRoles(Auth::user()->role->role_cd);
        return view('inventori::' . $this->folder_path . '.' . $filename_page, compact('title','roles'));
    }

    /**
     * Display a listing of the resource for DataTables.
     *
     * @return \Illuminate\Http\Response
     */
    function getData(){
        $pos = Auth::user()->unit_cd;
        if ($pos != null){
        $data = InvPoSupplier::select(
            '*',
            'user.user_nm',
             'user.email',
            'prop.region_nm as region_prop',
            'kab.region_nm as region_kab'

        )
        ->leftJoin('auth.users as user', 'user.unit_cd', 'inv.po_supplier.pos_cd')
            ->leftJoin('com_region as prop', 'prop.region_cd', 'inv.po_supplier.region_prop')
            ->leftJoin('com_region as kab', 'kab.region_cd', 'inv.po_supplier.region_kab')
            ->where('inv.po_supplier.pos_cd', $pos);

        return DataTables::of($data)->make(true);
    } else {
        $data = InvPoSupplier::select(
            '*',
            'user.user_nm',
             'user.email',
            'prop.region_nm as region_prop',
            'kab.region_nm as region_kab'

        )
        ->leftJoin('auth.users as user', 'user.unit_cd', 'inv.po_supplier.pos_cd')
            ->leftJoin('com_region as prop', 'prop.region_cd', 'inv.po_supplier.region_prop')
            ->leftJoin('com_region as kab', 'kab.region_cd', 'inv.po_supplier.region_kab');
            // ->where('inv_item_master.pos_cd', $unit);

        return DataTables::of($data)->make(true);

    }
}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    function store(Request $request){
        $this->validate($request,[
            //'supplier_cd' => 'required|unique:pgsql.inv.po_supplier|max:20',
            'supplier_nm' => 'required|max:255',
        ]);

        $supplier = new InvPoSupplier;
        //$supplier->supplier_cd = $request->supplier_cd;
		$supplier->supplier_cd = InvPoSupplier::getSupplierCd();
        $supplier->supplier_nm = $request->supplier_nm;
        $supplier->address = $request->address;
        $supplier->region_prop = $request->region_prop;
        $supplier->region_kab = $request->region_kab;
        $supplier->postcode = $request->postcode;
        $supplier->phone = $request->phone;
        $supplier->mobile = $request->mobile;
        $supplier->fax = $request->fax;
        $supplier->email = $request->email;
        $supplier->npwp = $request->npwp;
        $supplier->pic = $request->pic;
		$supplier->supplier_note = $request->supplier_note;
        $supplier->pos_cd = Auth::user()->unit_cd;
        $supplier->created_by  = Auth::user()->user_id;

        $supplier->save();

        return response()->json(['status' => 'ok'],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function show($id){
        $supplier = InvPoSupplier::find($id);

        if($supplier){
            return response()->json(['status' => 'ok', 'data' => $supplier],200);
        }else{
            return response()->json(['status' => 'failed', 'data' => 'not found'],200);
        }
    }

    /*
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function update(Request $request, $id){
        $this->validate($request,[
            'supplier_nm' => 'required',
        ]);

        $supplier = InvPoSupplier::find($id);
        $supplier->supplier_cd = $request->supplier_cd;
        $supplier->supplier_nm = $request->supplier_nm;
        $supplier->address = $request->address;
        $supplier->region_prop = $request->region_prop;
        $supplier->region_kab = $request->region_kab;
        $supplier->postcode = $request->postcode;
        $supplier->phone = $request->phone;
        $supplier->mobile = $request->mobile;
        $supplier->fax = $request->fax;
        $supplier->email = $request->email;
        $supplier->npwp = $request->npwp;
        $supplier->pic = $request->pic;
		$supplier->supplier_note = $request->supplier_note;
        $supplier->pos_cd = Auth::user()->unit_cd;
        $supplier->created_by  = Auth::user()->user_id;

        $supplier->save();

        return response()->json(['status' => 'ok'],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function destroy($id){
        InvPoSupplier::destroy($id);

        return response()->json(['status' => 'ok'],200);
    }

     /**
     * Display a listing of the resource for select2.
     *
     * @return \Illuminate\Http\Response
     */
    function getListData(Request $request){
        $searchParam = $request->get('term');
        $suppliers   = InvPoSupplier::select("supplier_cd as id", "supplier_nm as text")
                        ->where("supplier_nm", "ILIKE", "%$searchParam%")
                        ->get()
                        ->toArray();

        array_unshift($suppliers,array('id' => '','text'=>'=== Pilih Pos Inventori ==='));
        return response()->json($suppliers);
    }
}
