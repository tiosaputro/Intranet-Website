<?php

namespace App\Http\Controllers\Admin;

use App\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Broadcast;
use App\Models\GeneralParams;
use App\Models\Role;
use App\Models\User;
use App\Models\Menu;
use App\Models\News;
use App\Models\NotificationMobile;
use App\Services\BroadcastServices;
use App\Services\ExpoService;
use App\Services\NewsServices;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class BroadcastController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $myServices;
    protected $dirView;
    protected $user, $menuUser, $permissionMenu, $route;
    public function __construct(BroadcastServices $services)
    {
        $this->middleware('auth');
        $this->myServices = $services;
        $this->dirView  = 'admin.broadcast';
        $this->route = 'backend/management-broadcast';
        $this->middleware(function ($request, $next) {
            $this->userMenu = Auth::user()->getMenu();
            $permission = Auth::user()->checkPermissionMenu($request->path(), $this->userMenu);
            if (!$permission['access']) {
                abort(403);
            }
            $this->permissionMenu = $permission['permission'];
            return $next($request);
        });
    }

    public function getIndex(Request $request)
    {
        $data['menu'] = $this->userMenu;
        $data['permission'] = $this->permissionMenu;
        $data['route'] = $this->route;
        $data['category'] = GeneralParams::getArray('category-broadcast');
        //check super user
        $super = Auth::user()->superRole();
        if (!$super) {
            //filter by created_by
            $request->created_by = Auth::user()->id;
        }
        $data['superUser'] = $super;
        $data['table'] = $this->myServices->getAllWithFilter($request, 1, 1);
        return view($this->dirView . '.index', $data);
    }
    public function add(Request $request)
    {
        $data['menu'] = $this->userMenu;
        $data['permission'] = $this->permissionMenu;
        $data['route'] = $this->route;
        $data['category'] = GeneralParams::getArray('category-broadcast');
        $data['recurrence_type'] = GeneralParams::getArray('recurrence-type');
        $tags = [];
        $data['sugesTags'] = $tags;
        return view($this->dirView . '.form-add', $data);
    }

    public function detailNews(Request $request)
    {
        try {
            $id = $request->id;
            $row = News::findOrFail($id);
            return response()->json($row);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    private function mapParameterUpload($modul)
    {
        $param = "file";
        if ($modul == 'file_content') {
            $param = "upload";
        }
        return $param;
    }

    public function index(Request $request)
    {
        $data = $this->myServices->getAllWithFilter($request);
        return $data;
    }
    public function getAll(Request $request)
    {
        $data = $this->myServices->getAll($request);
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
    public function validationForm($request)
    {
        return $request->validate([
            'title' => 'required',
        ]);
    }

    public function store(Request $request)
    {
        $this->validationForm($request);
        try {
            //upload banner
            $bannerPath = multipleUpload($request, 'file', 'uploads/broadcast', true);

            $title = $request->title;
            $content = $request->content;
            $active = $request->active;
            $category = $request->category;
            //is recurrence
            $request->recurrence;
            $id = generate_id();
            Broadcast::create([
                'id' => $id,
                'title' => $title,
                'content' => $content,
                'file_path' => (!empty($bannerPath)) ? json_encode($bannerPath) : null,
                'type' => $category,
                'active' => ($active == 'on') ? 1 : 0,
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => Auth::user()->id,
                'updated_by' => Auth::user()->id,
                'is_notif_mobile' => ($request->broadcast == 'on') ? 1 : 0,
                'is_recurrence' => ($request->recurrence == 'on') ? 1 : 0,
                'duration' => (!empty($request->recurrence_type)) ? $request->recurrence_type : null
            ]);
            if ($request->broadcast == 'on') {
                NotificationMobile::create([
                    'id' => $id,
                    'content_id' => $id,
                    'category' => $category,
                    'title' => $title,
                    'path' => url('broadcast/detail/' . $category . '/' . $id),
                    'created_at' => now(),
                    'updated_at' => now(),
                    'created_by' => Auth::user()->id,
                    'updated_by' => Auth::user()->id,
                    'author_by' => Auth::user()->name
                ]);
                //expo notif mobile service
                $judul = Str::words($title, 15);
                $body = $judul;
                $data = json_encode(array('event' => url('broadcast/detail/' . $category . '/' . $id)));
                $expo = new ExpoService();
                if($category == "announcement"){ //special case announcement
                    $expo->broadcastAnnouncement($body, $data, $id, $content);
                }else{
                    $expo->broadcastContent($body, $data, $id, Auth::user()->name);
                }
            }

            return redirect($this->route)->with(['success' => 'Data Berhasil Diperbaharui!']);
        } catch (\Exception $e) {
            return redirect($this->route)->with(['error' => $e->getMessage()]);
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
        $row = $this->myServices->getById($id);
        $data['row'] = $row;

        $data['menu'] = $this->userMenu;
        $data['permission'] = $this->permissionMenu;
        $data['route'] = $this->route;

        $data['category'] = GeneralParams::getArray('category-broadcast');
        $data['recurrence_type'] = GeneralParams::getArray('recurrence-type');
        $tags = [];
        $data['sugesTags'] = $tags;
        return view($this->dirView . '.form-edit', $data);
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
        //upload banner
        $bannerPath = multipleUpload($request, 'file', 'uploads/broadcast', true);

        $title = $request->title;
        $content = $request->content;
        $meta = explode(',', $request->tags);
        $active = $request->active;
        $category = $request->category;
        try {
            $model = Broadcast::find($id);
            $model->title = $title;
            $model->content = $content;
            if (!empty($bannerPath)) {
                $model->file_path = json_encode($bannerPath);
            }
            $model->type = $category;
            $model->active = ($active == 'on') ? 1 : 0;
            $model->updated_by = Auth::user()->id;
            $model->updated_at = now();
            if ($model->is_notif_mobile != 1) {
                if ($request->broadcast == 'on') {
                    NotificationMobile::create([
                        'id' => $id,
                        'content_id' => $id,
                        'category' => $category,
                        'title' => $title,
                        'path' => url('broadcast/detail/' . $category . '/' . $id),
                        'created_at' => now(),
                        'updated_at' => now(),
                        'created_by' => Auth::user()->id,
                        'updated_by' => Auth::user()->id,
                        'author_by' => Auth::user()->name
                    ]);
                    //expo notif mobile service
                    $judul = Str::words($title, 15);
                    $body = $judul;
                    $data = json_encode(array('event' => url('broadcast/detail/' . $category . '/' . $id)));
                    $expo = new ExpoService();
                    if($category == "announcement"){ //special case announcement
                        $expo->broadcastAnnouncement($body, $data, $id, $content);
                    }else{
                        $expo->broadcastContent($body, $data, $id, Auth::user()->name);
                    }
                }
            }

            $model->is_notif_mobile = ($request->broadcast == 'on') ? 1 : 0;
            $model->is_recurrence = ($request->recurrence == 'on') ? 1 : 0;
            $model->duration = (!empty($request->recurrence_type)) ? $request->recurrence_type : null;
            $model->save();

            return redirect($this->route)->with(['success' => 'Data Berhasil Diperbaharui!']);
        } catch (\Exception $e) {
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
        $data = $this->myServices->destroy($id);
        return $data;
    }
    public function getRow($id)
    {
        $data = $this->myServices->getById($id);
        return $data;
    }
}
