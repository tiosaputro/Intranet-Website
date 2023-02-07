<?php

namespace App\Http\Controllers;

use App\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Calendar;
use App\Models\Departement;
use App\Models\GeneralParams;
use App\Models\Role;
use App\Models\User;
use App\Models\Menu;
use App\Models\News;
use App\Models\NotificationMobile;
use App\Services\CalendarServices;
use App\Services\ExpoService;
use App\Services\NewsServices;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class CalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $service;
    protected $dirView;
    protected $user, $menuUser, $permissionMenu, $route;
    public function __construct(CalendarServices $services)
    {
        $this->service = $services;
        $this->dirView = 'calendar'; //media highlight, emp news, info emp, company campaign
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
    public function index(Request $request)
    {
        $data['menu'] = $this->userMenu;
        $data['permission'] = $this->permissionMenu;
        $data['route'] = $this->route;

        $calendarCategory = GeneralParams::where('slug', 'like', '%calendar-category')->first()->name;
        $calendarColor = GeneralParams::where('slug', 'like', '%calendar-color')->first()->name;
        $calendarCategory = json_decode($calendarCategory, 1);
        $calendarColor = json_decode($calendarColor, 1);
        $data['category'] = $calendarCategory;
        $data['categoryColor'] = $calendarColor;
        $data['users'] = User::where('active', 1)->with('profile')->get();
        //get calendar this year
        $request->active = 1;
        $request->nodelete = 1;
        $request->year = date('Y');
        $dataCalendar = $this->service->getAllWithFilter($request, 1, 1);
        $result = collect($dataCalendar)->map(function ($value) {
            return [
                'id' => $value->id,
                'title' => $value->title,
                'start' => \Carbon\Carbon::parse($value->start_date)->format('Y-m-d H:i'),
                'end' => \Carbon\Carbon::parse($value->end_date)->format('Y-m-d H:i'),
                'startStr' => $value->start_date,
                'endStr' => $value->end_date,
                'url' => empty($value->url) ? '' : $value->url,
                'extendedProps' => [
                    'location' => $value->location,
                    'guests' => json_decode($value->guest, 1),
                    'calendar' => $value->category,
                    'description' => $value->description
                ],
                'allDay' => ($value->allday == '1') ? true : false,
                'repeat' => ($value->repeat == '1') ? true : false,
                'banner' => (empty($value->banner)) ? '' : asset($value->banner)
            ];
        })->toArray();
        $data['dataCalendar'] = $result;
        return view($this->dirView . '.calendar', $data);
    }
    //create function date
    public function store(Request $request)
    {
        try {

            $extend = json_decode($request->extendedProps,1);
            $newEvent = false;
            if (isset($request->req_id)) {
                $calendar = Calendar::where('id', $request->req_id)->first();
                $calendar->updated_at = now();
                $calendar->updated_by = Auth::user()->id;
                $idCalendar = $request->req_id;
            } else {
                $newEvent = true;
                $calendar = new Calendar();
                $calendar->id = generate_id();
                $calendar->created_at = now();
                $calendar->created_by = Auth::user()->id;
                $calendar->active = 1; //set default 1
                $idCalendar = $calendar->id;
            }
            //check file upload
            $bannerPath = uploadFileGeneral($request, 'file', 'calendar');
            $calendar->url = isset($request->url) ? $request->url : null;
            $calendar->title = isset($request->title) ? $request->title : null;
            $calendar->start_date = isset($request->start) ? $request->start : null;
            $calendar->end_date = isset($request->end) ? $request->end : null;
            $calendar->category = isset($extend['calendar']) ? $extend['calendar'] : null;
            $calendar->guest = isset($extend['guests']) ? json_encode($extend['guests']) : null;
            $calendar->location = isset($extend['location']) ? $extend['location'] : null;
            $calendar->description = isset($extend['description']) ? $extend['description'] : null;
            $calendar->allday = isset($request->allDay) ? (($request->allDay == "true") ? 1 : 0) : null;
            $calendar->repeat = ($request->repeat == "true") ? 1 : 0;
            if($request->hasFile('file')){
                $calendar->banner = $bannerPath;
            }
            $calendar->save();

            //check notification mobile
            if($newEvent){
                $generateId = generate_id();
                NotificationMobile::create([
                    'id' => $generateId,
                    'content_id' => $idCalendar,
                    'category' => 'calendar',
                    'title' => isset($request->title) ? $request->title : null,
                    'path' => url('calendar/detail/'.$idCalendar),
                    'created_at' => now(),
                    'updated_at' => now(),
                    'created_by' => Auth::user()->id,
                    'updated_by' => Auth::user()->id,
                    'author_by' => Auth::user()->name
                ]);
            }
            //service expo push notification
            if(isset($request->push_notif)  && $request->push_notif){
                $judul = Str::words($request->title, 8);
                $body = 'New Event : '.$judul;
                $data = json_encode(array('event' => url('calendar/detail/'.$idCalendar)));
                $expo = new ExpoService();
                $expo->broadcastContent($body, $data, $idCalendar, Auth::user()->name);
            }

            if ($calendar) {
                return response()->json(['status' => 'success', 'message' => 'Event ' . $request->title . ' updated successfully!']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'failed', 'message' => $e->getMessage()]);
            \Log::error($e->getMessage());
        }
    } //end function

    public function detail($id)
    {
        $data['menu'] = $this->userMenu;
        $data['permission'] = $this->permissionMenu;
        $data['route'] = $this->route;
        $data['calendar'] = Calendar::where('id', $id)->first();
        $pic = $data['calendar']->guest;
        $getUser = [];
        if(!empty($pic)){
            $users = json_decode($pic, 1);
            $getUser = User::whereIn('id', $users)->get()->pluck('name')->toArray();
        }
        $data['pic'] = $getUser;
        $request = new Request();
        $requestCalendar = $request;
        $requestCalendar->active = 1;
        $requestCalendar->nodelete = 1;
        $requestCalendar->year = date('Y');
        $requestCalendar->orderBy = "asc";
        $requestCalendar->comeNear = true;
        $calendar = new CalendarServices();
        $dataCalendar = $calendar->getAllWithFilter($requestCalendar, 1,1);
        $data['recentPost'] = $dataCalendar->where('id','!=', $id);
        return view($this->dirView . '.detail', $data);
    }
}
