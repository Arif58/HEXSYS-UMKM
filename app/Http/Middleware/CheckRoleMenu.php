<?php

namespace App\Http\Middleware;
use Auth;
use App\Models\AuthRoleMenu;
use Closure;

class CheckRoleMenu{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $menuCd = NULL){
        $roleUser=roleUser();

        $roleMenu = AuthRoleMenu::where('role_cd', $roleUser)
                    ->where('menu_cd', $menuCd)
                    ->count();
                
        if ($roleMenu == 0) {
            return abort(404);
        }

        return $next($request);
    }
}
