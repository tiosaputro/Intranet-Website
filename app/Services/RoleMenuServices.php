<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\RoleMenuPermission;
use App\Models\UserRole;
use Illuminate\Support\Facades\Auth;

// interface UserServices{
//     public function getAll(Request $request);
//     public function getById($id);
//     public function store();
//     public function update();
//     public function delete();
// }

class RoleMenuServices {
    protected $model;
    private $limit;
    public function __construct()
    {
        $this->limit = 10;
    }
    public function getAll($request, $NotwithLimit = null){
        try{
            $data = RoleMenuPermission::all();
            if(!empty($request->active)){
                $data->where('active', $request->active);
            }
            if(empty($NotwithLimit)){
                return $result = $data->paginate($this->limit);
            }else{
                return $data;
            }
        }catch(\Throwable $e){
            return response()->json($e);
        }
    }
    public function getByRole($roleid, $menuslug = null){
        try{
            $data = RoleMenuPermission::where('role_id', $roleid)->get();
            if(!empty($menuslug)){
                $pluck = collect($data)->map(function($row){
                    return $row->menu_id.'_'.$row->permission_slug;
                });
                return response()->json($pluck);
            }
            return response()->json($data);
        }catch(\Throwable $e){
            return response()->json($e);
        }
    }
    public function getById($id){
        try{
            $data = RoleMenuPermission::findOrFail($id);
            return response()->json($data);
        }catch(\Throwable $e){
            return response()->json($e);
        }

    }
    public function destroy($id){
        try{
            $data = RoleMenuPermission::findOrFail($id);
            $data->delete();
            return response()->json($data);
        }catch(\ErrorException $e){
            return response()->json($e);
        }

    }
}
