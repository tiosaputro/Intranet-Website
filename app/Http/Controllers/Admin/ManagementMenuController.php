<?php

namespace App\Http\Controllers\Admin;

use App\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Models\Menu;
use App\Services\MenuServices;
use App\Services\RoleServices;
use App\Services\UserServices;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class ManagementMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $menuServices;
    public function __construct(MenuServices $services){
        $this->menuServices = $services;
        $this->dirView = 'admin.menu';
        $this->middleware('auth:web');
    }
    public function tes(){
        dd('tes');
    }
    public function index(Request $request)
    {

        $data['menu'] = Menu::menu();
        $menu = $this->menuServices->getAllWithFilter($request, true, true);
        $data['datatable'] = $menu;
        return view($this->dirView.'.list-menu', $data);
    }
    public function getAll(Request $request)
    {
        $data = $this->menuServices->getAll($request);
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
    public function store(Request $request){
        try{
            $cekExist = Menu::whereRaw("to_char(slug) = '".$request->slug."'")->first();
            if(isset($request->id) && !empty($request->id)){
                $model = Menu::find($request->id);
                $model->menu_name = $request->name;
                $model->slug = $request->slug;
                $model->url = $request->url;
                $model->order = $request->order;
                $model->icon = $request->icon;
                $model->is_parent = $request->is_parent;
                $model->active = ($request->active === 'on') ? 1 : 0;
                $model->hide_mobile = ($request->hide_mobile === 'on') ? 1 : 0;
                $model->updated_by = Auth::user()->id;
                $model->updated_at = now();
                $model->save();
            }else{
                Menu::create([
                    'id' => number_id(),
                    'menu_name' => $request->name,
                    'guard_name' => 'auth',
                    'slug' => $request->slug,
                    'icon' => $request->icon,
                    'active' => ($request->active === 'on') ? 1 : 0,
                    'created_by' => Auth::user()->id,
                    'updated_by' => Auth::user()->id,
                    'is_parent' => $request->is_parent,
                    'url' => $request->url,
                    'order' => $request->order
                ]);
            }
            return response()->json(['message' => 'Menu updated!']);
        }catch(\Exception $e){
            return response()->json($e->getMessage());
        }
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
        //
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
        try{
            $model = Menu::find($id);
            $model->menu_name = $request->name;
            $model->slug = $request->slug;
            $model->active = ($request->active === true) ? 1 : 0;
            $model->hide_mobile = ($request->hide_mobile === 'on') ? 1 : 0;
            $model->updated_by = Auth::user()->id;
            $model->updated_at = now();
            $model->is_parent = $request->is_parent;
            $model->url = $request->url;
            $model->order = $request->order;
            $model->icon = $request->icon;
            $model->save();

            return response()->json(['messages' => 'Menu/Modul Berhasil Diperbaharui!']);

        }catch(\Exception $e){
            return response()->json($e->getMessage());
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
        try{
            $data = $this->menuServices->destroy($id);
            return response()->json($data);
        }catch(\Exception $e){
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
    public function getRow($id)
    {
        $data = $this->menuServices->getById($id);
        return $data;
    }
}
