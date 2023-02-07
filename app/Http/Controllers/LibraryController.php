<?php

namespace App\Http\Controllers;

use App\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\BusinessUnit;
use App\Models\Role;
use App\Models\User;
use App\Models\Menu;
use App\Models\News;
use App\Services\LibraryServices;
use App\Services\NewsServices;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class LibraryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $libraryServices;
    protected $dirView;
    protected $apiRoute;
    protected $user, $menuUser, $permissionMenu, $route, $userMenu;
    public function __construct(LibraryServices $services){
        $this->libraryServices = $services;
        $this->apiRoute = 'library';
        $this->dirView = 'library';
        $this->route = 'library';
        $this->middleware(function($request, $next){
            $this->userMenu = Auth::user()->getMenu();
            $permission = Auth::user()->checkPermissionMenu($request->path(), $this->userMenu);
            if(!$permission['access']){
                abort(403);
            }
            $this->permissionMenu = $permission['permission'];
            return $next($request);
        });

    }

    public function index(Request $request){
        $data['menu'] = Menu::menu();
        $data['permission'] = $this->permissionMenu;
        $data['route'] = $this->route;
        $data['view_folder'] = true;
        $data['view_file'] = true;
        $data['view_file_folder'] = false;
        //category sidebar from general params
        $data['category'] = $this->libraryServices->getCategory();
        //check super user
        $super = Auth::user()->superRole();
        if(!$super){
            //filter by created_by
            $request->created_by = Auth::user()->id;
        }

        $data['superUser'] = $super;
        $request->notdeleted = true;
        $request->recent = true;
        $data['table'] = $this->libraryServices->getAllWithFilter($request, 1, 1);
        $data['businessUnit'] = BusinessUnit::all();
        $tags = $this->libraryServices->getTag();
        $data['sugesTags'] = $tags;
        return view($this->dirView.'.library-media', $data);
    }

    public function revision(Request $request){
        try{
            $id = $request->idfile;
            $data = $this->libraryServices->getById($id)->first();
            $data->log = $this->libraryServices->log_revision($id);
            $data->icon_view = '<img src="'.asset('app-assets/images/icons/'.$data->ext_file.'.png').'" alt="file-icon" class="img-fluid" width="75">';
            $data->created_at_indo = customTanggal($data->created_at, 'd M Y h:i');
            $data->updated_at_indo = customTanggal($data->updated_at, 'd M Y h:i');
            $data->updated_human = humanDate($data->updated_at);
            $data->issued_ymd = explode(" ",$data->issued)[0];
            $data->expired_ymd = explode(" ",$data->expired)[0];
            $data->tags_relation_view = implode(', ', json_decode($data->tags_relation,1));
            $businessUnit = BusinessUnit::getOption();
            //category sidebar from general params
            $category = $this->libraryServices->categoryOption();
            //status from general params
            $status = $this->libraryServices->statusOption();
            //departmen from general params
            $departmen = $this->libraryServices->departmentOption();

            return response()->json([ 'row' => $data, 'businessUnit' => $businessUnit, 'masterCategory' => $category, 'masterstatus' => $status, 'masterDepartment' => $departmen]);
        }catch(\Exception $e){
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function revisionLog(Request $request){
        try{
            $id = $request->idfile;
            $data = $this->libraryServices->getLogById($id)->first();
            $data->log = $this->libraryServices->log_revision($data->libraries_id);
            $data->icon_view = '<img src="'.asset('app-assets/images/icons/'.$data->ext_file.'.png').'" alt="file-icon" class="img-fluid" width="75">';
            $data->created_at_indo = customTanggal($data->created_at, 'd M Y h:i');
            $data->updated_at_indo = customTanggal($data->updated_at, 'd M Y h:i');
            $data->issued_ymd = explode(" ",$data->issued)[0];
            $data->expired_ymd = explode(" ",$data->expired)[0];
            $data->tags_relation_view = implode(', ', json_decode($data->tags_relation,1));
            $businessUnit = BusinessUnit::getOption();
            //category sidebar from general params
            $category = $this->libraryServices->categoryOption();
            //status from general params
            $status = $this->libraryServices->statusOption();
            //departmen from general params
            $departmen = $this->libraryServices->departmentOption();

            return response()->json([ 'row' => $data, 'businessUnit' => $businessUnit, 'masterCategory' => $category, 'masterstatus' => $status, 'masterDepartment' => $departmen]);
        }catch(\Exception $e){
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function updateRevision(Request $request){
        //save log revision
        $this->libraryServices->saveLogRevision($request->id_library, $request->keterangan);
        $save = $this->libraryServices->updateForm($request, $request->id_library, $this->route);
        if($save){
            return redirect($this->route)->with(['success' => 'Data Berhasil Diperbaharui!']);
        }else{
            return redirect($this->route)->with(['error' => 'Data Gagal Diperbaharui!']);
        }
    }

}
