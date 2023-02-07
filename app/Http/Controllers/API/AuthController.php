<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use Validator;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function index(){
        $data['menu'] = $this->dataMenu();
        $data['loggedin'] = Auth::check() ? 1 : 0;
        $data['user'] = Auth::check() ? json_encode(Auth::user()) : json_encode(['loggedin' => 0]);
        return view('layouts.template', $data);
    }
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
         ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()
            ->json(['data' => $user,'access_token' => $token, 'token_type' => 'Bearer', ]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if($validator->fails()){
            return response()->json($validator);
        }
        if (!Auth::attempt($request->only('email', 'password')))
        {
            return response()
                ->json(['message' => 'Periksa Kembali Akun Anda!', 'state' => 'failed'], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;
        $user->token = $token;
        $user->loggedin = 1;
        // Auth::login($user); // isloggedin
        return response()->json($user);
    }

    // method for user logout and delete token
    public function logout()
    {
        // auth()->user()->tokens()->delete();
        // Auth::logout();
        Auth::guard('web')->logout();

        setcookie('uid', '',time() - 3600);
        if(!Auth::check()){
            return redirect('/login');
        }
        return redirect('/login');
    }

    public function cekLogin(Request $request){
        if(Auth::check()){
            return response()->json(['loggedIn' => true, 'message' => 'Login Aktif', 'dataUser' => Auth::user()]);
        }else{
            return response()->json(['loggedIn' => false, 'message' => 'Login Tidak Aktif', 'dataUser' => []]);
        }
    }

    private function dataMenuOld(){
        $dataMenu = array(
           ["menu" => "Home","url" => '/dashboard', "icon" => 'Home', "submenu" => [], "is_login" => false ],
           [ "menu" => "Sub Sites", "url" => '#', "icon" => 'Link', "is_login" => false, "submenu" =>  [
                               [ "sub_menu" => 'BDI' , "url" => '/bdi', "sub_icon" => 'Link-2'],
                               [ "sub_menu" => 'DCRM' , "url" => '/dcrm', "sub_icon" => 'Link-2'],
                               [ "sub_menu" => 'EMP Malacca Strait' , "url" => '/emp-malaka', "sub_icon" => 'link-2'],
                               [ "sub_menu" => 'GCG' , "url" => '/gcg', "sub_icon" => 'link-2'],
                               [ "sub_menu" => 'General Manager' , "url" => '/general-manager', "sub_icon" => 'link-2'],
                               [ "sub_menu" => 'ICT' , "url" => '/ict', "sub_icon" => 'link-2'],
                               [ "sub_menu" => 'Risk management' , "url" => '/risk-management', "sub_icon" => 'link-2'],
                               [ "sub_menu" => 'SCM' , "url" => '/scm', "sub_icon" => 'link-2']
                           ]
           ],
           [ "menu" => "Applications", "url" => '/application', "icon" => 'Monitor', "is_login" => true, "submenu" => [
                               [ "sub_menu" => 'FAS - Operating Unit' , "url" => '/fas-operating-unit', "sub_icon" => 'Settings'],
                               [ "sub_menu" => 'HRI' , "url" => '/hris', "sub_icon" => 'settings'],
                               [ "sub_menu" => 'LDIS' , "url" => '/ldis', "sub_icon" => 'settings'],
                               [ "sub_menu" => 'MMIS' , "url" => '/mmis', "sub_icon" => 'settings'],
                               [ "sub_menu" => 'Meeting Room Reservation' , "url" => '/meeting-room', "sub_icon" => 'Clipboard'],
                               [ "sub_menu" => 'ATK' , "url" => '/atk', "sub_icon" => 'settings'],
                               [ "sub_menu" => 'PAWM' , "url" => '/pawm', "sub_icon" => 'settings'],
                               [ "sub_menu" => 'Phone Ext' , "url" => '/phone-ext', "sub_icon" => 'Phone'],
                               [ "sub_menu" => 'Radio Room' , "url" => '/radio-room', "sub_icon" => 'settings'],
                               [ "sub_menu" => 'SCM MI DB' , "url" => '/scm-mi', "sub_icon" => 'settings'],
                               [ "sub_menu" => 'SHE' , "url" => '/she', "sub_icon" => 'settings'],
                               [ "sub_menu" => 'SIAP' , "url" => '/siap', "sub_icon" => 'settings'],
                               [ "sub_menu" => 'Well Monitoring' , "url" => '/well-monitoring', "sub_icon" => 'settings'],
                           ]
           ],
           [ "menu" => "Libraries", "url" => '#', "icon" => 'File-Text', "is_login" => false,"submenu" => [
                               [ "sub_menu" => 'Form', "url" => '/form', "sub_icon" => 'Folder'],
                               [ "sub_menu" => 'Structure Organization', "url" => '/struktur-organisasi', "sub_icon" => 'folder'],
                               [ "sub_menu" => 'Vision, Mision & Value', "url" => '/struktur-organisasi', "sub_icon" => 'folder'],
                               [ "sub_menu" => 'Paper', "url" => '/struktur-organisasi', "sub_icon" => 'folder'],
               ]
           ],
           [ "menu" => "Policies & Procedure", "url" => '#', "icon" => 'Book', "is_login" => false, "submenu" => [
                               [ "sub_menu" => 'All Function ', "url" => '/all-function', "sub_icon" => 'file'],
                               [ "sub_menu" => 'Business Unit', "url" => '/business-unit', "sub_icon" => 'file'],
                               [ "sub_menu" => 'SHE Function', "url" => '/she-function', "sub_icon" => 'file'],
                               [ "sub_menu" => 'Referance', "url" => '/referance', "sub_icon" => 'file'],
               ]
           ],
           [ "menu" => "Link", "url" => '#', "icon" => 'External-Link', "is_login" => false, "submenu" => [
                               [ "sub_menu" => 'EMP ', "url" => 'http://www.emp.id', "sub_icon" => 'Home'],
                               [ "sub_menu" => 'ESDM', "url" => 'http://esdm.go.id', "sub_icon" => 'Home'],
                               [ "sub_menu" => 'SKK-Migas', "url" => 'https://skkmigas.go.id/', "sub_icon" => 'Home'],
               ]
           ],
           [ "menu" => "Management", "url" => '#', "icon" => 'Users', "is_login" => true, "submenu" => [
               [ "sub_menu" => 'Daily Production', "url" => '/management-bod', "sub_icon" => 'Activity'],
               [ "sub_menu" => 'Weekly Chart', "url" => '/management-weekly', "sub_icon" => 'Bar-Chart'],
               [ "sub_menu" => 'Yearly Chart', "url" => '/management-yearly', "sub_icon" => 'Pie-Chart'],
               [ "sub_menu" => 'Task List', "url" => '/management-todo', "sub_icon" => 'List'],
               ]
           ],
           [ "menu" => "Admin", "url" => '#', "icon" => 'Users', "is_login" => true, "submenu" => [
            [ "sub_menu" => 'User Management', "url" => '/admin-users', "sub_icon" => 'Users'],
            [ "sub_menu" => 'Role Management', "url" => '/admin-roles', "sub_icon" => 'User-Check'],
            [ "sub_menu" => 'Permission Management', "url" => '/admin-permission', "sub_icon" => 'Folder-Minus'],
            [ "sub_menu" => 'Modul/Menu Management', "url" => '/admin-menu', "sub_icon" => 'Menu'],
            [ "sub_menu" => 'EMP News', "url" => '/admin-emp-news', "sub_icon" => 'Rss'],
            [ "sub_menu" => 'Media Highlight', "url" => '/admin-media-highlight', "sub_icon" => 'Rss'],
            [ "sub_menu" => 'Company Campaign', "url" => '/admin-company-campaign', "sub_icon" => 'Rss'],
            [ "sub_menu" => 'Info EMP', "url" => '/admin-info-emp', "sub_icon" => 'Rss'],
            [ "sub_menu" => 'Event', "url" => '/admin-event', "sub_icon" => 'calendar'],
            [ "sub_menu" => 'Knowledge Sharings', "url" => '/admin-knowledge-sharing', "sub_icon" => 'share']
           ]
           ]
        );
       return $dataMenu;
   }

   private function dataMenu(){
       $dataMenu = array(
            ["menu" => "Home","url" => '/dashboard', "icon" => 'Home', "submenu" => [], "is_login" => false ],
            [ "menu" => "Company", "url" => '#', "icon" => 'home', "is_login" => false, "submenu" =>  [
                    [ "sub_menu" => 'Vision & Mision' , "url" => '/vision-mision', "sub_icon" => 'Link-2'],
                    [ "sub_menu" => 'Organization Structure' , "url" => '/organization-structure', "sub_icon" => 'Link-2'],
                    [ "sub_menu" => 'Info EMP' , "url" => '/info-emp', "sub_icon" => 'Link-2'],
                    [ "sub_menu" => 'Policy & Procedures' , "url" => '/policy', "sub_icon" => 'Link-2'],
                    [ "sub_menu" => 'Forms' , "url" => '/forms', "sub_icon" => 'Link-2'],
                    [ "sub_menu" => 'Calendar' , "url" => '/calendar', "sub_icon" => 'Link-2'],
                ] //endsub
            ],//endmenu
            [ "menu" => "Community", "url" => '#', "icon" => 'command', "is_login" => false, "submenu" =>  [
                    [ "sub_menu" => 'Knowledge Sharing' , "url" => '/knowledge-sharing', "sub_icon" => 'aperture'],
                    [ "sub_menu" => 'Events & Media' , "url" => '/event', "sub_icon" => 'camera'],
                    [ "sub_menu" => 'Directory' , "url" => '/directory', "sub_icon" => 'folder'],
                    // [ "sub_menu" => 'Chat' , "url" => '/chat', "sub_icon" => 'message-circle'],
                ] //endsub
            ],//endmenu
            [ "menu" => "My EMP", "url" => '#', "icon" => 'home', "is_login" => false, "submenu" =>  [
                    [ "sub_menu" => 'Vacation Request' , "url" => '/vacation-request', "sub_icon" => 'compass'],
                    [ "sub_menu" => 'Payslip' , "url" => '/event', "sub_icon" => 'credit-card'],
                    [ "sub_menu" => 'ICT Helpdesk' , "url" => '/directory', "sub_icon" => 'gitlab'],
                    [ "sub_menu" => 'Onboarding' , "url" => '/chat', "sub_icon" => 'clipboard'],
                    [ "sub_menu" => 'FAQ' , "url" => '/chat', "sub_icon" => 'help-circle'],
                    [ "sub_menu" => 'Linked Apps' , "url" => '/chat', "sub_icon" => 'Link'],
                    [ "sub_menu" => 'Learning' , "url" => '/chat', "sub_icon" => 'database'],
                    [ "sub_menu" => 'My Tasks' , "url" => '/chat', "sub_icon" => 'edit'],
                ] //endsub
            ],//endmenu
            [ "menu" => "Dashboard", "url" => '#', "icon" => 'home', "is_login" => false, "submenu" =>  [
                [ "sub_menu" => 'Production Daily', "url" => '/management-bod', "sub_icon" => 'Activity'],
                [ "sub_menu" => 'Weekly Chart', "url" => '/management-weekly', "sub_icon" => 'Bar-Chart'],
                [ "sub_menu" => 'Yearly Chart', "url" => '/management-yearly', "sub_icon" => 'Pie-Chart'],
                ] //endsub
            ],//endmenu
            [ "menu" => "Admin Management", "url" => '#', "icon" => 'Users', "is_login" => true, "submenu" => [
                [ "sub_menu" => 'User Management', "url" => '/admin-users', "sub_icon" => 'Users'],
                [ "sub_menu" => 'Role Management', "url" => '/admin-roles', "sub_icon" => 'User-Check'],
                [ "sub_menu" => 'Permission Management', "url" => '/admin-permission', "sub_icon" => 'Folder-Minus'],
                [ "sub_menu" => 'Modul/Menu Management', "url" => '/admin-menu', "sub_icon" => 'Menu'],
                [ "sub_menu" => 'EMP Content', "url" => '/backend/management-content', "sub_icon" => 'Rss'],
                // [ "sub_menu" => 'Media Highlight', "url" => '/admin-media-highlight', "sub_icon" => 'Rss'],
                // [ "sub_menu" => 'Company Campaign', "url" => '/admin-company-campaign', "sub_icon" => 'Rss'],
                // [ "sub_menu" => 'Info EMP', "url" => '/admin-info-emp', "sub_icon" => 'Rss'],
                [ "sub_menu" => 'Event', "url" => '/admin-event', "sub_icon" => 'calendar'],
                [ "sub_menu" => 'Knowledge Sharings', "url" => '/admin-knowledge-sharing', "sub_icon" => 'share']
               ]//endsub
            ]//endmenu
        );
        return $dataMenu;
   }
}
