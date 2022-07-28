<?php

namespace App\Http\Controllers\Admin;

use DB;
use Auth;
use DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AuthRole;
use App\Models\AuthMenu;
use App\Models\AuthRoleMenu;

class RoleController extends Controller{
    private $folder_path = 'admin.role';
    
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
        $title = 'Data Autorisasi';
        \LogActivityHelpers::saveLog(
            $logTp = 'visit', 
            $logNm = "Membuka Menu $title"
        );

        return view('sistem.' . $this->folder_path . '.' . $filename_page, compact('title'));
    }

    /**
     * Display a listing of the resource for datatables.
     *
     * @return \Illuminate\Http\Response
     */
    function getData(){
        $data   =  AuthRole::select('role_cd','role_nm','rule_tp');

        return DataTables::of($data)
        ->addColumn('actions',function($data){
            $actions = '';
            $actions .= "<button type='button' id='hapus' class='btn btn-danger btn-flat btn-sm' data-toggle='tooltip' data-placement='top' title='Hapus Data'><i class='icon icon-trash'></i> </button> &nbsp";
            $actions .= "<button type='button' id='detail' class='btn btn-info btn-flat btn-sm' data-toggle='tooltip' data-placement='top' title='Detail Data'><i class='icon icon-menu-open'></i> </button>";
            
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
            'role_cd' => 'required|unique:pgsql.auth.roles',
            'role_nm' => 'required',
        ]);

        $create = !empty($request->create)  ? '1' : '0';
        $read   = !empty($request->read)    ? '1' : '0';
        $update = !empty($request->update)  ? '1' : '0';
        $delete = !empty($request->delete)  ? '1' : '0';

        $ruleTp = $create.$read.$update.$delete;
        
        $role = AuthRole::create([
            'role_cd'    => $request->role_cd,
            'role_nm'    => $request->role_nm,
            'rule_tp'    => $ruleTp,
            'created_by' => Auth::user()->user_id
        ]);

        \LogActivityHelpers::saveLog(
            $logTp = 'create', 
            $logNm = "Menambah Data Autorisasi $role->role_id - $role->role_nm", 
            $table = $role->getTable(), 
            $newData = $role
        );

        return response()->json(['status' => 'ok'],200); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function show($id){
        $data = AuthRole::find($id);

        if($data){
            return response()->json(['status' => 'ok', 'data' => $data],200);
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
            'role_nm' => 'required',
        ]);

        $create = !empty($request->create)  ? '1' : '0';
        $read   = !empty($request->read)    ? '1' : '0';
        $update = !empty($request->update)  ? '1' : '0';
        $delete = !empty($request->delete)  ? '1' : '0';

        $ruleTp = $create.$read.$update.$delete;
        
        $role = AuthRole::find($id);
        $oldData = clone $role;

        $role->role_cd    = $request->role_cd;
        $role->role_nm    = $request->role_nm;
        $role->rule_tp    = $ruleTp;
        $role->created_by = Auth::user()->user_id;

        $role->save();
        \LogActivityHelpers::saveLog(
            $logTp   = 'update', 
            $logNm   = "Mengubah Data Autorisasi $role->role_cd - $role->role_nm", 
            $table   = $role->getTable(), 
            $newData = $role,
            $oldData = $oldData
        );

		$this->saveRoleMenu($request);

        return response()->json(['status' => 'ok'],200); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function destroy($id){
        DB::transaction(function () use($id) {
            $data = AuthRole::find($id);
            \LogActivityHelpers::saveLog(
                $logTp   = 'delete', 
                $logNm   = "Menghapus Data Autorisasi $id",
                $table   = $data->getTable(), 
                $newData = NULL,
                $oldData = $data
            );

            AuthRoleMenu::destroy($id);
            AuthRole::destroy($id);
            
        });

        return response()->json(['status' => 'ok'],200);
    }

    function detail(Request $request, $id){
        $filename_page = 'detail';
        $title         = 'Data Autorisasi';
        $role          = AuthRole::find($id);
        $roleMenu      = AuthRoleMenu::mGetRoleMenu($id);

        for ($i=1; $i <= 4; $i++) {
			$data['menu_level_'.$i] = AuthMenu::where('menu_level',$i)->orderBy('menu_no')->get();
			
			foreach ($data['menu_level_'.$i] as $item) { 
				$item->status='';
                
                foreach ($roleMenu as $k) {	
					if($item->menu_cd == $k->menu_cd){
						$item->status='checked';
					}
				}
			}
        }
        
        return view('sistem.' . $this->folder_path . '.' . $filename_page, compact('title', 'data', 'role'));
    }

    function roleMenu(Request $request){
        $data = AuthRoleMenu::join('auth.menus as menu','role_menus.menu_cd','=','menu.menu_cd')
                ->where('role_menus.role_cd',$request->role_cd)
                ->select('role_menus.role_cd', 'menu.menu_cd',DB::Raw("concat(repeat('&nbsp',(menu_level-1) * 3),' ',menu_nm) as menu_nm"),'menu_root','menu_level','menu_no','menu_url', 'menu_image')
                ->distinct();

        return DataTables::of($data)
        ->addColumn('actions',function($data){
            $actions = '';
            /* $actions .= "<button type='button' id='ubah'  class='btn btn-warning btn-sm legitRipple'><i class='fa fa-pencil'></i> </button> &nbsp";
            $actions .= "<button type='button' id='hapus' class='btn btn-danger btn-sm legitRipple'><i class='fa fa-trash-o'></i> </button> &nbsp";
            $actions .= "<button type='button' id='detail' class='btn btn-info btn-sm legitRipple'><i class='fa fa-expand'></i> </button>";
            
            return $actions; */
        })
        ->rawColumns(['menu_nm','actions'])
        ->make(true);
    }

    function saveRoleMenu(Request $request){
		if(!empty($request->oto)){
			DB::transaction(function () use($request) {
				AuthRoleMenu::destroy($request->role_cd);
		
				$oto=$request->oto;
				for ($i=0; $i < count($oto); $i++) { 
					$roleMenu = new AuthRoleMenu;
					
					$roleMenu->role_cd = $request->role_cd;
					$roleMenu->menu_cd = $oto[$i];
					$roleMenu->created_by = Auth::user()->user_id;
		
					$roleMenu->save();
				}
			});
			
			//return redirect()->back()->with('success','Update autorisasi menu berhasil');
        }
		else {
			DB::transaction(function () use($request) {
				AuthRoleMenu::destroy($request->role_cd);
			});
		}
    }
}
