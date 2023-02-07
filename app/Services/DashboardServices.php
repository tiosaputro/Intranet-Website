<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Controller;
use App\Models\Dashboard;
use App\Models\Menu;
use App\Models\News;
use App\Models\Role;
use App\Models\UserRole;
use Illuminate\Support\Facades\Auth;

class DashboardServices {
    protected $model;
    private $limit;
    public function __construct()
    {
        $this->limit = 10;
    }
    public function getAllWithFilter($request, $NotJson = null, $NotwithLimit = null){ //default true / null
        try{
            $data = Dashboard::query();
            if(!empty($request->keyword)){
                //filter search
                $key = $request->keyword;
                $data->where(function($query) use ($key){
                    $query->where('code', 'like','%'.$key.'%');
                });
            }
            //filter user
            if(!empty($request->created_by)){
                $data->where('dashboard.created_by', $request->created_by);
            }

            if(empty($NotwithLimit)){
                $result = $data->paginate($this->limit);
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
            $data = Dashboard::all();
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
            $data = Dashboard::findOrFail($id);
            return $data;
        }catch(\Throwable $e){
            return response()->json($e);
        }

    }
    public function destroy($id){
        try{
            $data = Dashboard::findOrFail($id);
            $data->delete();
            return response()->json($data);
        }catch(\ErrorException $e){
            return response()->json($e);
        }

    }
    public function api_search($keyword){
        try{
            $result = Dashboard::where(function($query) use ($keyword){
                $query->where('code', 'like','%'.$keyword.'%')
                      ->orWhere('id', 'like','%'.$keyword.'%');
            })->paginate(20);
            return response()->json($result);
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }
    public function search($keyword = null){
        try{
            $result = Dashboard::where(function($query) use ($keyword){
                $query->whereRaw("LOWER(code) like '%".$keyword."%'")
                      ->orWhereRaw("LOWER(id) like '%".$keyword."%'");
            })
            ->get();
            return $result;
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

}
