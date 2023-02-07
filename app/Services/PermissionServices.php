<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\UserRole;
use Illuminate\Support\Facades\Auth;

class PermissionServices {
    protected $model;
    public function __construct()
    {

    }
    public function getAll($request, $NotJson = null, $NotwithLimit = null){
        try{
            $data = Permission::all();
            if(!empty($request->active)){
                $data->where('active', $request->active);
            }
            if(empty($NotwithLimit)){
                return $result = $data->paginate($this->limit);
            }else{
                $result = $data;
            }
            if(empty($NotJson)){
                return response()->json($result);
            }else{
                return $result;
            }
        }catch(\Throwable $e){
            return response()->json($e);
        }
    }
    public function getById($id){
        try{
            $data = Permission::findOrFail($id);
            return response()->json($data);
        }catch(\Throwable $e){
            return response()->json($e);
        }

    }
    public function destroy($id){
        try{
            $data = Permission::findOrFail($id);
            $data->delete();
            return response()->json($data);
        }catch(\ErrorException $e){
            return response()->json($e);
        }

    }
}
