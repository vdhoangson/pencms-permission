<?php
/**
 * Package: vdhoangson/permission
 * Author: vdhoangson
 * Github: https://github.com/vdhoangson/permission
 * Web: vdhoangson.com
 */

namespace vdhoangson\Permission;

use Illuminate\Support\Facades\Auth;
use \DB;
use \Cache;

class VSPermission {
    protected $permissions;

    protected $role_id;
    /**
     * Create a new confide instance.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return void
     */
    public function __construct(){
        $this->role_id = Auth::user()->role_id;
        $this->permission();
    }

    public function checkAccess($route){
        if($this->permissions && in_array($route, $this->permissions)){
            return true;
        }
        return false;
    }

    private function permission(){
        
        if(!Cache::has('role.'.$this->role_id)){
            Cache::rememberForever('role.'.$this->role_id, function () {
                return DB::table('role')->where('id', $this->role_id)->first();
            });
        }

        $role = Cache::get('role.'.$this->role_id);

		if($role){
            if(!Cache::has('permission.'.$this->role_id)){
                $this->cachePermission($role);
            } else {
                $this->permissions = Cache::get('permission.'.$this->role_id);
            }
        }
    }
    
    private function cachePermission($role){
        $permissionTable = DB::table('permission')->whereIn('id', explode(',', $role->permissions))->get();
        foreach($permissionTable as $per){
            $this->permissions[] = $per->slug;
        }

        Cache::rememberForever('permission.'.$role->id, function () {
            return $this->permissions;
        });
    }

}
