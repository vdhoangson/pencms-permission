<?php
/**
 * Package: vdhoangson/permission
 * Author: vdhoangson
 * Github: https://github.com/vdhoangson/permission
 * Web: vdhoangson.com
 */

namespace vdhoangson\Permission;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Foundation\AliasLoader;
use vdhoangson\Permission\VSPermission;

class VSPermissionServiceProvider extends ServiceProvider {
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Router $router) {
        $router->pushMiddlewareToGroup('VSPermissionMiddleware', \vdhoangson\Permission\VSPermissionMiddleware::class);

        $loader = AliasLoader::getInstance();
        $loader->alias('VSPermission', 'vdhoangson\Permission\VSPermissionFacade');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('VSPermission', function () {
            return new VSPermission();
        });
    }
}
