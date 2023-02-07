<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Controller;
use App\Models\Directory;
use App\Models\KnowledgeSharing;
use App\Models\News;
use App\Models\Role;
use App\Models\UserRole;
use Illuminate\Support\Facades\Auth;

class DirectoryServices {
    protected $model;
    private $limit;
    public function __construct()
    {
        $this->limit = 10;
        $this->model = new Directory();
    }
    public function getAllWithFilter($request, $NotJson = null, $NotwithLimit = null){ //default true / null
        try{
            $data = $this->model::query();
            $data->join('users','users.id','directories.created_by');
            $data->select('directories.*','users.name as created_by_name');
            if(!empty($request->q) && $request->q != 'all'){
                //filter search
                $key = $request->q;
                $data->where(function($query) use ($key){
                    $query->whereRaw("LOWER(directories.name) like '%$key%'")
                          ->orWhereRaw("LOWER(directories.departement) like '%$key%'")
                          ->orWhereRaw("to_char(directories.ext) like '%$key%'")
                          ->orWhereRaw("to_char(directories.phone) like '%$key%'")
                          ->orWhereRaw("LOWER(directories.position) like '%$key%'")
                          ->orWhereRaw("to_char(directories.lantai) like '%$key%'");
                });
            }
            if(!empty($request->directory)){
                $data->where('directories.category','like', '%'.$request->category.'%');
            }
            if(!empty($request->active)){
                $data->where('directories.active', $request->active);
            }
            if(!empty($request->id)){
                $data->where('directories.id', $request->id);
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
            $data = $this->model::all();
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
            $data = $this->model::findOrFail($id);
            return $data;
        }catch(\Throwable $e){
            return response()->json($e);
        }

    }
    public function destroy($id){
        try{
            $data = $this->model::findOrFail($id);
            $data->delete();
            return response()->json($data);
        }catch(\ErrorException $e){
            return response()->json($e);
        }

    }
    public function api_search($keyword){
        try{
            $result = $this->model::where(function($query) use ($keyword){
                $query->where('title', 'like','%'.$keyword.'%')
                      ->orWhere('content', 'like','%'.$keyword.'%')
                      ->orWhere('meta_tags', 'like','%'.$keyword.'%');
            })->paginate(20);
            return response()->json($result);
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }
    public function search($keyword = null){
        try{
            $result = $this->model::where(function($query) use ($keyword){
                $query->whereRaw("LOWER(title) like '%".$keyword."%'")
                      ->orWhereRaw("LOWER(content) like '%".$keyword."%'")
                      ->orWhereRaw("LOWER(meta_tags) like '%".$keyword."%'");
            })->get();
            return $result;
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    public function getTag($category = null){
        $tagging = $this->model::query();
        if(!empty($category)){
            $tagging->where('category','like','%'.$category.'%');
        }
        $tags = $tagging->get();
        $tmp = [];
        foreach($tags as $idx => $row){
            if(!empty($row->meta_tags)){
                $tag = json_decode($row->meta_tags,1);
                foreach($tag as $field){
                    if(!in_array($field, $tmp)){
                        array_push($tmp, $field);
                    }
                }
            }
        }
        return $tmp;
    }
}
