<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Role;
use App\Models\RoleMenuPermission;
use App\Models\UserRole;
use Illuminate\Support\Facades\Auth;

class MenuServices {
    protected $model;
    private $limit;
    public function __construct()
    {
        $this->limit = 10;
    }
    public function getAllWithFilter($request, $NotJson = null, $NotwithLimit = null){
        try{
            $data = Menu::select('menu.*');
            $data->selectRaw("(SELECT mn.menu_name FROM menu mn WHERE mn.id = menu.is_parent) AS parent_name");
            if(!empty($request->keyword)){
                //filter search
                $key = $request->keyword;
                $data->where(function($query) use ($key){
                    $query->where('menu_name', 'like','%'.$key.'%')
                          ->orWhere('slug', 'like','%'.$key.'%');
                });
            }
            if(!empty($request->active)){
                $data->where('active', $request->active);
            }
            if(!empty($request->id)){
                $data->where('knowledge_sharing.id', $request->id);
            }
            if(empty($NotwithLimit)){
                return $result = $data->paginate($this->limit);
            }else{
                $result = $data;
            }
            if(empty($NotJson)){
                return response()->json($result);
            }else{
                return $result->get();
            }

        }catch(\ErrorException $e){
            return response()->json($e);
        }
    }
    public function getAll($request){
        try{
            $data = Menu::all();
            if(!empty($request->active)){
                $data->where('active', $request->active);
            }
            return response()->json($data);
        }catch(\Throwable $e){
            return response()->json($e);
        }
    }
    public function getById($id){
        try{
            $data = Menu::findOrFail($id);
            return response()->json($data);
        }catch(\Throwable $e){
            return response()->json($e);
        }

    }
    public function destroy($id){
        try{
            //check if menu setting on role_menu_permission
            $check = RoleMenuPermission::where('menu_id', $id)->first();
            if(empty($check)){
                $data = Menu::findOrFail($id);
                //delete child
                $child = Menu::where('is_parent', $id)->get();
                if(count($child) > 0){
                    foreach($child as $ch){
                        $ch->delete();
                    }
                }
                $data->delete();
                return response()->json($data);
            }else{
                return response()->json(['message' => 'Menu is setting on role menu permission', 'status' => 'error'],500);
            }
        }catch(\ErrorException $e){
            return response()->json($e->getMessage());
        }

    }
    public function search($keyword){
        try{
            $result = Menu::where(function($query) use ($keyword){
                $query->where('menu_name', 'like','%'.$keyword.'%')
                      ->orWhere('slug', 'like','%'.$keyword.'%');
            })->paginate(20);
            return response()->json($result);
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }
}
