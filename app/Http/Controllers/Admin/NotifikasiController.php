<?php

namespace App\Http\Controllers\Admin;

use App\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Departement;
use App\Models\GeneralParams;
use App\Models\KnowledgeSharing;
use App\Models\Role;
use App\Models\User;
use App\Models\Menu;
use App\Models\News;
use App\Models\NotificationMobile;
use App\Services\ExpoService;
use App\Services\NewsServices;
use App\Services\NotifikasiServices;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class NotifikasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $notifikasiServices;
    protected $dirView;
    protected $user, $menuUser, $permissionMenu, $route;
    public function __construct(NotifikasiServices $services)
    {
        $this->middleware('auth');
        $this->notifikasiServices = $services;
        $this->dirView  = 'admin.notifikasi';
        $this->route = 'backend/notifikasi';
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
    public function resend(Request $request)
    {
        $id = $request->id;
        $data = $this->notifikasiServices->getById($id);
        $row = $data;
        //check notification mobile
        try {
            //service expo push notification
            //custom body category
            $domainHttp = "http://" . $request->getHttpHost();
            $domainHttps = "https://" . $request->getHttpHost();
            $event = str_replace($data->path, "", $domainHttp);
            $event = str_replace($data->path, "", $domainHttps);
            //split path
            $event = $event . parse_url($data->path)['path'];

            if ($data->category == 'knowledge-sharing') {
                $judul = Str::words($data->title, 8);
                $body = 'New Knowledge About ' . $judul;
                // $data = json_encode(array('event' => 'knowledges-sharing/detail/'.$data->content_id));
                $data = json_encode(
                    array('event' => $event)
                );
            } else {
                //content info news
                $channelName = ucwords($data->category);
                $judul = Str::words($data->title, 8);
                $body = $channelName . ' Update : ' . $judul;
                $data = json_encode(
                    array('event' => $event)
                );
            }

            $generateId = generate_id();
            NotificationMobile::create([
                'id' => $generateId,
                'content_id' => $id,
                'category' => $row->category,
                'title' => $row->title,
                'path' => $row->path,
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => Auth::user()->id,
                'updated_by' => Auth::user()->id,
                'author_by' => $row->author_by
            ]);

            $expo = new ExpoService();
            $expo->broadcastContent($body, $data, $id, $row->author_by);

            return redirect('backend/notifikasi')->with(['success' => 'Resend Notification Success!']);
        } catch (\Exception $e) {
            return redirect('backend/notifikasi')->with(['error' => $e->getMessage()]);
        }
    }
    public function getIndex(Request $request)
    {
        $data['menu'] = $this->userMenu;
        $data['permission'] = $this->permissionMenu;
        $data['route'] = $this->route;
        //check super user
        $super = Auth::user()->superRole();
        if (!$super) {
            //filter by created_by
            $request->created_by = Auth::user()->id;
        }
        $data['superUser'] = $super;
        $data['table'] = $this->notifikasiServices->getAllWithFilter($request, 1, 1);
        $data['summary'] = $this->notifikasiServices->summaryNotif($request);
        //general params repeat-weekday-notification
        $params = GeneralParams::where('slug', 'like','%repeat-weekday-notification%')->first();
        $val = json_decode($params->name);
        $data['categoryNotif'] = collect($val)->pluck('category')->toArray();
        foreach($val as $key => $value){
            $data[$value->category] = [ 'duration' => $value->duration, 'at' => $value->at];
        }
        $data['recurrence_type'] = GeneralParams::getArray('recurrence-type');
        $otp = GeneralParams::getArray('setting-otp');
        if(empty($otp)){
            $otp = [
                'expired_date' => 1,
                'expired_time' => 3,
                'otp_active' => false
            ];
        }
        // dd($otp);
        $data['otp'] = $otp;

        return view($this->dirView . '.index', $data);
    }

    public function add(Request $request)
    {
        $data['menu'] = $this->userMenu;
        $data['permission'] = $this->permissionMenu;
        $data['route'] = $this->route;

        $data['category'] = [
            array('id' => 'info', 'name' => 'Info'),
            array('id' => 'news', 'name' => 'News'),
            array('id' => 'media', 'name' => 'Media'),
            array('id' => 'campaign', 'name' => 'Campaign')
        ];
        $tags = [];
        $data['sugesTags'] = $tags;
        return view($this->dirView . '.form-content', $data);
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
        $data = $this->notifikasiServices->getAllWithFilter($request);
        return $data;
    }
    public function getAll(Request $request)
    {
        $data = $this->notifikasiServices->getAll($request);
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
        //upload banner
        $bannerPath = uploadFile($request);

        $title = $request->title;
        $content = $request->content;
        $meta = explode(',', $request->tags);
        $active = $request->active;
        $category = $request->category;
        $id = generate_id();
        News::create([
            'id' => $id,
            'title' => $title,
            'content' => $content,
            'meta_tags' => json_encode($meta),
            'banner_path' => $bannerPath,
            'category' => $category,
            'active' => ($active == 'on') ? 1 : 0,
            'created_by' => Auth::user()->id,
            'updated_by' => Auth::user()->id
        ]);
        //check notification mobile
        if (isset($request->broadcast) && $request->broadcast == "on") {
            $generateId = generate_id();
            NotificationMobile::create([
                'id' => $generateId,
                'content_id' => $id,
                'category' => $request->category,
                'title' => $title,
                'path' => url('content/detail/' . $category . '/' . $id),
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => Auth::user()->id,
                'updated_by' => Auth::user()->id
            ]);

            //service expo push notification
            $channelName = ucwords($category);
            $body = 'Ada ' . $channelName . ' Terbaru! Ayo, Cek Sekarang.';
            $data = json_encode(array('event' => 'content/detail/' . $category . '/' . $id));
            $expo = new ExpoService();
            $expo->broadcastContent($body, $data, $id);
        }
        return redirect('backend/management-content')->with(['success' => 'Data Berhasil Diperbaharui!']);
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
        $row = $this->notifikasiServices->getById($id);
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
        $tags = [];
        $data['sugesTags'] = $tags;
        //check notification mobile
        $notif = NotificationMobile::where('content_id', $id)->first();
        if (empty($notif)) {
            $data['broadcast'] = false;
        } else {
            $data['broadcast'] = true;
        }
        return view($this->dirView . '.form-edit-content', $data);
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
        $bannerPath = uploadFile($request);

        $title = $request->title;
        $content = $request->content;
        $meta = explode(',', $request->tags);
        $active = $request->active;
        $category = $request->category;
        try {
            $model = News::find($id);
            $model->title = $title;
            $model->content = $content;
            $model->meta_tags = json_encode($meta);
            if (!empty($bannerPath)) {
                $model->banner_path = $bannerPath;
            }
            $model->category = $category;
            $model->active = ($active == true) ? 1 : 0;
            $model->updated_by = Auth::user()->id;
            $model->updated_at = now();
            $model->save();

            return redirect('backend/management-content')->with(['success' => 'Data Berhasil Diperbaharui!']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e]);
        }
    }

    public function updateParams(Request $request){
        try{
            //update json general params
            $params = GeneralParams::getArray('repeat-weekday-notification');
            foreach($params as $idx => $val){
                if($val['category'] == $request->category){
                    $params[$idx]['duration'] = $request->duration;
                    $params[$idx]['at'] = $request->at;
                    $params[$idx]['active'] = 0;
                }
            }
            //update params
            GeneralParams::where('slug','like','%repeat-weekday-notification%')->update(['name' => json_encode($params)]);
            return redirect()->back()->with(['notifSuccess' => 'Data Repeat Notif Berhasil Diperbaharui!']);
        }catch (\Exception $e){
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
        $data = $this->notifikasiServices->destroy($id);
        return $data;
    }
    public function getRow($id)
    {
        $data = $this->notifikasiServices->getById($id);
        return $data;
    }

    public function updateSettingOtp(Request $request){
        //validasi
        $this->validate($request, [
            'expired_date' => 'required',
            'expired_time' => 'required',
        ]);
        try{
            //update json general params
            $params = GeneralParams::getArray('setting-otp');
            //create post params
            $post = [
                'expired_date' => $request->expired_date,
                'expired_time' => $request->expired_time,
                'otp_active' => $request->active == 'on' ? true : false
            ];
            if(empty($params)){
               //insert data general params
                $insert = new GeneralParams();
                //max id general params
                $maxId = GeneralParams::where('id','!=', 'fsxasx0asdxs')->max('id');
                $insert->id = $maxId + 2;
                $insert->slug = 'setting-otp';
                $insert->name = json_encode($post);
                $insert->descriptions = "Konfigurasi OTP Whatsapp";
                $insert->created_by = "DEV";
                $insert->updated_by = "DEV";
                $insert->created_at = now();
                $insert->save();
            }else{
                //update params
                GeneralParams::where('slug','like','%setting-otp%')->update(['name' => json_encode($post)]);
            }
            return redirect()->back()->with(['notifSuccess' => 'Data Setting OTP Berhasil Diperbaharui!']);
        }catch(\Exception $e){
            dd($e);
            return redirect()->back()->with(['error' => $e]);
        }
    }
}
