<?php

namespace App\Http\Controllers\Admin;

use App\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Departement;
use App\Models\KnowledgeSharing;
use App\Models\Role;
use App\Models\User;
use App\Models\Menu;
use App\Models\News;
use App\Models\NotificationMobile;
use App\Services\ExpoService;
use App\Services\KnowledgeSharingServices;
use App\Services\NewsServices;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class ManagementKnowledgeSharingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $newsServices;
    protected $dirView;
    protected $modul = "Knowledge Sharing";
    protected $user, $menuUser, $permissionMenu, $route;
    public function __construct(KnowledgeSharingServices $services){
        $this->middleware('auth');
        $this->newsServices = $services;
        $this->dirView  = 'admin.knowledge-sharing';
        $this->route = "backend/management-knowledge-sharing";
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

    public function getIndex(Request $request){
        $data['menu'] = $this->userMenu;
        $data['permission'] = $this->permissionMenu;
        $data['route'] = $this->route;
        $data['modul'] = $this->modul;
        //check super user
        $super = Auth::user()->superRole();
        if(!$super){
            //filter by created_by
            $request->created_by = Auth::user()->id;
        }
        // $request->active = 1;
        $data['table'] = $this->newsServices->getAllWithFilter($request, 1, 1);
        return view($this->dirView.'.index', $data);
    }
    public function add(Request $request){
        $data['menu'] = $this->userMenu;
        $data['permission'] = $this->permissionMenu;
        $data['route'] = $this->route;
        $data['category'] = [
            array('id' => 'info', 'name' => 'Info'),
            array('id' => 'news', 'name' => 'News'),
            array('id' => 'media', 'name' => 'Media'),
            array('id' => 'campaign', 'name' => 'Campaign')
        ];
        $data['departement'] = Departement::all();
        $tags = $this->newsServices->getTag();
        $data['sugesTags'] = $tags;
        $data['route'] = $this->route;
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
        $data = $this->newsServices->getAllWithFilter($request);
        return $data;
    }
    public function getAll(Request $request)
    {
        $data = $this->newsServices->getAll($request);
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

    public function store(Request $request)
    {
        $this->validationForm($request);
        $id = generate_id();
        //upload
        $bannerPath = uploadFileGeneral($request, 'banner_path','knowledge-sharing/'.$id);
        $pathFile = uploadFileGeneral($request, 'file','knowledge-sharing/'.$id);
        $photoAuthor = uploadFileGeneral($request, 'photo_author','knowledge-sharing/'.$id);

        $title = $request->title;
        $content = $request->content;
        $meta = explode(',',$request->tags);
        $active = $request->active;
        $departement = $request->departement_id;
        $author = $request->author;
        KnowledgeSharing::create([
            'id' => $id,
            'departement_id' => $departement,
            'title' => $title,
            'content' => $content,
            'meta_tags' => json_encode($meta),
            'banner_path' => $bannerPath,
            'path_file' => $pathFile,
            'photo_author' => $photoAuthor,
            'author' => $author,
            'active' => ($active == 'on') ? 1 : 0,
            'created_by' => Auth::user()->id,
            'updated_by' => Auth::user()->id
        ]);

        //check notification mobile
        if(isset($request->broadcast) && $request->broadcast == "on"){
            $generateId = generate_id();
            NotificationMobile::create([
                'id' => $generateId,
                'content_id' => $id,
                'category' => 'knowledge-sharing',
                'title' => $title,
                'path' => url('knowledges-sharing/detail/'.$id),
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => Auth::user()->id,
                'updated_by' => Auth::user()->id,
                'author_by' => Auth::user()->name
            ]);

            //service expo push notification
            $depart =  Departement::find($departement);
            $namaDepartement = 'Shared';
            if(!empty($depart)){
                $namaDepartement = "from ".$depart->name;
            }
            $namaDepartement = ucwords(strtolower($namaDepartement));
            $judul = Str::words($title, 8);
            $body = 'New Knowledge '.$judul;
            $data = json_encode(array('event' => url('knowledges-sharing/detail/'.$id)));
            $expo = new ExpoService();
            $expo->broadcastContent($body, $data, $id, Auth::user()->name);

        }

        return redirect($this->route)->with(['success' => 'Data Berhasil Diperbaharui!']);

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
        $row = $this->newsServices->getById($id);
        $data['row'] = $row;
        $data['menu'] = $this->userMenu;
        $data['permission'] = $this->permissionMenu;
        $data['route'] = $this->route;

        $data['category'] = [
            array('id' => 'info', 'name' => 'Info'),
            array('id' => 'news', 'name' => 'News'),
            array('id' => 'media', 'name' => 'Media'),
            array('id' => 'campaign', 'name' => 'Campaign')
        ];
        $tags = $this->newsServices->getTag();
        $data['sugesTags'] = $tags;
        $data['departement'] = Departement::all();
        //check notification mobile
        $notif = NotificationMobile::where('content_id', $id)->first();
        if(empty($notif)){
            $data['broadcast'] = false;
        }else{
            $data['broadcast'] = true;
        }
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
        //upload banner
        try{
            //upload
            $bannerPath = uploadFileGeneral($request, 'banner_path','knowledge-sharing/'.$id);
            $pathFile = uploadFileGeneral($request, 'file','knowledge-sharing/'.$id);
            $photoAuthor = uploadFileGeneral($request, 'photo_author','knowledge-sharing/'.$id);

            $title = $request->title;
            $content = $request->content;
            $meta = explode(',',$request->tags);
            $active = $request->active;
            $departement = $request->departement_id;
            $author = $request->author;

            $model = KnowledgeSharing::find($id);
            $model->departement_id = $departement;
            $model->title = $title;
            $model->content = $content;
            $model->meta_tags = json_encode($meta);
            if(!empty($bannerPath)){
                $model->banner_path = $bannerPath;
            }
            if(!empty($pathFile)){
                $model->path_file = $pathFile;
            }
            if(!empty($photoAuthor)){
                $model->photo_author = $photoAuthor;
            }
            $model->author = $author;
            $model->active = ($active == 'on') ? 1 : 0;
            $model->updated_at = now();
            $model->updated_by = Auth::user()->id;
            $model->save();

                    //check notification mobile
        if(isset($request->broadcast) && $request->broadcast == "on"){
            $generateId = generate_id();
            NotificationMobile::create([
                'id' => $generateId,
                'content_id' => $id,
                'category' => 'knowledge-sharing',
                'title' => $title,
                'path' => url('knowledges-sharing/detail/'.$id),
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => Auth::user()->id,
                'updated_by' => Auth::user()->id,
                'author_by' => Auth::user()->name
            ]);

            //service expo push notification
            $depart =  Departement::find($departement);
            $namaDepartement = 'Shared';
            if(!empty($depart)){
                $namaDepartement = "from ".$depart->name;
            }
            $namaDepartement = ucwords(strtolower($namaDepartement));
            $body = 'New Knowledge '.$namaDepartement;
            $data = json_encode(array('event' => url('knowledges-sharing/detail/'.$id)));
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
        $data = $this->newsServices->destroy($id);
        return $data;
    }
    public function getRow($id)
    {
        $data = $this->newsServices->getById($id);
        return $data;
    }
}
