<?php

namespace App\Http\Controllers\Admin;

use App\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RoleMenuPermission;
use App\Models\User;
use App\Services\RoleMenuServices;
use App\Services\RoleServices;
use App\Services\UserServices;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class ManagementRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $roleServices;
    protected $roleMenuServices;
    public function __construct(RoleServices $services, RoleMenuServices $setRoleMenuServices){
        $this->roleServices = $services;
        $this->roleMenuServices = $setRoleMenuServices;
        $this->dirView = 'admin.role';
        $this->middleware('auth:web');
    }

    public function index(Request $request)
    {
        $dataTable = $this->roleServices->getAll($request);
        $data['menu'] = Menu::menu();
        $dataMenu = Menu::query()->orderBy('is_parent', 'asc')->orderBy('order', 'asc')->orderBy('created_at', 'asc')->get();
        $parent = collect($dataMenu)->where('is_parent','#')->sortBy('order');
        $menuUser = [];
        foreach($parent as $idx => $par){
            $menuUser[$idx] = $par;
            $subMenu = collect($dataMenu)->where('is_parent',$par['id'])->sortBy('order')->toArray();
            $child = [];
            if(count($subMenu) > 0){
                foreach($subMenu as $x => $sub){
                    $child = Menu::where('is_parent', $sub['id'])->orderBy('order','asc')->get()->toArray();
                    $subMenu[$x]['child'] = $child;
                }
            }
            $menuUser[$idx]['submenu'] = $subMenu;
        }
        $data['m_menu'] = $menuUser;
        $data['permission'] = Permission::all();
        $data['datatable'] = $dataTable;
        return view($this->dirView.'.list-role', $data);
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
    $cekExist = Role::whereRaw("to_char(slug) = '".$request->slug."'")->first();
    if(!empty($cekExist)){
        $model = Role::find($cekExist->id);
        $model->name = $request->name;
        $model->slug = $request->slug;
        $model->active = ($request->active == 'on') ? 1 : 0;
        $model->updated_by = Auth::user()->id;
        $model->updated_at = now();
        $model->save();
    }else{
        Role::create([
            'id' => number_id(),
            'name' => $request->name,
            'guard_name' => 'auth',
            'slug' => $request->slug,
            'active' => ($request->active == 'on') ? 1 : 0,
            'created_by' => Auth::user()->id,
            'updated_by' => Auth::user()->id
        ]);
    }

        return response()->json('Role updated!');
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
            $model = Role::find($id);
            $model->name = $request->name;
            $model->slug = $request->slug;
            $model->active = ($request->active == 'on') ? 1 : 0;
            $model->updated_by = Auth::user()->id;
            $model->updated_at = now();
            $model->save();

            return response()->json(['messages' => 'Role Berhasil Diperbaharui!']);

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
        $data = $this->roleServices->destroy($id);
        return $data;
    }
    public function getRow($id)
    {
        $data = $this->roleServices->getById($id);
        return $data;
    }

    //role modul
    public function getRoleModul($roleId){
        $services = $this->roleMenuServices;
        $getByRole = $services->getByRole($roleId, 'menuslug');
        return $getByRole;
    }
    //role modul
    public function storeRoleModul(Request $request){
        try{
            $roleId = $request->idrole;
            $dataPost = $request->all();
            //check active role post
            $role = Role::find($roleId);
            $role->active = ($request->active == 'on') ? 1 : 0;
            $role->name = $request->name_role;
            $role->slug = $request->slug;
            $role->updated_by = Auth::user()->id;
            $role->updated_at = now();
            $role->save();

            if(isset($request->checklist) && count($request->checklist) > 0){

                //cek reset
                $cek = RoleMenuPermission::where('role_id', $roleId)->first();
                if(!empty($cek)){
                    $delete = RoleMenuPermission::where('role_id', $roleId);
                    $delete->delete();
                }

                $insert = [];
                foreach($request->checklist as $row){
                    $dataRow = explode("_", $row);
                    $idMenu = $dataRow[0];
                    $slug = $dataRow[1];
                    $insert[] = [
                        'id' => generate_id(),
                        'role_id' => $roleId,
                        'menu_id' => $idMenu,
                        'permission_slug' => $slug,
                        'created_by' => Auth::user()->id,
                        'updated_by' => Auth::user()->id,
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                }
                RoleMenuPermission::insert($insert);
            }

            return redirect()->back()->with('success', 'Role Menu Permission Berhasil Diperbaharui!');

        }catch(\Exception $e){
            return response()->json($e->getMessage());
        }
    }
}
