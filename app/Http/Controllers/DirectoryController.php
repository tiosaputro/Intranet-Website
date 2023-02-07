<?php

namespace App\Http\Controllers;

use App\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Models\Menu;
use App\Models\News;
use App\Services\DirectoryServices;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class DirectoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $service;
    protected $dirView;
    public function __construct(DirectoryServices $services){
        $this->service = $services;
        $this->dirView = 'blog-content'; //media highlight, emp news, info emp, company campaign
        $this->middleware('auth:web');
    }
    public function index(Request $request){
        $data['menu'] = Menu::menu();
        $keyword = $request->q;
        $data['keyword'] = $keyword;
        if(empty($request->q)){
            $request->q = 'all';
            $request->directory = 'emergency';
            return redirect('/directory/search?q=all&directory=emergency');
        }
        $data['fotoBanner'] = bannerBroadcast('banner-directory');
        return view('directory.search-directory', $data);
    }
    public function search(Request $request){
        $data['menu'] = Menu::menu();
        $keyword = $request->q;
        $data['keyword'] = $keyword;
        $directory = $request->directory;
        $data['directory'] = $directory;
        if(empty($request->q)){
            return redirect('directory');
        }
        $request->category = $directory;
        $request->keyword = $request->q;
        if($directory == 'emergency'){
            $result = $this->service->getAllWithFilter($request, 1);
        }
        if($directory == 'extension'){
            $request->active = 1;
            $result = $this->service->getAllWithFilter($request, 1);
        }
        $data['result'] = $result;
        $data['fotoBanner'] = bannerBroadcast('banner-directory');
        return view('directory.search-directory', $data);
    }

    public function apiSearch(Request $request){
        try{
            $keyword = $request->q;
            if(empty($keyword)){
                $request->keyword = 'all';
            }else{
                $request->keyword = $keyword;
            }
            $directory = $request->directory;
            $request->category = $directory;
            if($directory == 'emergency'){
                $result = $this->service->getAllWithFilter($request, 1);
            }
            if($directory == 'extension'){
                $request->active = 1;
                $result = $this->service->getAllWithFilter($request, 1);
            }
            return response()->json($result);
        }catch(\Exception $e){
            return response()->json($e->getMessage());
        }
    }

    public function dummyEmergency(){
        $emergency = [
            ['name' => 'Indonesian Red Cross', 'phone' => '+62 (0)361 465 or 2264'],
            ['name' => 'Red Cross', 'phone' => '+62 (0)361 465 or 2264'],
            ['name' => 'Layanan darurat', 'phone' => '112'],
            ['name' => 'Siloam Hospital KUTA', 'phone' => '+62 (0)361 779 911 (24h)'],
            ['name' => 'Police Station', 'phone' => '+621 112'],
            ['name' => 'Government', 'phone' => '(+621) 14045'],
        ];
        return $emergency;
    }

    public function dummyExtension(){
        $emergency = [
            ['name' => 'Arifin Tahir', 'departement' => 'ICT', 'lantai' => '18', 'ext' => '10', 'phone' => '08211xxx', 'position' => 'Head ICT'],
            ['name' => 'Bayu', 'departement' => 'ICT', 'lantai' => '18', 'ext' => '5', 'phone' => '08122xxx', 'position' => 'Analyst System'],
            ['name' => 'Aloysius L', 'departement' => 'ICT', 'lantai' => '18', 'ext' => '-', 'phone' => '087612312313', 'position' => 'Programmer'],
            ['name' => 'Arif R', 'departement' => 'ICT', 'lantai' => '18', 'ext' => '-', 'phone' => '0821103123','position' => 'Database Administrator'],
        ];
        return $emergency;
    }

    private function mapSearch($key, $array){
        $tmp = [];
        foreach($array as $row){
            if(isset($row['name'])){
                if(strstr(strtolower($row['name']), strtolower($key))){
                    $tmp[] = $row;
                }
            }
            if(isset($row['phone'])){
                if(strstr(strtolower($row['phone']), strtolower($key))){
                    $tmp[] = $row;
                }
            }
            if(isset($row['departement'])){
                if(strstr(strtolower($row['departement']), strtolower($key))){
                    $tmp[] = $row;
                }
            }
            if(isset($row['lantai'])){
                if(strstr(strtolower($row['lantai']), strtolower($key))){
                    $tmp[] = $row;
                }
            }
            if(isset($row['ext'])){
                if(strstr(strtolower($row['ext']), strtolower($key))){
                    $tmp[] = $row;
                }
            }
        }
        return $tmp;
    }

    public function detail(Request $request)
    {
        $data['menu'] = Menu::menu();
        try{
            $category = $request->category;
            $id = $request->id;
            $row = News::findOrFail($id);
            $row->meta_tags = json_decode($row->meta_tags, 1);
            $data['news'] = $row;
            $data['category'] = $category;

            //3 data tags
            $tagging = News::where('category','like','%'.$category.'%')->orderBy('updated_at','DESC')->limit(3)->get();
            $tmp = [];
            foreach($tagging as $idx => $row){
                if(!empty($row->meta_tags)){
                    $tag = json_decode($row->meta_tags,1);
                    foreach($tag as $field){
                        if($field != '' || !empty($field)){
                            array_push($tmp, $field);
                        }
                    }
                }
            }
            $tmp = array_unique($tmp);
            $data['taggingCategory'] = $tmp;
            $recentPost = collect($tagging)->where('id','!=',$id);
            $data['recentPost'] = $recentPost;

            return view($this->dirView.'.detail', $data);

        }catch(\Exception $e){
            return response()->json($e->getMessage());
        }
    }

}
