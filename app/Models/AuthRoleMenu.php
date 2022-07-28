<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class AuthRoleMenu extends Model{
    protected $table            = 'auth.role_menus';
    protected static $tableName = 'auth.role_menus';
    protected $primaryKey       = 'role_cd'; 
    public $incrementing        = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'role_cd', 'menu_cd', 'created_by','update_by'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public static function mGetRoleMenu($id){
        $data = DB::table(Self::$tableName.' as role_menu')
                ->join('auth.menus as menu','role_menu.menu_cd','=','menu.menu_cd')
                ->where('role_menu.role_cd',$id)
                ->select('menu.menu_cd','menu_nm','menu_root','menu_level','menu_no','menu_url', 'menu_image')
                ->distinct()
                ->get();

        return $data;
    }
}
