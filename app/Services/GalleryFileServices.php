<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Controller;
use App\Models\GalleryFile;
use App\Models\Menu;
use App\Models\News;
use App\Models\Role;
use App\Models\UserRole;
use Illuminate\Support\Facades\Auth;

class GalleryFileServices {
    protected $model;
    private $limit;
    public function __construct()
    {
        $this->limit = 10;
    }
    public function getAllWithFilter($request, $NotJson = null, $NotwithLimit = null){ //default true / null
        try{
            $data = GalleryFile::with('creator', 'updater', 'deleter');
            if(!empty($request->keyword)){
                //filter search
                $key = $request->keyword;
                $data->where(function($query) use ($key){
                    $query->where('name_file', 'like','%'.$key.'%')
                          ->orWhere('description_file', 'like','%'.$key.'%');
                });
            }
            //filter user
            if(!empty($request->type_file)){
                $data->where('gallery_file.type_file', $request->type_file);
            }
            if(!empty($request->recent)){
                $data->orderBy('gallery_file.created_at', 'desc');
            }
            if(!empty($request->created_by)){
                //$data->where('gallery_file.created_by', $request->created_by);
            }
            if(!empty($request->all)){
                $data->whereRaw('gallery_file.deleted_at is null');
            }
            if(!empty($request->folder)){
                $data->where('gallery_file.gallery_folder_id', 'like', "%".$request->folder."%");
            }
            if(!empty($request->nofolder)){
                $data->where('gallery_file.gallery_folder_id', 'like', "%uncategorized%");
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
            $data = GalleryFile::all();
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
            $data = GalleryFile::where('id',$id)->with('creator', 'updater', 'deleter');
            return $data;
        }catch(\Throwable $e){
            return response()->json($e);
        }

    }
    public function destroy($id){
        try{
            $data = GalleryFile::findOrFail($id);
            $data->delete();
            return response()->json($data);
        }catch(\ErrorException $e){
            return response()->json($e);
        }

    }

    public function updateViewerFile($id){
        try{
            $data = GalleryFile::findOrFail($id);
            $data->total_viewer_file = ($data->total_viewer_file+1);
            $data->save();
            return response()->json($data);
        }catch(\ErrorException $e){
            return response()->json($e);
        }
    }


}
