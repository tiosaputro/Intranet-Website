<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Controller;
use App\Models\KnowledgeSharing;
use App\Models\News;
use App\Models\Role;
use App\Models\UserRole;
use Illuminate\Support\Facades\Auth;

class KnowledgeSharingServices {
    protected $model;
    private $limit;
    public function __construct()
    {
        $this->limit = 10;
        $this->model = new KnowledgeSharing();
    }
    public function getAllWithFilter($request, $NotJson = null, $NotwithLimit = null){ //default true / null
        try{
            $data = $this->model::query();
            $data->join('users','users.id','knowledge_sharing.created_by');
            $data->select('knowledge_sharing.*','users.name as created_by_name');
            $data->selectRaw('(SELECT departements.name FROM departements WHERE knowledge_sharing.departement_id = departements.id) as departement');
            if(!empty($request->keyword)){
                //filter search
                $key = $request->keyword;
                $data->where(function($query) use ($key){
                    $query->where('title', 'like','%'.$key.'%')
                          ->orWhere('meta_tags', 'like','%'.$key.'%')
                          ->orWhere('content', 'like','%'.$key.'%');
                });
            }
            $data->orderBy('knowledge_sharing.created_at', 'desc');
            //filter user
            if(!empty($request->created_by)){
                $data->where('knowledge_sharing.created_by', $request->created_by);
            }
            if(!empty($request->active)){
                $data->where('knowledge_sharing.active', $request->active);
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
