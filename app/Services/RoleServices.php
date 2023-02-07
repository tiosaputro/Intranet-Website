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

class RoleServices {
    protected $model;
    private $limit;
    public function __construct()
    {
        $this->limit = 10;
    }
    public function getAll($request, $NotwithLimit = null){
        try{
            $data = Role::with('hasRoleMenuPermission', 'hasUserRole');

            if(!empty($request->active)){
                $data->where('active', $request->active);
            }
            if(empty($NotwithLimit)){
                $result = $data->paginate($this->limit);
                return $result;
            }
            return $data;
        }catch(\Throwable $e){
            return response()->json($e);
        }
    }
    public function getById($id){
        try{
            $data = Role::findOrFail($id);
            return response()->json($data);
        }catch(\Throwable $e){
            return response()->json($e);
        }

    }
    public function destroy($id){
        try{
            RoleMenuPermission::where('role_id', $id)->delete();
            $data = Role::findOrFail($id);
            $data->delete();
            return response()->json($data);
        }catch(\ErrorException $e){
            return response()->json($e);
        }

    }
}
