<?php

namespace App\Http\Controllers\Admin;

use App\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\User;
use App\Models\UserRole;
use App\Services\UserServices;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Yajra\Datatables\Datatables;

class ManagementUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $userServices;
    public function __construct(UserServices $services){
        // $this->middleware('auth');
        $this->userServices = $services;
        $this->dirView = 'admin.users';
        $this->middleware('auth:web');
    }

    public function index(Request $request)
    {
        $data['menu'] = Menu::menu();
        $user = $this->userServices->userWithRole($request);
        // dd($user);
        $data['datatable'] = $user;
        $data['totalUser'] = $data['datatable']->count();
        $hasNotRole = collect($user)->whereNull('nama_role')->count();
        $notActive = collect($user)->where('active',0)->count();
        $data['hasNotRole'] = $hasNotRole;
        $data['notActive'] = $notActive;
        //role
        $data['role'] = Role::all();
        return view($this->dirView.'.list-user', $data);
    }

    public function datatable(Request $request){
        if ($request->ajax()) {
            $data = $this->userServices->getAllWithRole($request);
            return $data;
            // return DataTables::of($data)
            //     ->addIndexColumn()
            //     ->addColumn('action', function($row){
            //         $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
            //         return $actionBtn;
            //     })
            //     ->rawColumns(['action'])
            //     ->make(true);
        }
    }

    public function getRole()
    {
        $data = $this->userServices->getRole();
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
    public function store(Request $request)
{
    $edit = false;
    if(!empty($request->id)){
        $edit = true;
    }
    if($edit){
        $this->validate($request, [
            'name' => 'required',
            'role' => 'required',
        ]);
    }else{
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'role' => 'required',
            'password' => 'required'
        ]);
    }
    try{
        $cekExist = User::where('email', $request->email)->first();
        if($cekExist){
            $user = User::find($cekExist->id);
            $user->name = $request->name;
            $user->email = $request->email;
            if(!empty($request->password)){
                $user->password = Hash::make($request->password);
            }
            $user->active = ($request->active) ? 1 : 0;
            $user->save();
            $id = $cekExist->id;
            if(!empty($request->role)){
                $this->userServices->resetRole($id, $request);
            }
        }else{
            $id = strtolower(Str::random(10).date('his'));
            $user = User::create([
                'id' => $id,
                'name' => $request->name,
                'email' => $request->email,
                'password' => empty($request->password) ? Hash::make('123456') : Hash::make($request->password),
                'active' => ($request->active) ? 1 : 0,
                'email_verified_at' => now(),
            ]);
            $this->userServices->resetRole($id, $request);
        }

        return response()->json(['success' => true, 'message' => 'User updated!']);

    }catch(\ErrorException $e){
        return response()->json($e->getMessage());
    }//end try
} //end function

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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function hapus($id)
    {
        $data = $this->userServices->destroy($id);
        return $data;
    }
    public function getRow($id)
    {
        $data = $this->userServices->getById($id);
        return $data;
    }

    public function searchData($keyword){
        $data = $this->userServices->search($keyword);
        return $data;
    }
}
