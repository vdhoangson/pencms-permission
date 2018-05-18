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
use Route;
use VSPermission;

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
        
        if (!VSPermission::checkAccess($currentRoute)) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
