<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Controller;
use App\Models\Broadcast;
use App\Models\Menu;
use App\Models\News;
use App\Models\Role;
use App\Models\UserRole;
use Illuminate\Support\Facades\Auth;

class BroadcastServices
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
            $data = Broadcast::query();
            $data->join('users', 'users.id', 'broadcast.created_by');
            $data->join('users u', 'u.id', 'broadcast.updated_by');
            $data->select('broadcast.*', 'users.name as author', 'u.name as editor');
            $data->orderBy('broadcast.created_at', 'desc');
            if (!empty($request->keyword)) {
                //filter search
                $key = $request->keyword;
                $data->where(function ($query) use ($key) {
                    $query->where('title', 'like', '%' . $key . '%')
                        ->orWhere('content', 'like', '%' . $key . '%');
                });
            }
            //filter user
            if (!empty($request->created_by)) {
                $data->where('broadcast.created_by', $request->created_by);
            }
            if (!empty($request->active)) {
                $data->where('active', $request->active);
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
            $data = Broadcast::all();
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
            $data = Broadcast::findOrFail($id);
            return $data;
        } catch (\Throwable $e) {
            return response()->json($e);
        }
    }
    public function destroy($id)
    {
        try {
            $data = Broadcast::findOrFail($id);
            $data->delete();
            return response()->json($data);
        } catch (\ErrorException $e) {
            return response()->json($e);
        }
    }
    public function api_search($keyword)
    {
        try {
            $result = Broadcast::where(function ($query) use ($keyword) {
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
            $result = Broadcast::where(function ($query) use ($keyword) {
                $query->whereRaw("LOWER(title) like '%" . $keyword . "%'")
                    ->orWhereRaw("LOWER(content) like '%" . $keyword . "%'")
                    ->orWhereRaw("LOWER(meta_tags) like '%" . $keyword . "%'");
            })->get();
            return $result;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getTag($category = null)
    {
        $tagging = Broadcast::query();
        if (!empty($category)) {
            $tagging->where('category', 'like', '%' . $category . '%');
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
}
