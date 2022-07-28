<?php

namespace App\Http\Controllers;

use URL;
use Auth;
use Illuminate\Http\Request;
use App\Models\AuthMenu;

class MenuController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    function __construct(){
        $this->middleware('auth');
    }

    public function getMenuSide(){
        return AuthMenu::where('menu_level',1)
                ->join('auth.role_menus as rm','rm.menu_cd','=','menus.menu_cd')
                ->join('auth.role_users as ru','ru.role_cd','=','rm.role_cd')
                ->where('ru.user_id',Auth::user()->user_id)
                ->select('menus.menu_cd','menu_nm','menu_root','menu_level','menu_no','menu_url', 'menu_image')
                ->orderBy('menu_no')
                ->distinct()
                ->get();
    }

    function getActiveMenus(){
        $activeMenu = array();
        $routePath  = request()->path();

        if(request()->route('id')){
            $routePath = str_replace("/".request()->route('id'),"",$routePath);
        }

        $data = AuthMenu::where('menu_url',$routePath)->first();
        return Self::getMenuById($data ? $data->menu_cd : '', $activeMenu);
    }

    static function getMenuById($id, $activeMenu){
        $data = AuthMenu::find($id);
        if ($data) {
            array_push($activeMenu, $data->menu_cd);
            if ($data->menu_root) {
                return Self::getMenuById($data->menu_root, $activeMenu);
            }
        }

        return $activeMenu;
    }

    // function getMenuSideObsolete($segment1 = '',$segment2 = '',$segment3 = '',$segment4 = '') {
    //     $id=Auth::user()->user_id;

    //     $data = AuthMenu::getUserMenu($id);

    //     $active_menu_lists = array();
        
    //     $ulrSegement = array($segment1);
    //     $ulrSegement = implode('/', $ulrSegement);
    //     $ulrSegement = trim($ulrSegement, '/');
    //     array_push($active_menu_lists,$ulrSegement);
        
    //     $ulrSegement = array($segment1, $segment2);
    //     $ulrSegement = implode('/', $ulrSegement);
    //     $ulrSegement = trim($ulrSegement, '/');
    //     array_push($active_menu_lists,$ulrSegement);

    //     $ulrSegement = array($segment1, $segment2,$segment3);
    //     $ulrSegement = implode('/', $ulrSegement);
    //     $ulrSegement = trim($ulrSegement, '/');
    //     array_push($active_menu_lists,$ulrSegement);

    //     $ulrSegement = array($segment1, $segment2,$segment3,$segment4);
    //     $ulrSegement = implode('/', $ulrSegement);
    //     $ulrSegement = trim($ulrSegement, '/');
    //     array_push($active_menu_lists,$ulrSegement);

    //     $menu_active_tp = AuthMenu::getUserMenu($id,$active_menu_lists);
    //     $menu_active = array();
    //     if(count($menu_active_tp) > 0) {
    //         $menu_active_tp = json_decode(json_encode($menu_active_tp), true);
    //         if(count($menu_active_tp) > 0) {
    //             foreach($menu_active_tp as $menu_aja){
    //                 array_push($menu_active, $menu_aja['menu_cd']);
    //             }
    //         }else{
    //                 $menu_active = [];
    //             }
    //         }
    //     // dd($menu_active_tp);
    //     $side = [];
    //     $side_status;
    //     foreach ($data as $key => $menu) {
    //         if ($menu->menu_level == 1) {
    //             $side['level1'][] = $menu;
    //         } elseif ($menu->menu_level == 2) {
    //             $side['level2'][$menu->menu_root][] = $menu;
    //         } elseif ($menu->menu_level == 3) {
    //             $side['level3'][$menu->menu_root][] = $menu;
    //         } elseif ($menu->menu_level == 4) {
    //             $side['level4'][$menu->menu_root][] = $menu;
    //         }
    //     }

    //     if(count($side) <= 0) {
    //         return '';
    //     }

    //     $menu_html = '';
    //     foreach ($side['level1'] as $key1 => $level1) {
    //         if (isset($side['level2'][$level1->menu_cd])) {
    //             $menu_html .= '<li class="nav-item nav-item-submenu';
    //             //add class active
    //             if(count($menu_active) > 0) {
    //                 if (in_array($level1->menu_cd, $menu_active)) {
    //                     $menu_html .= ' nav-item-expanded nav-item-open';
    //                 }
    //             }

    //             $menu_html .= ' ">';

    //             $menu_html .= '
    //                 <a href="#" class="nav-link"><i class="'.$level1->menu_image.'"></i> <span>'.$level1->menu_nm.'</span></a>
    //             ';

    //             //level 2 start
    //             $menu_html .= '<ul class="nav nav-group-sub" data-submenu-title="'.$level1->menu_nm.'">';
                
    //             foreach ($side['level2'][$level1->menu_cd] as $key2 => $level2) {
    //                 if (isset($side['level3'][$level2->menu_cd])) {
    //                     $menu_html .= '<li class="nav-item nav-item-submenu';
    //                     //add class active
    //                     if(count($menu_active) > 0) {
    //                         if (in_array($level2->menu_cd, $menu_active)) {
    //                             $menu_html .= ' nav-item-expanded nav-item-open';
    //                         }
    //                     }

    //                     $menu_html .= ' ">';

    //                     $menu_html .= '
    //                             <a href="#" class="nav-link"><i class="icon-circles"></i> '.$level2->menu_nm.'</a>
    //                         ';
                        
    //                     //level 3 start
    //                     $menu_html .= '<ul class="nav nav-group-sub" data-submenu-title="'.$level2->menu_nm.'">';
	// 	                foreach ($side['level3'][$level2->menu_cd] as $key3 => $level3) {
	// 	                    if (isset($side['level4'][$level3->menu_cd])) {
	// 	                        $menu_html .= '<li class="';
	// 	                        //add class active
	// 	                        if(count($menu_active) > 0) {
	// 	                            if (in_array($level3->menu_cd, $menu_active)) {
	// 	                                $menu_html .= ' nav-item-expanded nav-item-open';
	// 	                            }
	// 	                        }

	// 	                        $menu_html .= ' ">';

	// 	                        $menu_html .= '<a href="#" class="nav-link"><i class="icon-forward"></i> '.$level3->menu_nm.'</a>';

	// 	                        //level 4 start
	// 	                        $menu_html .= '<ul class="nav nav-group-sub" data-submenu-title="'.$level3->menu_nm.'">';
	// 	                        foreach ($side['level4'][$level3->menu_cd] as $key4 => $level4) {
	// 	                            $menu_html .= '<li class=" ';
	// 	                            //add class active
	// 	                            if ($level4->menu_url == $ulrSegement) {
	// 	                                $menu_html .= ' nav-item-open ';
	// 	                            }

	// 	                            $menu_html .= ' ">';
    //                                 $menu_html .= '<a href="'.url($level4->menu_url).'" class="nav-link"><i class="icon-forward"></i><span>' . $level4->menu_nm . '</span></a>';
    //                             }
	// 	                        $menu_html .= '
	// 	                                    </ul>';
	// 	                        // level 4 end
	// 	                    } else {
	// 	                        $menu_html .= '<li class=" ';
	// 	                        //add class active
	// 	                        if ($level3->menu_url == $ulrSegement) {
	// 	                            $menu_html .= ' nav-item-open ';
	// 	                        }
	// 	                        $menu_html .= ' ">';
    //                             $menu_html .= '<a href="'.url($level3->menu_url).'" class="nav-link"><i class="icon-forward"></i><span>' . $level3->menu_nm . '</span></a>';
    //                         }
	// 	                    $menu_html .= '
	// 	                                </li>';
	// 		                }
	// 	                $menu_html .= '
	// 	                            </ul>';
	// 		            //level 3 end
    //                 } else {
    //                     $menu_html .= '<li class=" nav-item';
    //                     //add class active
    //                     if ($level2->menu_url == $ulrSegement) {
    //                         $menu_html .= ' nav-item-open ';
    //                     }

    //                     $menu_html .= ' ">';
    //                     $menu_html .= '<a href="'.url($level2->menu_url).'" class="nav-link"><i class="icon-circles"></i><span>' . $level2->menu_nm . '</span></a>';
    //                 }
    //                 $menu_html .= '
    //                             </li>';
    //             }
    //             $menu_html .= '
    //                         </ul>';
    //             //level 2 end
    //         } else {
    //             $menu_html .= '
    //                     <li class="  nav-item';
    //             //add class active
    //             $openSt = '';
    //             if ($level1->menu_url == $ulrSegement) {
    //                 // $menu_html .= ' active ';
    //                 $openSt = 'active';
    //             }

    //             $menu_html .= ' ">';
    //             $menu_html .= '
    //                         <a href="'.url($level1->menu_url).'" class="nav-link '.$openSt.'"><i class="' . $level1->menu_image . '"></i> <span>' . $level1->menu_nm . '</span></a>';
    //         }
    //         $menu_html .= '
    //                     </li>';
    //     }

    //     return $menu_html;
    // }
}
