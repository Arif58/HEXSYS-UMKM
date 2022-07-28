<?php 
if (! function_exists('roleUser')) {
    function roleUser(){
        $userId = Auth::user()->user_id;

        $roleUser=App\Models\AuthRoleUser::where('user_id', $userId)->first();
        return $roleUser->role_cd;
    }
}

if (! function_exists('isRoleUser')) {
    function isRoleUser($roleParam){
        $userId = Auth::user()->user_id;

        $roleUser=App\Models\AuthRoleUser::where('user_id',$userId)
                ->where('role_cd',$roleParam)
                ->count();
                
        if ($roleUser == 1) {
            return TRUE;
        }else {
            return FALSE;
        }
    }
}

if (! function_exists('getRuleofRoleCd')) {
    function getRuleofRoleCd(){
        $roleCd = roleUser();

        $role   = App\Models\AuthRole::find($roleCd);
        return $role->rule_tp;
    }
}