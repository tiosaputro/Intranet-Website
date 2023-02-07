<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Controller;
use App\Models\GalleryFile;
use App\Models\GalleryFolder;
use App\Models\Menu;
use App\Models\News;
use App\Models\Role;
use App\Models\UserRole;
use Illuminate\Support\Facades\Auth;

class GalleryFolderServices {
    protected $model;
    private $limit;
    public function __construct()
    {
        $this->limit = 10;
    }
    public function getAllWithFilter($request, $NotJson = null, $NotwithLimit = null){ //default true / null
        try{
            $data = GalleryFolder::with('creator', 'updater', 'deleter','hasFiles');
            if(!empty($request->keyword)){
                //filter search
                $key = $request->keyword;
                $data->where(function($query) use ($key){
                    $query->where('name_folder', 'like','%'.$key.'%')
                          ->orWhere('description_folder', 'like','%'.$key.'%');
                });
            }
            //filter user
            if(!empty($request->recent)){
                $data->orderBy('gallery_folder.created_at', 'desc');
            }

            if(!empty($request->created_by)){
                //$data->where('gallery_folder.created_by', $request->created_by);
            }
            if(!empty($request->id)){
                $data->where('gallery_folder.id', $request->id);
            }
            if(!empty($request->is_public)){
                $data->where('gallery_folder.is_public', 1);
            }
            if(!empty($request->is_important)){
                $data->where('gallery_folder.is_important', 1);
            }
            if(!empty($request->all)){
                $data->whereRaw('gallery_folder.deleted_at is null');
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
            $data = GalleryFolder::all();
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
            $data = GalleryFolder::where('id',$id)->with('creator', 'updater', 'deleter','hasFiles');
            return $data;
        }catch(\Throwable $e){
            return response()->json($e);
        }

    }
    public function destroy($id){
        try{
            $data = GalleryFolder::findOrFail($id);
            $data->delete();
            return response()->json($data);
        }catch(\ErrorException $e){
            return response()->json($e);
        }

    }
    public function api_search($keyword){
        try{
            $result = GalleryFolder::where(function($query) use ($keyword){
                $query->where('gallery_folder.name_folder', 'like','%'.$keyword.'%')
                      ->orWhere('gallery_folder.description_folder', 'like','%'.$keyword.'%');
            })->paginate(20);
            return response()->json($result);
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }
    public function search($keyword = null){
        try{
            $result = GalleryFolder::where(function($query) use ($keyword){
                $query->whereRaw("LOWER(name_folder) like '%".$keyword."%'")
                      ->orWhereRaw("LOWER(description_folder) like '%".$keyword."%'");
            })
            ->get();
            return $result;
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    public function updateSizeAndViewerFolder($id){
        try{
            $data = GalleryFolder::findOrFail($id);
            $totalSize = GalleryFile::where('gallery_folder_id', $id)->get()->sum('size_file');
            $data->size_folder = $totalSize;
            $data->total_viewer = ($data->total_viewer+1);
            $data->save();
            return response()->json($data);
        }catch(\ErrorException $e){
            return response()->json($e);
        }
    }

}
