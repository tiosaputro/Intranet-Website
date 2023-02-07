<?php

namespace App\Http\Controllers;

use App\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Broadcast;
use App\Models\Role;
use App\Models\User;
use App\Models\Menu;
use App\Models\News;
use App\Services\NewsServices;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class BlogContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $newsServices;
    protected $dirView;
    public function __construct(NewsServices $services)
    {
        $this->newsServices = $services;
        $this->dirView = 'blog-content'; //media highlight, emp news, info emp, company campaign
        $this->middleware('auth:web');
    }

    public function detail(Request $request)
    {
        if (!session()->has('url.intended')) {
            session(['url.intended' => url()->previous()]);
        }
        $data['menu'] = Menu::menu();
        try {
            $category = $request->category;
            $id = $request->id;
            $row = News::where('id', $id)->with('creator', 'updater')->first();
            // dd($row->content);
            // dd(popupImageCkeditor($row->content));
            $row->meta_tags = json_decode($row->meta_tags, 1);
            $data['news'] = $row;
            $data['category'] = $category;

            //3 data tags
            $tagging = News::where('category', 'like', '%' . $category . '%')->orderBy('updated_at', 'DESC')->limit(3)->get();
            $tmp = [];
            foreach ($tagging as $idx => $row) {
                if (!empty($row->meta_tags)) {
                    $tag = json_decode($row->meta_tags, 1);
                    foreach ($tag as $field) {
                        if($field != '' || !empty($field)){
                            array_push($tmp, $field);
                        }
                    }
                }
            }
            $tmp = array_unique($tmp);
            $data['taggingCategory'] = $tmp;
            $recentPost = collect($tagging)->where('id', '!=', $id);
            $data['recentPost'] = $recentPost;

            return view($this->dirView . '.detail', $data);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    public function search(Request $request)
    {
        $data['menu'] = Menu::menu();
        $keyword = $request->q;
        $data['keyword'] = $keyword;
        $result = $this->newsServices->search(strtolower($keyword), true);
        $data['result'] = $result;
        $tags = $this->newsServices->getTag();
        $data['tagging'] = $tags;

        $bannerInfoNews = Broadcast::where('type', 'like', '%banner-info-news%')
            ->where('active', 1)
            ->orderBy('created_at', 'desc')
            ->first();

        if (empty($bannerInfoNews)) {
            $data['bannerInfoNews'] = 'app-assets/images/banner/banner.png';
        } else {
            $foto = json_decode($bannerInfoNews->file_path);
            //check exist file
            if (!empty($foto)) {
                $data['bannerInfoNews'] = str_replace('public', 'storage', $foto[0]);
            } else {
                $data['bannerInfoNews'] = 'app-assets/images/banner/banner.png';
            }
        }
        return view('blog-content.search-blog', $data);
    }

    public function detailBroadcast($category, $id)
    {
        if (!session()->has('url.intended')) {
            session(['url.intended' => url()->previous()]);
        }
        $data['menu'] = Menu::menu();
        try {
            $row = Broadcast::where('id', $id)->with('creator', 'updater')->first();

            $row->meta_tags = [];
            $data['news'] = $row;
            $data['category'] = $category;

            //3 data tags
            $tagging = News::orderBy('created_at', 'DESC')->limit(4)->get();
            $tmp = [];
            foreach ($tagging as $idx => $row) {
                if (!empty($row->meta_tags)) {
                    $tag = json_decode($row->meta_tags, 1);
                    foreach ($tag as $field) {
                        if($field != '' || !empty($field)){
                            array_push($tmp, $field);
                        }
                    }
                }
            }
            $tmp = array_unique($tmp);
            $data['taggingCategory'] = $tmp;
            $recentPost = collect($tagging)->where('id', '!=', $id);
            $data['recentPost'] = $recentPost;

            return view($this->dirView . '.detail', $data);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }
}
