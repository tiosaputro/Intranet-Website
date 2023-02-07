<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Controller;
use App\Models\Calendar;
use Illuminate\Support\Facades\Auth;

class CalendarServices
{
    protected $model;
    private $limit;
    public function __construct()
    {
        $this->limit = 10;
    }
    public function getAllWithFilter($request, $NotJson = null, $NotwithLimit = null)
    { //default true / null
        try {
            $data = Calendar::query()->with('creator', 'updater', 'deleter');
            if (!empty($request->keyword)) {
                //filter search
                $key = $request->keyword;
                $data->where(function ($query) use ($key) {
                    $query->where('title', 'like', '%' . $key . '%')
                        ->orWhere('location', 'like', '%' . $key . '%')
                        ->orWhere('category', 'like', '%' . $key . '%');
                });
            }
            //filter year
            if (!empty($request->year)) {
                $data->whereRaw("to_char(calendar.start_date, 'YYYY') = '" . $request->year . "'");
                $data->whereRaw("to_char(calendar.end_date, 'YYYY') = '" . $request->year . "'");
            }
            if (!empty($request->comeNear) && $request->comeNear == true) {
                $data->whereRaw("to_char(calendar.end_date, 'YYYY-MM-DD') >= '" . date('Y-m-d') . "'");
            }
            //filter user
            if (!empty($request->orderBy)) {
                $data->orderBy('calendar.start_date', $request->orderBy);
            }
            if (!empty($request->created_by)) {
                $data->where('calendar.created_by', $request->created_by);
            }
            if (!empty($request->active)) {
                $data->where('calendar.active', $request->active);
            }
            if (!empty($request->nodelete)) {
                $data->whereNull('calendar.deleted_at');
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
            $data = Calendar::all();
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
            $data = Calendar::findOrFail($id);
            return $data;
        } catch (\Throwable $e) {
            return response()->json($e);
        }
    }
    public function destroy($id)
    {
        try {
            $data = Calendar::findOrFail($id);
            $data->delete();
            return response()->json($data);
        } catch (\ErrorException $e) {
            return response()->json($e);
        }
    }
    public function api_search($keyword)
    {
        try {
            $result = Calendar::where(function ($query) use ($keyword) {
                $query->where('title', 'like', '%' . $keyword . '%')
                    ->orWhere('content', 'like', '%' . $keyword . '%')
                    ->orWhere('meta_tags', 'like', '%' . $keyword . '%');
            })->paginate(20);
            return response()->json($result);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function search($keyword = null)
    {
        try {
            $result = Calendar::where(function ($query) use ($keyword) {
                $query->whereRaw("LOWER(title) like '%" . $keyword . "%'")
                    ->orWhereRaw("LOWER(category) like '%" . $keyword . "%'")
                    ->orWhereRaw("LOWER(description) like '%" . $keyword . "%'");
            })
                ->where('calendar.active', 1)
                ->get();
            return $result;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getTag($category = null)
    {
        $tagging = Calendar::query();
        if (!empty($category)) {
            $tagging->where('category', 'like', '%' . $category . '%');
            $tagging->where('calendar.active', 1);
        }
        $tags = $tagging->get();
        $tmp = [];
        foreach ($tags as $idx => $row) {
            if (!empty($row->meta_tags)) {
                $tag = json_decode($row->meta_tags, 1);
                foreach ($tag as $field) {
                    if (!in_array($field, $tmp)) {
                        array_push($tmp, $field);
                    }
                }
            }
        }
        return $tmp;
    }

    public function getCategoryCalendar()
    {
        Calendar::groupBy('category')->get();
    }
}
