<?php

namespace App\Http\Controllers\Admin;

use DB;
use Auth;
use DataTables;
use App\Models\AuthRole;
use App\Models\AuthUser;
use App\Models\AuthRoleUser;
use Illuminate\Http\Request;
use App\Models\PublicComUnit;
use App\Models\PublicComCompany;

use App\Models\InvInvPosInventori;
use App\Helpers\LogActivityHelpers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private $folder_path = 'admin.user';

    function __construct(){
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function index(){
        $pageName   = 'index';
        $title      = 'Kelola Data User';
        $roles      = AuthRole::getAllRoles(Auth::user()->role->role_cd);
        $companies  = PublicComCompany::all(['comp_cd','comp_nm']);
		$unit  		= InvInvPosInventori::all(['pos_cd','pos_nm']);
        \LogActivityHelpers::saveLog(
            $logTp = 'visit',
            $logNm = "Membuka Menu $title"
        );

        return view('sistem.' . $this->folder_path . '.' . $pageName, compact('title','roles','companies','unit'));
    }

    /**
     * Display a listing of the resource for datatables.
     *
     * @return \Illuminate\Http\Response
     */
    function getData(){
        $data = AuthUser::select(
                    'users.user_id',
                    'user_nm',
                    'email',
                    'roles.role_cd',
                    'role_nm',
                    'users.updated_at as last_login'
                    )
                ->join('auth.role_users','role_users.user_id','users.user_id')
                ->join('auth.roles','roles.role_cd','role_users.role_cd');

        if (!isRoleUser('superuser')) {
            $data->where('role_users.role_cd','!=','superuser');
        }

        return DataTables::of($data)
        ->addColumn('actions',function($data){
            $actions = '';
            $actions .= "<button type='button' id='profil' class='btn btn-info btn-flat btn-sm' data-toggle='tooltip' data-placement='top' title='Profil User'><i class='icon icon-menu-open'></i> </button>";

            return $actions;
        })
        ->rawColumns(['actions'])
        ->make(true);
    }

    function profil($id){
        $pageName   = 'profil';
        $title      = 'Profil User';
        $dataUser   = AuthUser::mGetDetailUser($id)->first();
        if($dataUser){
            if($dataUser->role_cd == 'superuser' && $id != Auth::user()->user_id){
                abort(404);
                // return response()->json(['status' => 'failed', 'data' => 'not found'],200);
            }
            $roles      = AuthRole::getAllRoles(Auth::user()->role->role_cd);
            $companies  = PublicComCompany::all(['comp_cd','comp_nm']);
			$unit  		= InvInvPosInventori::all(['pos_cd','pos_nm']);
            \LogActivityHelpers::saveLog(
                $logTp = 'visit',
                $logNm = "Membuka Menu $title" . " " . $dataUser->user_nm
            );

            return view('sistem.' . $this->folder_path . '.' . $pageName, compact('title', 'dataUser', 'roles','companies','unit'));
        } else {
            abort(404);
            // return response()->json(['status' => 'failed', 'data' => 'not found'],200); //choose 1
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
            'user_id' => 'required|unique:pgsql.auth.users',
            'user_nm' => 'required',
            'role_cd' => 'required',
            'password'=> 'required',
            'email'   => 'required|unique:pgsql.auth.users',
        ]);

        DB::transaction(function () use($request) {

            $create = !empty($request->create)  ? '1' : '0';
            $read   = !empty($request->read)    ? '1' : '0';
            $update = !empty($request->update)  ? '1' : '0';
            $delete = !empty($request->delete)  ? '1' : '0';

            //$ruleTp = $create.$read.$update.$delete;
			$ruleTp = '1111';

            $user = AuthUser::create([
                'user_id'    => $request->user_id,
                'user_nm'    => $request->user_nm,
                'email'      => $request->email,
                'password'   => Hash::make($request->password),
                'user_tp'    => $request->role_cd,
                'rule_tp'    => $ruleTp,
                'comp_cd'	 => $request->comp_cd,
                'unit_cd'    => $request->unit_cd,
                'created_by' => Auth::user()->user_id
            ]);
            \LogActivityHelpers::saveLog(
                $logTp = 'create',
                $logNm = "Menambah Data User $user->user_id - $user->user_nm",
                $table = $user->getTable(),
                $newData = $user
            );


            $roleUser = AuthRoleUser::create([
                'role_cd'    => $request->role_cd,
                'user_id'    => $user->user_id,
                'created_by' => Auth::user()->user_id
            ]);
        });

        return response()->json(['status' => 'ok'],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function show($id){
        $user       = AuthUser::find($id);
        $roleUser   = AuthRoleUser::where('user_id',$id)->first();

        if($user){
            return response()->json(['status' => 'ok', 'data' => $user, 'roles' => $roleUser],200);
        }else{
            return response()->json(['status' => 'failed', 'data' => 'not found'],200);
        }
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
            'user_nm' => 'required',
            'role_cd' => 'required',
            'email'   => 'nullable',
        ]);

        $update = DB::transaction(function() use($id, $request)  {
            $create = !empty($request->create)  ? '1' : '0';
            $read   = !empty($request->read)    ? '1' : '0';
            $update = !empty($request->update)  ? '1' : '0';
            $delete = !empty($request->delete)  ? '1' : '0';

            $ruleTp = $create.$read.$update.$delete;

            $user             = AuthUser::find($id);
            $oldData = clone $user;

            $user->user_nm    = $request->user_nm;
            $user->email      = $request->email;
            //$user->rule_tp    = $ruleTp;
            $user->comp_cd 	  = $request->comp_cd;
			$user->unit_cd 	  = $request->unit_cd;
			$user->updated_by = Auth::user()->user_id;
            $user->save();

            \LogActivityHelpers::saveLog(
                $logTp   = 'update',
                $logNm   = "Mengubah Data User $user->user_cd - $user->user_nm",
                $table   = $user->getTable(),
                $newData = $user,
                $oldData = $oldData
            );

            $roleUser             = AuthRoleUser::find($id);
            $roleUser->role_cd    = $request->role_cd;
            $roleUser->updated_by = Auth::user()->user_id;
            $roleUser->save();

            return $user;
        });

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
            $data = AuthUser::find($id);
            \LogActivityHelpers::saveLog(
                $logTp   = 'delete',
                $logNm   = "Menghapus Data User $id",
                $table   = $data->getTable(),
                $newData = NULL,
                $oldData = $data
            );

            AuthRoleUser::destroy($id);
            AuthUser::destroy($id);
        });

        return response()->json(['status' => 'ok'],200);
    }

    function changeImage(Request $request, $id){
        DB::transaction(function () use($request, $id) {

            $user       = AuthUser::find($id);

            if ($request->image == NULL) {
                $user->image = NULL;
            } else {
                $image          = $request->image;  // your base64 encoded
                $image          = str_replace('data:image/png;base64,', '', $image);
                $image          = str_replace(' ', '+', $image);
                //$imageName      = $user->user_id.'.'.'png';
				$imageName      = 'user-' .$user->user_id.'.'.'png';

                \File::put(storage_path('app/public/file/image/'.$imageName), base64_decode($image));

                //$user->image = '/storage/file/image/'.$imageName;
				$user->image = $imageName;
            }

            $user->save();

        });

        return response()->json(['status' => 'ok'],200);
    }

    function changePassword(Request $request){
        $this->validate($request,[
            'password'  => 'required',
            'repeat_password' => 'required',
        ]);

        if ($request->password == $request->repeat_password) {
            $user = AuthUser::find($request->user_id);

            $user->password = Hash::make($request->password);

            $user->save();

            return response()->json(['status' => 'ok'],200);
        }else {
            return response()->json(['status' => 'failed' , 'message' => 'Password Mismatch'],200);
        }
    }
}
