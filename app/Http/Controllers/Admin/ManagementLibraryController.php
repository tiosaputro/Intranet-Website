<?php

namespace App\Http\Controllers\Admin;

use App\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\BusinessUnit;
use App\Models\Departement;
use App\Models\GeneralParams;
use App\Models\KnowledgeSharing;
use App\Models\Library;
use App\Models\Role;
use App\Models\User;
use App\Models\Menu;
use App\Models\News;
use App\Models\NotificationMobile;
use App\Models\SharedFunction;
use App\Services\ExpoService;
use App\Services\KnowledgeSharingServices;
use App\Services\LibraryServices;
use App\Services\NewsServices;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class ManagementLibraryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $serviceModel;
    protected $dirView;
    protected $modul = "Library";
    protected $route;
    protected $documentType, $masterDepartment, $masterStatus;
    protected $user, $menuUser, $permissionMenu;
    public function __construct(LibraryServices $services){
        $this->serviceModel = $services;
        $this->dirView  = 'admin.library';
        $this->route = "backend/management-library";
        $this->middleware(function($request, $next){
            $this->userMenu = Auth::user()->getMenu();
            $permission = Auth::user()->checkPermissionMenu($request->path(), $this->userMenu);
            if(!$permission['access']){
                abort(403);
            }
            $this->permissionMenu = $permission['permission'];
            return $next($request);
        });
        //document type from general_params model
        $this->documentType = json_decode(GeneralParams::where('slug', 'like','%document-type')->first()->name, 1);
        $this->masterDepartment = Departement::all();
        $this->masterStatus = json_decode(GeneralParams::where('slug', 'like','%document-status')->first()->name, 1);
    }

    public function getIndex(Request $request){
        //dashboard summary
        $data['dashboard'] = $this->serviceModel->getDashboardSummary();
        $data['lastUpdate'] = $this->serviceModel->getUpdatedLibrary();
        $data['menu'] = Menu::menu();
        $data['route'] = $this->route;
        $data['modul'] = $this->modul;
        $data['permission'] = $this->permissionMenu;
        $super = Auth::user()->superRole();
        // if(!$super){
            $request->notdeleted = true;
        // }
        $data['table'] = $this->serviceModel->getAllWithFilter($request, 1, 1);
        return view($this->dirView.'.index', $data);
    }
    public function add(Request $request){
        $data['categoryLibraries'] = $this->documentType;
        $data['masterDepartment'] = $this->masterDepartment;
        $data['menu'] = Menu::menu();
        $data['status'] = $this->masterStatus;
        $data['business_unit'] = BusinessUnit::all();
        $data['route'] = $this->route;
        $data['modul'] = $this->modul;
        $tags = $this->serviceModel->getTag();
        $data['sugesTags'] = $tags;

        return view($this->dirView.'.form-add', $data);
    }

    public function detail(Request $request){
        try{
            $id = $request->id;
            $row = News::findOrFail($id);
            return response()->json($row);
        }catch(\Exception $e){
            return response()->json($e->getMessage());
        }
    }

    private function mapParameterUpload($modul){
        $param = "file";
        if($modul == 'file_content'){
            $param = "upload";
        }
        return $param;
    }

    public function index(Request $request)
    {
        $data = $this->serviceModel->getAllWithFilter($request);
        return $data;
    }
    public function getAll(Request $request)
    {
        $data = $this->serviceModel->getAll($request);
        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function validationForm($request){
        return $request->validate([
            'title' => 'required',
        ]);
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

    public function store(Request $request)
    {
        $this->validationForm($request);
        $id = generate_id();
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
        $broadcast = $request->is_notif_mobile;
        try{
            DB::beginTransaction();

            Library::create([
                'id' => $id,
                'title' => $title,
                'name' => $name,
                'category' => $category,
                'category_libraries' => $categoryLibraries,
                'sop_number' => $sopNumber,
                'rev_no' => $revNo,
                'issued' => $issued,
                'expired' => $expired,
                'status' => $status,
                'devision_owner' => $devisionOwner,
                'remark' => $remark,
                'business_unit_id' => $businessUnitId,
                'location' => $location,
                'file_path' => $pathFile,
                'active' => ($active == 'on') ? 1 : 0,
                'is_notif_mobile' => ($broadcast == 'on') ? 1 : 0,
                'created_at' => now(),
                'created_by' => Auth::user()->id,
                'updated_by' => Auth::user()->id,
                'ext_file' => getExtension($pathFile),
                'tags_relation' => json_encode(explode(',',$request->tags_relation)),
                'deleted_at' => null,
                'deleted_by' => null
            ]);
            DB::commit();

            if ($request->broadcast == 'on') {
                NotificationMobile::create([
                    'id' => $id,
                    'content_id' => $id,
                    'category' => $category,
                    'title' => $title,
                    'path' => url('library/filter?category='.$categoryLibraries),
                    'created_at' => now(),
                    'updated_at' => now(),
                    'created_by' => Auth::user()->id,
                    'updated_by' => Auth::user()->id,
                    'author_by' => Auth::user()->name
                ]);
                //expo notif mobile service
                $judul = Str::words($title, 15);
                $body = $judul;
                $data = json_encode(array('event' => url('library/filter?category='.$categoryLibraries)));
                $expo = new ExpoService();
                $expo->broadcastContent($body, $data, $id, Auth::user()->name);
            }

            return redirect($this->route)->with(['success' => 'Data Berhasil Diperbaharui!']);

        }catch(\Exception $e){
            DB::rollBack();
            return redirect($this->route.'/add')->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $row = $this->serviceModel->getById($id)->first();
        $data['row'] = $row;
        $data['tags_relation'] = implode(",", json_decode($row->tags_relation, 1));
        $data['issued'] = explode(" ",$row->issued)[0];
        $data['expired'] = explode(" ", $row->expired)[0];
        $data['categoryLibraries'] = $this->documentType;
        $data['masterDepartment'] = $this->masterDepartment;
        $data['menu'] = Menu::menu();
        $data['status'] = $this->masterStatus;
        $data['business_unit'] = BusinessUnit::all();
        //============================================
        $data['route'] = $this->route;
        $data['modul'] = $this->modul;
        $tags = $this->serviceModel->getTag();
        $data['sugesTags'] = $tags;
        return view($this->dirView.'.form-edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validationForm($request);
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
        $broadcast = $request->broadcast;

            DB::beginTransaction();
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
                $models->tags_relation = json_encode(explode(',',$request->tags_relation));
                $models->active = ($active == 'on') ? 1 : 0;
                $models->is_notif_mobile = ($broadcast == 'on') ? 1 : 0;
                $models->updated_at = now();
                $models->updated_by = Auth::user()->id;
                $models->save();

            DB::commit();

            if ($request->broadcast == 'on') {
                $notif = new NotificationMobile();
                    $notif->id = generate_id();
                    $notif->content_id = $id;
                    $notif->category = $category;
                    $notif->title = $title;
                    $notif->path = url('library/filter?category='.$categoryLibraries);
                    $notif->created_at = now();
                    $notif->updated_at = now();
                    $notif->created_by = Auth::user()->id;
                    $notif->updated_by = Auth::user()->id;
                    $notif->author_by = Auth::user()->name;
                    $notif->save();
                //expo notif mobile service
                $judul = Str::words($title, 15);
                $body = $judul;
                $data = json_encode(array('event' => url('library/filter?category='.$categoryLibraries)));
                $expo = new ExpoService();
                $expo->broadcastContent($body, $data, $id, Auth::user()->name);
            }

            return redirect($this->route)->with(['success' => 'Data Berhasil Diperbaharui!']);

        }catch(\Exception $e){
            return redirect()->back()->with(['error' => $e]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function hapus($id)
    {
        $data = $this->serviceModel->destroy($id);
        return $data;
    }
    public function getRow($id)
    {
        $data = $this->serviceModel->getById($id);
        return $data;
    }
}
