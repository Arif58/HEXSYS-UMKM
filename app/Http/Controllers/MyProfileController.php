<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use DataTables;
use Illuminate\Http\Request;
use App\Models\AuthUser;
use App\Models\AuthRole;
use App\Models\AuthRoleUser;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class MyProfileController extends Controller
{
    private $folder_path = 'user';
    
    function __construct(){
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function index(){
        $id         = Auth::user()->user_id;
        $pageName   = 'myprofile';
        $title      = 'Profil User';
        $dataUser   = AuthUser::mGetDetailUser($id)->first();
        $roles      = AuthRole::all(['role_cd','role_nm']);

        return view($pageName, compact('title', 'dataUser', 'roles'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function show($id){
        $user = AuthUser::mGetDetailUser($id)->first();

        if($user){
            return response()->json(['status' => 'ok', 'data' => $user],200);
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
    function update(Request $request){
        $this->validate($request,[
            'user_nm' => 'required',
            'email'   => 'nullable',
            'phone'   => 'nullable',
        ]);

        $id = Auth::user()->user_id;

        $create = !empty($request->create)  ? '1' : '0';
        $read   = !empty($request->read)    ? '1' : '0';
        $update = !empty($request->update)  ? '1' : '0';
        $delete = !empty($request->delete)  ? '1' : '0';

        $ruleTp = $create.$read.$update.$delete;

        DB::transaction(function() use($id, $request)  {
            $user = AuthUser::find($id);

            $user->user_nm    = $request->user_nm;
            $user->email      = $request->email;
            $user->phone      = $request->phone;
            // $user->rule_tp    = $ruleTp;
            $user->updated_by = Auth::user()->user_id;

            $user->save();
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
            AuthRoleUser::destroy($id);
            AuthUser::destroy($id);
        });

        return response()->json(['status' => 'ok'],200);
    }

    function changeImage(Request $request){
        DB::transaction(function () use($request) {

            $user       = AuthUser::find(Auth::user()->user_id);

            if ($request->image == NULL) {
                $user->image = NULL;
            } else {
                $image          = $request->image;  // your base64 encoded
                $image          = str_replace('data:image/png;base64,', '', $image);
                $image          = str_replace(' ', '+', $image);
                //$imageName      = $user->user_id.'.'.'png';
				$imageName      = 'user-' .$user->user_id.'.'.'png';
    
                //\File::put(storage_path('app/public/user-picture/'.$imageName), base64_decode($image));
				\File::put(storage_path('app/public/file/image/'.$imageName), base64_decode($image));
    
                //$user->image = '/storage/user-picture/'.$imageName;
				$user->image = $imageName;
            }

            $user->save();
        });

        return response()->json(['status' => 'ok'],200);
    }

    function changePassword(Request $request){
        $this->validate($request,[
            'password'        => 'required',
            'repeat_password' => 'required',
        ]);

        if ($request->password == $request->repeat_password) {
            $user = AuthUser::find(Auth::user()->user_id);
			if(Hash::check($request->old_password, $user->password)){
                $user->password = Hash::make($request->password);
                $user->updated_by = Auth::user()->user_id;
                $user->save();
                return response()->json(['status' => 'ok'],200);
            } else {
                return response()->json(['status' => 'failed' , 'message' => 'Old Password Mismatch'],200);    
            }

            return response()->json(['status' => 'ok'],200);
        }else {
            return response()->json(['status' => 'failed' , 'message' => 'Password Mismatch'],200);
        }
    }
}
