<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Controller;
use App\Models\ModelHasRoles;
use App\Models\Role;
use App\Models\UserRole;
use Illuminate\Support\Facades\Auth;

// interface UserServices{
//     public function getAll(Request $request);
//     public function getById($id);
//     public function store();
//     public function update();
//     public function delete();
// }

class UserServices {
    private $limit;
    public function __construct()
    {
        $this->limit = 10;
    }
    public function userWithRole($request){
        $data = User::select('users.*','roles.id as role_id','roles.name as nama_role','roles.guard_name','roles.slug')
        ->leftJoin('user_roles', 'user_roles.user_id','users.id')
        ->leftJoin('roles','roles.id','user_roles.role_id')
        ->where('users.id','!=',Auth::user()->id)
        ->get();
        return $data;
    }
    public function getAll(){
        try{
            $data = User::all();
            return response()->json($data);
        }catch(\Throwable $e){
            return response()->json($e);
        }
    }
    public function getRole(){
        try{
            $data = Role::all();
            return response()->json($data);
        }catch(\Throwable $e){
            return response()->json($e);
        }
    }
    public function getAllWithRole($request){
        try{
            $data = User::where('id','!=',Auth::user()->id);
            if(!empty($request->keyword)){
                //filter search
                $key = $request->keyword;
                $data->where(function($query) use ($key){
                    $query->where('name', 'like','%'.$key.'%')
                          ->orWhere('email', 'like','%'.$key.'%');
                });
            }
            $result = $data->paginate($this->limit);
            $result->getCollection()->transform(function($row){
                $role = UserRole::select('roles.name')->join('roles', 'roles.id','user_roles.role_id')
                ->where('user_roles.user_id', $row->id)->get()->toArray();
                $row->role = $role;
                return $row;
            });
            // return response()->json($result);
            return $result;
        }catch(\ErrorException $e){
            return response()->json($e);
        }
    }

    public function getById($id){
        try{
            $data = User::where('id',$id)->first();
            $data['role'] = UserRole::where('user_id', $id)->get();
            return response()->json($data);
        }catch(\Throwable $e){
            return response()->json($e);
        }

    }
    public function destroy($id){
        try{
            $data = User::findOrFail($id);
            $data->delete();
            return response()->json($data);
        }catch(\ErrorException $e){
            return response()->json($e);
        }

    }
    public function resetRole($id, $request){
        try{
            $cek = UserRole::whereRaw("to_char(user_id) = '".$id."'")->first();
            if(!empty($cek)){
                $delete = UserRole::whereRaw("to_char(user_id) = '".$id."'");
                $delete->delete();
            }
            //multiple role
            if(!empty($request->role)){
                foreach($request->role as $val){
                    $save = UserRole::create([
                        'id' => generate_id(),
                        'user_id' => $id,
                        'role_id' => $val,
                        'created_by' => Auth::user()->id,
                        'updated_by' => Auth::user()->id,
                        'active' => $request->active,
                    ]);
                }
            }
            return $save->id;
        }catch(\ErrorException $e){
            return $e->getMessage();
        }
    }
    public function search($keyword){
        try{
            $result = User::where(function($query) use ($keyword){
                $query->where('name', 'like','%'.$keyword.'%')
                      ->orWhere('email', 'like','%'.$keyword.'%');
            })->paginate(20);
            return response()->json($result);
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }
}
