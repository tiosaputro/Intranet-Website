<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\News;
use App\Models\Role;
use App\Models\UserRole;
use Illuminate\Support\Facades\Auth;

class NewsServices
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
            $data = News::query();
            $data->join('users', 'users.id', 'news.created_by');
            $data->join('users u', 'u.id', 'news.updated_by');
            $data->select('news.*', 'users.name as author', 'u.name as editor');
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
                $data->where('news.created_by', $request->created_by);
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
            $data = News::all();
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
            $data = News::findOrFail($id);
            return $data;
        } catch (\Throwable $e) {
            return response()->json($e);
        }
    }
    public function destroy($id)
    {
        try {
            $data = News::findOrFail($id);
            $data->delete();
            return response()->json($data);
        } catch (\ErrorException $e) {
            return response()->json($e);
        }
    }
    public function api_search($keyword)
    {
        try {
            $result = News::where(function ($query) use ($keyword) {
                $query->where('title', 'like', '%' . $keyword . '%')
                    ->orWhere('content', 'like', '%' . $keyword . '%')
                    ->orWhere('meta_tags', 'like', '%' . $keyword . '%');
            })->paginate(20);
            return response()->json($result);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function search($keyword = null, $orderBy = false)
    {
        try {
            $result = News::where(function ($query) use ($keyword) {
                $query->whereRaw("LOWER(title) like '%" . $keyword . "%'")
                    ->orWhereRaw("LOWER(content) like '%" . $keyword . "%'")
                    ->orWhereRaw("LOWER(meta_tags) like '%" . $keyword . "%'");
            });
            $result = $result->where('news.active', 1)->orderBy('news.created_at', 'desc')
                ->with('creator')
                ->paginate(12);
            return $result;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getTag($category = null)
    {
        $tagging = News::query();
        if (!empty($category)) {
            $tagging->where('category', 'like', '%' . $category . '%');
            $tagging->where('news.active', 1);
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
