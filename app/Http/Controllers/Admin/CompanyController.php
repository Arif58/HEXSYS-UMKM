<?php

namespace App\Http\Controllers\Admin;

use Auth;
use DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\PublicComCompany;

class CompanyController extends Controller{
    private $folder_path = 'admin.company';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function index($id = NULL){
        $filename_page  = 'index';
        $title          = 'Data Perusahaan';
        $level          = NULL;
        $root           = "";
        if($id){
            $company		= PublicComCompany::find($id);
            $level          = $company->comp_level;
            $title         	= "Data Perusahaan " . $company->comp_nm;
            $root           = $company->comp_root;
        }
        switch ($level) {
            case '1':
                $type = "Sub 1";
                break;
            case '2':
                $type = "Sub 2";
                break;
            default:
                $type = "Perusahaan";
                break;
        }
        \LogActivityHelpers::saveLog(
            $logTp = 'visit', 
            $logNm = "Membuka Menu $title"
        );

        return view('sistem.' . $this->folder_path . '.' . $filename_page, compact('title','type','id','root'));
    }

    /**
     * Display a listing of the resource for datatables.
     *
     * @return \Illuminate\Http\Response
     */
    function getData(Request $request){
        $data = PublicComCompany::query();

        if(!empty($request->root)) {
            $data->where('com_company.comp_root', $request->root);
        }else{
            $data->where('com_company.comp_level', 1);
        }
        
        return DataTables::of($data)
            ->addColumn('actions',function($data){
                $actions = '';
                /* $actions .= "<button id='hapus' class='btn btn-danger btn-flat btn-sm' title='hapus'>
                                <i class='icon icon-trash'></i>
                        </button>  &nbsp"; */
                $actions .= "<button id='ubah' class='btn btn-warning btn-flat btn-sm' title='ubah'>
                                <i class='icon icon-pencil'></i>
                        </button>  &nbsp";
                /* if($data->comp_level != 3){
                    $actions .= "<button id='detail' class='btn btn-info btn-flat btn-sm' title='detail'>
                            <i class='icon icon-file-text2'></i>
                    </button>";
                }; */
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
            'comp_cd'    => 'required|unique:pgsql.public.com_company',
            'comp_nm'    => 'required',
            'comp_root'  => 'nullable',
        ]);

        if (!empty($request->comp_root)) {
            $companyRoot=PublicComCompany::find($request->comp_root);
            $companyLevel=$companyRoot->comp_level+1;
        }else{
            $companyLevel=1;
        }

        PublicComCompany::create([
            'comp_cd'    => $request->comp_cd,
            'comp_nm'    => $request->comp_nm,
            'comp_level' => $companyLevel,
            'comp_root'   => $request->comp_root,
            'address'       => $request->address,
            'region_prop'   => $request->region_prop,
            'region_kab'    => $request->region_kab,
            'region_kec'    => $request->region_kec,
            'region_kel'    => $request->region_kel,
            'postcode'      => $request->postcode,
            'phone'         => $request->phone,
            'mobile'        => $request->mobile,
            'fax'           => $request->fax,
            'email'         => $request->email,
            'created_by'    => Auth::user()->user_id,
        ]);

        return response()->json(['status' => 'ok'],200); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function show($id){
        $company = PublicComCompany::find($id);

        return response()->json(['status' => 'ok', 'data' => $company],200); 
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
            'comp_nm'    => 'required',
        ]); 

        $company = PublicComCompany::find($id);

        $company->comp_nm    = $request->comp_nm;
        $company->address       = $request->address;
        $company->region_prop   = $request->region_prop;
        $company->region_kab    = $request->region_kab;
        $company->region_kec    = $request->region_kec;
        $company->region_kel    = $request->region_kel;
        $company->postcode      = $request->postcode;
        $company->phone         = $request->phone;
        $company->mobile        = $request->mobile;
        $company->fax           = $request->fax;
        $company->email         = $request->email;
        $company->updated_by     = Auth::user()->user_id;
        
        $company->save();

        return response()->json(['status' => 'ok'],200); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function destroy($id){
        $company = PublicComCompany::find($id);
        
        if ($company) {
            PublicComCompany::destroy($id);
            
            return response()->json(['status' => 'ok'],200); 
        }else{
            return response()->json(['status' => 'error'],200); 
        }
    }
}
