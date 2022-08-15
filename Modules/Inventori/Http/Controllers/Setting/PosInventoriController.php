<?php

namespace Modules\Inventori\Http\Controllers\Setting;

use Auth;


use DataTables;
use App\Models\AuthRole;
use App\Models\AuthUser;
use Illuminate\Support\Str;
use App\Models\AuthRoleUser;
use Illuminate\Http\Request;
use App\Models\InvInvItemType;
use App\Models\InvInvPosInventori;
use Illuminate\Support\Facades\DB;
use App\Helpers\LogActivityHelpers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class PosInventoriController extends Controller{
    private $folder_path = 'setting.pos-inventori';

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
        $title         = 'Data UMKM';
        // $typesumkm     = InvInvPosInventori::select(['region_cd','region_nm']);
        $roles      = AuthRole::getAllRoles(Auth::user()->role->role_cd);

        return view('inventori::' . $this->folder_path . '.' . $filename_page, compact('title','roles'));
    }

    /**
     * Display a listing of the resource for DataTables.
     *
     * @return \Illuminate\Http\Response
     */
    function getData(){

        $unit = Auth::user()->unit_cd;
        if ($unit != null){
			$data = InvInvPosInventori::select(
				'*',
				'user.user_nm',
				'user.email',
				'prop.region_nm as region_prop',
				'kab.region_nm as region_kab',
			)
			->leftJoin('auth.users as user', 'user.unit_cd', 'inv.inv_pos_inventori.pos_cd')
			->leftJoin('com_region as prop', 'prop.region_cd', 'inv.inv_pos_inventori.region_prop')
			->leftJoin('com_region as kab', 'kab.region_cd', 'inv.inv_pos_inventori.region_kab')
			//->leftjoin('inv.inv_pos_inventori as invpos','invpos.pos_cd','users.user_id')
			//->leftjoin('inv.inv_pos_inventori as pos','pos.pos_cd','invpos.pos_cd')
			//->leftjoin('inv.inv_pos as unit','unit.post_nm','users.user_nm');
			->where('inv.inv_pos_inventori.pos_cd', $unit);
			return DataTables::of($data)->make(true);
		} else {
			$data = InvInvPosInventori::select(
				'*',
				'user.user_nm',
				'user.email',
				'prop.region_nm as region_prop',
				'kab.region_nm as region_kab',
			)
			->leftJoin('auth.users as user', 'user.unit_cd', 'inv.inv_pos_inventori.pos_cd')
			->leftJoin('com_region as prop', 'prop.region_cd', 'inv.inv_pos_inventori.region_prop')
			->leftJoin('com_region as kab', 'kab.region_cd', 'inv.inv_pos_inventori.region_kab');
			//->leftjoin('inv.inv_pos_inventori as invpos','invpos.pos_cd','users.user_id')
			//->leftjoin('inv.inv_pos_inventori as pos','pos.pos_cd','invpos.pos_cd')
			//->leftjoin('inv.inv_pos as unit','unit.post_nm','users.user_nm');
			return DataTables::of($data)->make(true);
		}
    }

    function print(Request $request, $id) {
        $filename_page = 'print';
        $datas = InvInvPosInventori::select('*','pos_cd','pos_nm','description','postrx_st'
        ,'user.user_nm','user.user_id','user.password',)
        
        ->leftJoin('auth.users as user', 'user.unit_cd', 'inv.inv_pos_inventori.pos_cd')
        ->where('pos_cd', $id)->get();
        return view('inventori::' . $this->folder_path . '.' . $filename_page, compact('datas'));

    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    function store(Request $request){
        $this->validate($request,[
            'role_cd' => 'required',
            //'pos_cd' => 'required|unique:pgsql.inv.inv_pos_inventori|max:20',
            'pos_nm' => 'required|max:255',
        ]);

        // $pos            = new InvInvPosInventori;
        //$pos->pos_cd    = strtoupper($request->pos_cd);
		// $pos->pos_cd 	= InvInvPosInventori::getPosCd();
        // $pos->pos_nm    = $request->pos_nm;
        // $pos->postcode = $request->postcode;
        // $pos->phone = $request->phone;
        // $pos->address = $request->address;
        // $pos->mobile = $request->mobile;
        // $pos->fax = $request->fax;
        // $pos->email = $request->email;
        // $pos->npwp = $request->npwp;
        // $pos->pic = $request->pic;
        // $pos->pos_note = $request->pos_note;
        // $pos->region_prop = $request->region_prop;
        // $pos->region_kab = $request->region_kab;
        // $pos->region_kec = $request->region_kec;
        // $pos->region_kel = $request->region_kel;
        // $pos->description   = $request->description;
        // if($request->checkbox_transaksi == 'on'){
        //     $pos->postrx_st = '1';
        // } else {
		// 	$pos->postrx_st = '0';
		// }
        // $pos->created_by= Auth::user()->user_id;
        // $pos->save();

        DB::transaction(function () use($request) {

            $posCd = InvInvPosInventori::getPosCd();

            $pos = InvInvPosInventori::create([
                'pos_cd' 	    => $posCd,
                'pos_nm'        => $request->pos_nm,
                'postcode'      => $request->postcode,
                'phone'         => $request->phone,
                'address'       => $request->address,
                'mobile'        => $request->mobile,
                'fax'           => $request->fax,
                'email'         => $request->email,
                'npwp'          => $request->npwp,
                'pic'           => $request->pic,
                'pos_note'      => $request->pos_note,
                'region_prop'   => $request->region_prop,
                'region_kab'    => $request->region_kab,
                'region_kec'    => $request->region_kec,
                'region_kel'    => $request->region_kel,
                'description'   => $request->description,
                'created_by'    => Auth::user()->user_id
            ]);

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
                'unit_cd'    => $posCd,
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

            return $posCd;
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
        $pos = InvInvPosInventori::find($id);
        $roleUser   = AuthRoleUser::where('user_id',$id)->first();
        if($pos){
            return response()->json(['status' => 'ok', 'data' => $pos],200);
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
            'pos_nm' => 'required',
        ]);

        $pos = InvInvPosInventori::find($id);
        $pos->pos_cd     = $request->pos_cd;
        $pos->pos_nm     = $request->pos_nm;
        $pos->postcode = $request->postcode;
        $pos->phone = $request->phone;
        $pos->address = $request->address;
        $pos->mobile = $request->mobile;
        $pos->fax = $request->fax;
        $pos->email = $request->email;
        $pos->npwp = $request->npwp;
        $pos->pos_note = $request->pos_note;

        $pos->pic = $request->pic;
        $pos->region_prop = $request->region_prop;
        $pos->region_kab = $request->region_kab;
        $pos->region_kec = $request->region_kec;
        $pos->region_kel = $request->region_kel;
        $pos->description   = $request->description;

        if($request->checkbox_transaksi == 'on'){
            $pos->postrx_st = '1';
        } else {
			$pos->postrx_st = '0';
		}
        $pos->updated_by = Auth::user()->user_id;

        $pos->save();

        return response()->json(['status' => 'ok'],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function destroy($id){
        InvInvPosInventori::destroy($id);

        return response()->json(['status' => 'ok'],200);
    }

     /**
     * Display a listing of the resource for select2.
     *
     * @return \Illuminate\Http\Response
     */
    function getListData(Request $request){
        $searchParam = $request->get('term');
        $poss       = InvInvPosInventori::select("pos_cd as id", "pos_nm as text")
                        ->where("pos_nm", "ILIKE", "%$searchParam%")
                        ->get()
                        ->toArray();

        array_unshift($poss,array('id' => '','text'=>'=== Pilih Pos Inventori ==='));
        return response()->json($poss);
    }
    }
    
