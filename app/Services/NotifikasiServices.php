<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Controller;
use App\Models\Calendar;
use App\Models\KnowledgeSharing;
use App\Models\Library;
use App\Models\Menu;
use App\Models\News;
use App\Models\NotificationMobile;
use App\Models\Role;
use App\Models\UserRole;
use Illuminate\Support\Facades\Auth;

class NotifikasiServices
{
    protected $model;
    private $limit;
    private $table;
    public function __construct()
    {
        $this->limit = 10;
        $this->table = "notification_mobile";
    }
    public function getAllWithFilter($request, $NotJson = null, $NotwithLimit = null)
    { //default true / null
        try {
            $data = NotificationMobile::query()->with('author');

            if (!empty($request->keyword)) {
                //filter search
                $key = $request->keyword;
                $data->where(function ($query) use ($key) {
                    $query->where('title', 'like', '%' . $key . '%')
                        ->orWhere('category', 'like', '%' . $key . '%');
                });
            }
            $data->orderBy("created_at", "desc");
            //filter user
            if (!empty($request->created_by)) {
                $data->where($this->table . '.created_by', $request->created_by);
            }

            if (empty($NotwithLimit)) {
                $result = $data->paginate($this->limit);
            } else {
                $result = $data;
            }
            if (empty($NotJson)) {
                return response()->json($result);
            } else {
                return $result->get();
            }
        } catch (\ErrorException $e) {
            return response()->json($e);
        }
    }
    public function getAll($request)
    {
        try {
            $data = NotificationMobile::all();
            if (!empty($request->active)) {
                $data->where('active', $request->active);
            }
            return response()->json($data);
        } catch (\Throwable $e) {
            return response()->json($e);
        }
    }
    public function getById($id)
    {
        try {
            $data = NotificationMobile::findOrFail($id);
            return $data;
        } catch (\Throwable $e) {
            return response()->json($e);
        }
    }
    public function destroy($id)
    {
        try {
            $data = NotificationMobile::findOrFail($id);
            $data->delete();
            return response()->json($data);
        } catch (\ErrorException $e) {
            return response()->json($e);
        }
    }
    public function api_search($keyword)
    {
        try {
            $result = NotificationMobile::where(function ($query) use ($keyword) {
                $query->where('title', 'like', '%' . $keyword . '%')
                    ->orWhere('category', 'like', '%' . $keyword . '%');
            })->paginate(20);
            return response()->json($result);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function search($keyword = null)
    {
        try {
            $result = NotificationMobile::where(function ($query) use ($keyword) {
                $query->whereRaw("LOWER(title) like '%" . $keyword . "%'")
                    ->orWhereRaw("LOWER(category) like '%" . $keyword . "%'");
            })
                ->where($this->table . '.active', 1)
                ->get();
            return $result;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function summaryNotif($request)
    {
        try {
            //set for calendar : on this week
            $monday = strtotime('last monday', strtotime('tomorrow'));
            $sunday = strtotime('+7 days', $monday);
            //set for news, knowledge sharing, library : on last week
            $last_monday = strtotime('last week', strtotime('tomorrow'));
            $last_sunday = strtotime('+12 days', $last_monday);

            $summary = [];
            //get count news on this week
            $count_news = News::where('active', 1)
                ->whereBetween('updated_at', [date('Y-m-d', $last_monday), date('Y-m-d', $last_sunday)])
                ->count();
            $summary['news'] = $count_news;
            //get count knowledge on this week
            $knowledge = KnowledgeSharing::where('active', 1)
                ->whereBetween('updated_at', [date('Y-m-d', $last_monday), date('Y-m-d', $last_sunday)])
                ->count();
            $summary['knowledge'] = $knowledge;
            //get count calendar on this week
            $calendar = Calendar::where('active', 1)
                ->whereBetween('start_date', [date('Y-m-d', $monday), date('Y-m-d', $sunday)])
                ->count();
            $summary['calendar'] = $calendar;
            //get count library on this week
            $library = Library::where('active', 1)
                ->whereBetween('updated_at', [date('Y-m-d', $last_monday), date('Y-m-d', $last_sunday)])
                ->count();
            $summary['library'] = $library;
            return $summary;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
