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


class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $newsServices;
    protected $dirView;
    public function __construct(NewsServices $services){
        $this->newsServices = $services;
        $this->dirView = 'company';
    }

    public function visimisi(Request $request)
    {
        $visimisi = Broadcast::where('type', 'like','%vision-mision%')
        ->where('active', 1)
        ->orderBy('created_at', 'desc')
        ->first();

        if(empty($visimisi)){
            $data['visimisi'] = null;
        }else{
            $foto = json_decode($visimisi->file_path);
            //check exist file
            if(!empty($foto)){
                $data['foto'] = $foto[0];
            }else{
                $data['foto'] = null;
            }
            $data['visimisi'] = $visimisi;
        }

        $data['menu'] = Menu::menu();

        return view($this->dirView.'.vision-mision', $data);
    }
    public function strukturOrganisasi(Request $request)
    {
        $data['menu'] = Menu::menu();
        $visimisi = Broadcast::where('type', 'like','%organization-structure%')
        ->where('active', 1)
        ->orderBy('created_at', 'desc')
        ->first();

        if(empty($visimisi)){
            $data['visimisi'] = null;
        }else{
            $foto = json_decode($visimisi->file_path);
            //check exist file
            if(!empty($foto)){
                $data['foto'] = $foto[0];
            }else{
                $data['foto'] = null;
            }
            $data['visimisi'] = $visimisi;
        }
        return view($this->dirView.'.struktur-organisasi', $data);
    }
}
