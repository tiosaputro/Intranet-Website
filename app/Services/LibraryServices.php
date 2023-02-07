<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Controller;
use App\Models\Departement;
use App\Models\GeneralParams;
use App\Models\Library;
use App\Models\LogLibrary;
use App\Models\News;
use App\Models\Role;
use App\Models\UserRole;
use Illuminate\Support\Facades\Auth;

class LibraryServices {
    protected $model;
    private $limit;
    public function __construct()
    {
        $this->limit = 10;
        $this->model = new Library();
    }
    public function selectQuery(){
        $data = $this->model::query();
        $data->join('users','users.id','libraries.created_by');
        $data->select('libraries.*','users.name as created_by_name');
        $data->selectRaw('(SELECT business_units.name FROM business_units WHERE business_units.id = libraries.business_unit_id) as business_unit_name');
        $data->selectRaw('(SELECT shared_functions.name FROM shared_functions WHERE shared_functions.id = libraries.shared_function_id) as shared_function_name');

        return $data;
    }

    public function getAllWithFilter($request, $NotJson = null, $NotwithLimit = null){ //default true / null
        try{
            $data = $this->selectQuery(); //script query

            if(!empty($request->keyword)){
                //filter search
                $key = $request->keyword;
                $data->where(function($query) use ($key){
                    $query->whereRaw("LOWER(libraries.name) like '%$key%'")
                          ->orWhereRaw("LOWER(libraries.title) like '%$key%'")
                          ->orWhereRaw("to_char(libraries.category) like '%$key%'")
                          ->orWhereRaw("to_char(libraries.category_libraries) like '%$key%'");
                });
            }
            if(!empty($request->category)){
                $data->where('libraries.category_libraries','like', "%".$request->category."%");
            }
            if(!empty($request->bu)){
                $data->where('libraries.business_unit_id', $request->bu);
            }
            if(!empty($request->active)){
                $data->where('libraries.active', $request->active);
            }
            if(!empty($request->id)){
                $data->where('libraries.id', $request->id);
            }
            if(!empty($request->recent)){
                $data->orderBy('libraries.created_at', 'desc');
            }
            if(!empty($request->notdeleted)){
                $data->whereNull('libraries.deleted_at');
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
            $data = $this->model::where('id',$id)->with('creator', 'updater', 'deleter','business_unit','department');
            return $data;
        }catch(\Throwable $e){
            return response()->json($e);
        }

    }
    public function getLogById($id){
        try{
            $data = LogLibrary::where('id',$id)->with('creator', 'updater', 'deleter','business_unit','department');
            return $data;
        }catch(\Throwable $e){
            return response()->json($e);
        }

    }
    public function destroy($id){
        try{
            $data = $this->model::findOrFail($id);
            $data->active = 0;
            $data->deleted_at = now();
            $data->deleted_by = Auth::user()->id;
            $data->save();
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
            if(!empty($row->tags_relation)){
                $tag = json_decode($row->tags_relation,1);
                foreach($tag as $field){
                    if(!in_array($field, $tmp)){
                        array_push($tmp, $field);
                    }
                }
            }
        }
        return $tmp;
    }

    public function getCategory(){
       $arrayName = GeneralParams::where('slug','like','%document-type%')->first()->name;
       return json_decode($arrayName,1);
    }
    public function categoryOption(){
        $arrayName = GeneralParams::where('slug','like','%document-type%')->first()->name;
        return collect(json_decode($arrayName,1))->map(function($row){
            return [
                'id' => $row,
                'text' => $row
            ];
        });
    }
    public function statusOption(){
        $arrayName = GeneralParams::where('slug','like','%document-status%')->first()->name;
        return collect(json_decode($arrayName,1))->map(function($row){
            return [
                'id' => $row,
                'text' => $row
            ];
        });
    }
    public function departmentOption(){
        $arrayName = Departement::all();
        return collect($arrayName)->map(function($row){
            return [
                'id' => $row->id,
                'text' => $row->name
            ];
        });
    }
    public function checkCategory($category){
        $category = str_replace(' ', '', $category);
        $arr = explode(':', $category);
        $return = '-';
        if(is_array($arr) && count($arr) > 1){
            return $arr[1];
        }
        return $return;
    }

    public function updateForm($request, $id, $redirect = 'library'){
        try{
        //upload
        $pathFile = uploadFileGeneral($request, 'file','library/'.$id);

        $title = $request->title;
        $name = $request->name;
        $category = $this->checkCategory($request->category_libraries);
        $categoryLibraries = $request->category_libraries;
        $sopNumber = $request->sop_number;
        $revNo = $request->rev_no;
        $issued = $request->issued;
        $expired = $request->expired;
        $status = $request->status;
        $devisionOwner = $request->devision_owner;
        $remark = $request->remark;
        $businessUnitId = $request->business_unit_id;
        $location = $request->location;
        $active = $request->active;

            \DB::beginTransaction();
                $models = Library::find($id);

                $models->title = $title;
                $models->name = $name;
                $models->category = $category;
                $models->category_libraries = $categoryLibraries;
                $models->sop_number = $sopNumber;
                $models->rev_no = $revNo;
                $models->issued = $issued;
                $models->expired = $expired;
                $models->status = $status;
                $models->devision_owner = $devisionOwner;
                $models->remark = $remark;
                $models->business_unit_id = $businessUnitId;
                $models->location = $location;

                if(!empty($pathFile)){
                    $models->file_path = $pathFile;
                    $models->ext_file = getExtension($pathFile);
                }
                if(isset($request->tags_relation) && !empty($request->tags_relation)){
                    $models->tags_relation = json_encode(explode(',',$request->tags_relation));
                }
                $models->active = ($active == 'on') ? 1 : 0;
                $models->updated_at = now();
                $models->updated_by = Auth::user()->id;
                $models->save();

            \DB::commit();
            return true;

        }catch(\Exception $e){
            dd($e);
        }

    }//end function

    public function saveLogRevision($id, $keterangan = null){
        try{
            $data = Library::find($id);
            //create new log library
            $log = new LogLibrary();
            $log->id = generate_id();
            $log->libraries_id = $id;
            $log->title = $data->title;
            $log->name = $data->name;
            $log->category = $data->category;
            $log->category_libraries = $data->category_libraries;
            $log->sop_number = $data->sop_number;
            $log->rev_no = $data->rev_no;
            $log->issued = $data->issued;
            $log->expired = $data->expired;
            $log->status = $data->status;
            $log->devision_owner = $data->devision_owner;
            $log->remark = $data->remark;
            $log->business_unit_id = $data->business_unit_id;
            $log->location = $data->location;
            $log->file_path = $data->file_path;
            $log->ext_file = $data->ext_file;
            $log->tags_relation = $data->tags_relation;
            $log->active = $data->active;
            $log->created_at = $data->created_at;
            $log->created_by = $data->created_by;
            $log->updated_at = now();
            $log->updated_by = Auth::user()->id;
            $log->keterangan = $keterangan;
            $log->save();
            return true;
        }catch(\Exception $e){
            //return error 500
            return false;
            //return redirect()->back()->with(['error' => $e]);
        }
    }
    public function log_revision($idLibrary){
        //has many log library
        $map = LogLibrary::where('libraries_id',$idLibrary)
        ->with('creator','updater','deleter','department')
        ->orderBy('updated_at','asc')
        ->get();
        //mapping data
        $data = $map->map(function($row){
            $row->created_human = ($row->created_at) ? humanDate($row->created_at) : '-';
            $row->updated_human = ($row->updated_at) ? humanDate($row->updated_at) : '-';
            $row->deleted_human = ($row->deleted_at) ? humanDate($row->deleted_at) : '-';
            return $row;
        });
        return $data;
    }

    //get dashboard summary library
    public function getDashboardSummary(){
        $paramsStatus = GeneralParams::where('slug','like','%document-status')->first()->name;
        $paramColor = GeneralParams::where('slug','like','%document-status-color')->first()->name;
        $status = json_decode($paramsStatus,1);
        $color = json_decode($paramColor,1);
        $sql = "";
        foreach($status as $row){
            $sql .= "COUNT(CASE WHEN status = '".$row."' THEN 1 END) AS ".$row.", ";
        }
        $sql = substr($sql,0,-2);
        $data = Library::selectRaw($sql)->where('active',1)->first();
        return [
            'data' => $data->toArray(),
            'color' => $color,
            'icon-feather' => ['trending-up','alert-triangle','repeat','file-text','check-circle','check-square','file-minus']
        ];
    }

    //get updated library
    public function getUpdatedLibrary(){
        $data = Library::select('updated_at')
        ->where('active',1)
        ->orderBy('updated_at','desc')
        ->limit(1)
        ->first();
        if(empty($data)){
            return '-';
        }
        return humanDate($data->updated_at);
    }

}
