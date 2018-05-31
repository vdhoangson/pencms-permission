<?php
/**
 * Package: vdhoangson/permission
 * Author: vdhoangson
 * Github: https://github.com/vdhoangson/permission
 * Web: vdhoangson.com
 */

namespace vdhoangson\Permission;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use VSPermission, Route;

class VSPermissionMiddleware {
    protected $auth;

    public function __construct(Guard $auth) {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure $next
     * @param int|string $role
     * @return mixed
     * @throws RoleDeniedException
     */
    public function handle($request, Closure $next) {
        $currentRoute = Route::currentRouteName();
        
        if(!$this->auth->check()){
            return response()->redirect()->route('login');
        }

        if (!VSPermission::checkAccess($currentRoute)) {
            return response()->view('error.permission');
        }

        return $next($request);
    }
}
