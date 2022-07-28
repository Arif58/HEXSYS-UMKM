<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Illuminate\Http\Request;
use App\Models\AuthMenu;
use App\Models\AuthRoleMenu;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

use App\Models\ErpCmTrx;
use App\Models\InvPoPurchaseOrder;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $title	= "Beranda";
        $role	= roleUser();
        $menus	= AuthMenu::select(
					"menus.menu_nm as name",
					"menus.menu_url as url",
					"menus.menu_image as icon",
				)
				->join('auth.role_menus as rolemenu','rolemenu.menu_cd','menus.menu_cd')
				->where('rolemenu.role_cd',$role)
				->where('menus.menu_level',1)
				->orderBy('menus.menu_no','asc')
				->get();
				
		$approvalcm = $this->getApprovalCm();
		$approvalpo = $this->getApprovalPo();

        return view('home', compact('title','menus','approvalcm','approvalpo'));
    }
	
	function getApprovalCm(){
		$compCd = 'HEXSYS';
		
		$approvalCm = ErpCmTrx::with("com_supplier","com_customer")
                ->where(function($where) use($compCd){
					$unit = empty(Auth::user()->unit_cd) ? '' : Auth::user()->unit_cd;
					if ($unit !== '') {
                        $where->where('unit_cd',[$unit]);
                    }
					
					/* $tanggalStart = formatDate(date('Y/m/1'));
					$tanggalEnd   = formatDate(date('Y/m/d'));
					$where->whereRaw("trx_date::date between '$tanggalStart' and '$tanggalEnd'"); */
					
                    $role = roleUser();
                    $where->whereRaw("erp.fn_cm_get_group_approval_st('$compCd','$role', cm_cd) = 1");
                    $where->whereIn('cm_st',[1,2]);
                })->count();
				
		return $approvalCm == 0 ? false : true;
    }
	
	function getApprovalPo(){
		$compCd = 'HEXSYS';
		
		$approvalPo = InvPoPurchaseOrder::select("*")
                ->where(function($where) use($compCd){
					$unit = empty(Auth::user()->unit_cd) ? '' : Auth::user()->unit_cd;
					if ($unit !== '') {
                        $where->where('unit_cd',[$unit]);
                    }
					/* if (Auth::user()->user_id == 'manager1') {
                        $where->whereIn('unit_cd',['TK','SD1','SD2','SD3','SMP']);
                    } */
					
					/* $tanggalStart = formatDate(date('Y/m/1'));
					$tanggalEnd   = formatDate(date('Y/m/d'));
					$where->whereRaw("trx_date::date between '$tanggalStart' and '$tanggalEnd'"); */
					
                    $role = roleUser();
                    $where->whereRaw("inv.fn_po_get_group_approval_st('$compCd','$role', po_cd::varchar) = 1");
                    $where->whereIn('po_st',['INV_TRX_ST_1','INV_TRX_ST_2','INV_TRX_ST_5']);
                })->count();
		
		return $approvalPo == 0 ? false : true;
    }
}
