<?php

namespace App\Http\Controllers;

use App\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\KnowledgeSharing;
use App\Models\Role;
use App\Models\User;
use App\Models\Menu;
use App\Models\News;
use App\Services\KnowledgeSharingServices;
use App\Services\NewsServices;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class KnowledgeSharingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $newsServices;
    protected $dirView;
    public function __construct(KnowledgeSharingServices $services){
        $this->newsServices = $services;
        $this->dirView = 'knowledge-sharing'; //media highlight, emp news, info emp, company campaign
        $this->middleware('auth:web');
    }

    public function detail(Request $request)
    {
        if(!session()->has('url.intended'))
        {
            session(['url.intended' => url()->previous()]);
        }

        $data['menu'] = Menu::menu();
        try{
            // $category = $request->category;
            $category = 'knowledges sharing';
            $id = $request->id;
            // $row = News::findOrFail($id);
            // $row->meta_tags = json_decode($row->meta_tags, 1);
            $data['news'] = $this->newsServices->getAllWithFilter($request, 1, 1)->first();
            $data['category'] = $category;

            //3 data tags
            $tagging = KnowledgeSharing::where('active',1)->orderBy('updated_at','DESC')->limit(3)->get();
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
            //unique
            $tmp = array_unique($tmp);
            $data['taggingCategory'] = $tmp;
            $recentPost = collect($tagging)->where('id','!=',$id);
            $data['recentPost'] = $recentPost;

            return view($this->dirView.'.detail-knowledge', $data);

        }catch(\Exception $e){
            return response()->json($e->getMessage());
        }
    }

    public function index(Request $request){
        $data['menu'] = Menu::menu();
        $keyword = $request->q;
        $data['keyword'] = $keyword;
        // $result = $this->newsServices->search(strtolower($keyword));
        $data['result'] = KnowledgeSharing::all()->where('active',1)->sortByDesc('created_at');
        $tags = $this->newsServices->getTag();
        $data['tagging'] = $tags;
        $data['fotoBanner'] = bannerBroadcast('banner-knowledge-sharing');
        return view('knowledge-sharing.search-knowledge', $data);
    }

    public function search(Request $request){
        $data['menu'] = Menu::menu();
        $keyword = $request->q;
        $data['keyword'] = $keyword;
        $result = $this->newsServices->search(strtolower($keyword));
        $data['result'] = $result->where('active',1);
        $tags = $this->newsServices->getTag();
        $data['tagging'] = $tags;
        $data['fotoBanner'] = bannerBroadcast('banner-knowledge-sharing');
        return view('knowledge-sharing.search-knowledge', $data);
    }

    private function dataDummy(){
        $data = [
            (object) ['id' => '0',
            'title' => 'Tips Keselamatan Diri saat gempa bumi',
            'file' => '',
            'departement' => 'ICT',
            'author' => 'Mr.Arifin',
            'created_at' => '2022-01-01',
            'photo_author' => 'app-assets/images/portrait/small/avatar-s-15.jpg',
            'meta_tags' => '["Safety", "Work", "Gempa bumi"]',
            'category' => 'Knowledges Sharing',
            'banner_path' => 'app-assets/images/pages/login/emp.jpg',
            'content' => 'Peristiwa gempa yang sering mengguncang Indonesia seperti gempa yang terjadi di Palu dan Donggala beberapa waktu yang lalu sangat mengejutkan kita semua. Kondisi daerah yang rawan gempa membutuhkan tindak lanjut edukasi tanggap bencana pada masyarakat. Terlebih lagi jika melihat korban gempa di Palu dan Donggala cukup banyak.
            Tingginya jumlah korban bisa jadi dikarenakan oleh faktor rendahnya kesadaran siaga bencana pada masyarakat. Sehingga ketika terjadi gempa, masyarakat panik dan tidak tahu tindakan tepat untuk menyelamatkan diri. Sementara itu, simulasi bencana seperti gempa juga belum dilakukan secara efektif di setiap daerah di Indonesia.'
            ]
        ];
        return $data;
    }
}
