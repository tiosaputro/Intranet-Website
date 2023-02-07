<?php

namespace App\Http\Controllers\Admin;

use App\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Permission;
use App\Services\PermissionServices;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class ManagementPermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $permissionServis;
    public function __construct(PermissionServices $services){
        $this->permissionServis = $services;
        $this->dirView = 'admin.permission';
        $this->middleware('auth:web');
    }

    public function index(Request $request)
    {
        $dataTable = $this->permissionServis->getAll($request, true, true);
        $data['menu'] = Menu::menu();
        $data['datatable'] = $dataTable;
        return view($this->dirView.'.list-permission', $data);
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
    public function store(Request $request)
{
        try{
            //cek edit id
            if(isset($request->id)){
                $model = Permission::find($request->id);
                $model->name = $request->name;
                $model->active = ($request->active == 'on') ? 1 : 0;
                $model->updated_by = Auth::user()->id;
                $model->updated_at = now();
                $model->save();
            }else{
                Permission::create([
                    'id' => number_id(),
                    'name' => $request->name,
                    'guard_name' => 'auth',
                    'active' => ($request->active == 'on') ? 1 : 0,
                    'created_by' => Auth::user()->id,
                    'updated_by' => Auth::user()->id
                ]);
            }
            return response()->json(['messages' => 'Berhasil Diperbaharui!']);
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
            $model = Permission::find($id);
            $model->name = $request->name;
            $model->active = ($request->active) ? 1 : 0;
            $model->updated_by = Auth::user()->id;
            $model->updated_at = now();
            $model->save();

            return response()->json(['messages' => 'Berhasil Diperbaharui!']);

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
        $data = $this->permissionServis->destroy($id);
        return $data;
    }
    public function getRow($id)
    {
        $data = $this->permissionServis->getById($id);
        return $data;
    }
}
