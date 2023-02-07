<?php

use App\Http\Controllers\Admin\ManagementMenuController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SendOtpController;
use App\Mail\TestMail;
use App\Models\Directory;
use App\Models\User;
use App\Notifications\EmailNotification;
use App\Services\NewsServices;
use App\Services\WhatsappApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/send-otp-wa', [SendOtpController::class, 'sendOtpWa']);
Route::get('/send-otp-mail', [SendOtpController::class, 'sendOtpEmail']);
Route::get('/verify-otp', [SendOtpController::class, 'verifyOtp']);
Auth::routes();
//testing API Whatsapp
Route::get('/test-whatsapp', function(){
    $whatsAppService = new WhatsappApi();
    $OTP = random_int(100000, 999999);
    $post = [
        'phone'   => '0811150060',
        'message' => '*EMP SIAP* Kode OTP Anda adalah *'.$OTP.'*. Berlaku selama 3 Menit. (Percobaan)',
        'spintax' => true
      ];
      $whatsAppService->sendMessage($post);

});
//testing template mail
Route::get('/demo-mail', function () {
    $data = [
        'user_id' => '1',
        'name' => 'Rendra',
        'email' => 'rendraprojects@gmail.com',
        'headerNotif' => 'Expired Notifications',
        'bodyNotif' => 'Your library expired date is expired at ' . date('d-m-Y'),
        'contentNotif' => 'Please check your document <span style="color:blue;">nama document</span>',
        'url' => url('/library'),
    ];
    // Notification::route('mail', $data['email'])->notify(new EmailNotification($data));
    return new App\Mail\TestMail($data);
});
//notif email
Route::get('/mail-library', [EmailController::class, 'sendNotificationLibrary']);
//change read_at notification
Route::get('/read-notif', [EmailController::class, 'changeReadNotification']);

Route::get('/privacy', [HomeController::class, 'privacy']);

Route::get('/test', [HomeController::class, 'test']);
Route::get('test_ldap', function () {
    dd(Session::all());
    $ldap_host = "172.25.1.38";
    // connect to active directory
    $ldapconn = ldap_connect($ldap_host, 389) or die("Could not connect to LDAP Server");
    //ldap bind
    $baseDn = "dc=emp-one,dc=com";
    $upn = "ssvc-intranet@emp-one.com";
    $ldappass = "P@ssw0rd27";
    $ldaptree = "cn=ssvc-intranet,cn=Users,dc=emp-one,dc=com";
    // set connection is using protocol version 3, if not will occur warning error.
    ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
    ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);
    if ($ldapconn) {
        // binding to ldap server
        $ldapbind = ldap_bind($ldapconn, $upn, $ldappass);
        // verify binding
        if ($ldapbind) {
            $attributes = [
                'displayname', 'description', 'givenname', 'telephonenumber', 'whencreated', 'whenchanged', 'department', 'company', 'streetaddress',
                'extensionattribute12', 'extensionattribute15', 'name', 'objectguid', 'employeeid', 'samaccountname', 'userprincipalname',
                'mail', 'msexchwhenmailboxcreated', 'physicaldeliveryofficename'
            ];
            $filter = "samaccountname=arief.wicaksono"; //akun login
            $filter = "department=HC & Services"; //sample data
            $results = ldap_search($ldapconn, $baseDn, $filter);
            $info = ldap_get_entries($ldapconn, $results);
            // This is what you're looking for...
            //dd($info[0]);
            $entry_array = $info;
            for ($i = 0; $i < count($entry_array) - 1; $i++) {
                $person = array();
                if ($entry_array[$i]) {
                    foreach ($attributes as $idx => $att) {
                        if (isset($entry_array[$i][$att])) {
                            $person[$att] = json_encode(str_replace("\r\n", "<br/>", $entry_array[$i][$att][0]));
                        } else {
                            $person[$att] = '-';
                        }
                    }
                }
                $person_array[] = $person;
            }
            // dd($person_array);
            foreach($person_array as $check){
            Directory::upsertExtension($check['displayname'], $check);
            }
            ldap_unbind($ldapconn);
            die();
        } //endif
    }
});
// Route::get('/',[App\Http\Controllers\API\AuthController::class, 'index']);
// Route::middleware('auth')->get('/user', function (Request $request) {
//     dd($request->user());
// });
Route::get('login-mobile', [HomeController::class, 'loginMobile'])->name('loginmobile');
Route::post('login-mobile', [HomeController::class, 'checkLoginMobile'])->name('checkloginmobile');
Route::get('login-mobile/check-user-loggedin', function(Request $request){
    //check user with token expo
    $token = $request->token;
    $user = User::where('expo_token', $token)->where('is_loggedin_mobile', 1)->first();
    if(!empty($user)){
        Auth::login($user);
        User::userAssignRole($user->id);
        return response()->json([
            'status' => 'success',
            'message' => 'User logged in',
            'data' => $user
        ]);
    }else{
        return response()->json([
            'status' => 'error',
            'message' => 'User not logged in',
            'data' => null
        ]);
    }
});
Route::get('login', [HomeController::class, 'login'])->name('login');
Route::post('login', [HomeController::class, 'checkLogin']);
Route::get('logout', function(){
    //update user is_loggedin_mobile to 0
    if(Auth::check()){
        User::where('id', Auth::user()->id)->update(['is_loggedin_mobile' => 0]);
        Auth::logout();
    }
    return redirect()->route('login', ['extend' => env('APP_DOMAIN')]);
});
// Route::get('/logout', [App\Http\Controllers\API\AuthController::class, 'logout']);
// Route::get('cek-login',[HomeController::class, 'cekLogin']);
//laravel control
Route::get('logout-web', function (Request $request) {
    unset($_COOKIE['idu']);
    Auth::user()->tokens()->delete();
    Auth::guard('web')->logout();
    Auth::logout();
    return redirect('login');
});

Route::post('uploads-editor/{modul?}', function (Request $request) {
    uploadEditor($request, $request->modul);
});
Route::post('uploads/{modul?}', function (Request $request) { //must add request category
    uploadFile($request);
});
Route::get('test-notif', [HomeController::class, 'testNofiticationExpo']);

Route::middleware(['auth'])->group(function () {
    //profile user
    Route::get('profile', [App\Http\Controllers\HomeController::class, 'profile']);
    Route::post('profile-upload', [App\Http\Controllers\HomeController::class, 'profileUpload']);

    Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
    Route::get('dashboard', [App\Http\Controllers\HomeController::class, 'index']);
    Route::get('management-bod', [App\Http\Controllers\Admin\DashboardManagementController::class, 'daily']);
    Route::get('management-weekly', [App\Http\Controllers\Admin\DashboardManagementController::class, 'weekly']);
    Route::get('management-yearly', [App\Http\Controllers\Admin\DashboardManagementController::class, 'yearly']);

    Route::get('vision-mision', [App\Http\Controllers\CompanyController::class, 'visimisi']);
    Route::get('organization-structure', [App\Http\Controllers\CompanyController::class, 'strukturOrganisasi']);

    Route::get('content/detail/{category}/{id}', [App\Http\Controllers\BlogContentController::class, 'detail'])->middleware('auth');
    Route::get('broadcast/detail/{category}/{id}', [App\Http\Controllers\BlogContentController::class, 'detailBroadcast']);
    Route::get('content/search', [App\Http\Controllers\BlogContentController::class, 'search']);

    Route::get('directory', [App\Http\Controllers\DirectoryController::class, 'index']);
    Route::get('directory/search', [App\Http\Controllers\DirectoryController::class, 'search']);
    Route::get('directory/api-search', [App\Http\Controllers\DirectoryController::class, 'apiSearch']);

    Route::get('knowledges-sharing', [App\Http\Controllers\KnowledgeSharingController::class, 'index']);
    Route::get('knowledges-sharing/detail/{id}', [App\Http\Controllers\KnowledgeSharingController::class, 'detail']);
    Route::get('knowledges-sharing/search', [App\Http\Controllers\KnowledgeSharingController::class, 'search']);

    Route::get('library', [App\Http\Controllers\LibraryController::class, 'index']);
    Route::post('library/revision', [App\Http\Controllers\LibraryController::class, 'updateRevision']);
    Route::post('library/upload', [App\Http\Controllers\LibraryController::class, 'upload']);
    Route::post('library/update', [App\Http\Controllers\LibraryController::class, 'update']);
    Route::get('library/folder/{id}', [App\Http\Controllers\LibraryController::class, 'detailFolder']);
    Route::get('library/filter', [App\Http\Controllers\LibraryController::class, 'index']);
    Route::get('library/info/{idfile}', [App\Http\Controllers\LibraryController::class, 'revision']);
    Route::get('library/info-log/{idfile}', [App\Http\Controllers\LibraryController::class, 'revisionLog']);
    Route::get('library/delete/{id}', [App\Http\Controllers\LibraryController::class, 'destroy']);

    //library
    Route::get('library/get-data', [App\Http\Controllers\LibraryController::class, 'getData']);


    Route::get('event', [App\Http\Controllers\GalleryController::class, 'index']);

    Route::get('gallery', [App\Http\Controllers\GalleryController::class, 'index']);
    Route::post('gallery/store', [App\Http\Controllers\GalleryController::class, 'store']);
    Route::post('gallery/upload', [App\Http\Controllers\GalleryController::class, 'upload']);
    Route::post('gallery/update', [App\Http\Controllers\GalleryController::class, 'update']);
    Route::get('gallery/folder/{id}', [App\Http\Controllers\GalleryController::class, 'detailFolder']);
    Route::get('gallery/filter', [App\Http\Controllers\GalleryController::class, 'filter']);
    Route::get('gallery/info/{type}/{idfile}', [App\Http\Controllers\GalleryController::class, 'info']);
    Route::get('gallery/delete/{id}/{type}', [App\Http\Controllers\GalleryController::class, 'destroy']);
    //11504
    Route::get('info-emp', function () {
        return redirect('content/search');
    });

    Route::get('calendar', [App\Http\Controllers\CalendarController::class, 'index']);
    Route::get('calendar/detail/{id}', [App\Http\Controllers\CalendarController::class, 'detail']);
    Route::post('calendar/store', [App\Http\Controllers\CalendarController::class, 'store']);

    Route::get('/management-content', [App\Http\Controllers\Admin\NewsController::class, 'table']);

    //===== Backend Admin ============
    Route::prefix('backend')->group(function () {
        //CRUD Dashboard
        Route::get('dashboard', [App\Http\Controllers\Admin\DashboardManagementController::class, 'add']);
        Route::get('dashboard/add', [App\Http\Controllers\Admin\DashboardManagementController::class, 'add']);
        Route::get('dashboard/filter', [App\Http\Controllers\Admin\DashboardManagementController::class, 'filter']);
        Route::post('dashboard/save-daily', [App\Http\Controllers\Admin\DashboardManagementController::class, 'saveDaily']);

        //CRUD budget dashboard
        Route::get('dashboard/add-budget', [App\Http\Controllers\Admin\DashboardManagementController::class, 'addBudget']);
        Route::post('dashboard/save-budget', [App\Http\Controllers\Admin\DashboardManagementController::class, 'saveBudget']);
        Route::get('dashboard/filter-budget', [App\Http\Controllers\Admin\DashboardManagementController::class, 'filterBudget']);

        //users
        Route::get('admin-users', [App\Http\Controllers\Admin\ManagementUsersController::class, 'index']);
        Route::get('get-admin-users', [App\Http\Controllers\Admin\ManagementUsersController::class, 'datatable']);
        Route::post('users', [App\Http\Controllers\Admin\ManagementUsersController::class, 'store']);
        Route::get('users/{id}', [App\Http\Controllers\Admin\ManagementUsersController::class, 'getRow']);
        //notifikasi mobile
        Route::get('notifikasi', [App\Http\Controllers\Admin\NotifikasiController::class, 'getIndex']);
        Route::get('notifikasi/resend/{id}', [App\Http\Controllers\Admin\NotifikasiController::class, 'resend']);
        Route::get('notifikasi/add', [App\Http\Controllers\Admin\NotifikasiController::class, 'add']);
        Route::post('notifikasi/store', [App\Http\Controllers\Admin\NotifikasiController::class, 'store']);
        Route::get('notifikasi/edit/{id}', [App\Http\Controllers\Admin\NotifikasiController::class, 'edit']);
        Route::get('notifikasi/delete/{id}', [App\Http\Controllers\Admin\NotifikasiController::class, 'hapus']);
        Route::post('notifikasi/update/{id}', [App\Http\Controllers\Admin\NotifikasiController::class, 'update']);
        Route::post('notifikasi-repeat', [App\Http\Controllers\Admin\NotifikasiController::class, 'updateParams']);
        Route::post('notifikasi/update-otp',[App\Http\Controllers\Admin\NotifikasiController::class, 'updateSettingOtp']);


        Route::get('management-content', [App\Http\Controllers\Admin\NewsController::class, 'getIndex']);
        Route::get('management-content/add', [App\Http\Controllers\Admin\NewsController::class, 'add']);
        Route::post('management-content/store', [App\Http\Controllers\Admin\NewsController::class, 'store']);
        Route::get('management-content/edit/{id}', [App\Http\Controllers\Admin\NewsController::class, 'edit']);
        Route::get('management-content/delete/{id}', [App\Http\Controllers\Admin\NewsController::class, 'hapus']);
        Route::post('management-content/update/{id}', [App\Http\Controllers\Admin\NewsController::class, 'update']);
        //management content
        Route::get('management-broadcast', [App\Http\Controllers\Admin\BroadcastController::class, 'getIndex']);
        Route::get('management-broadcast/add', [App\Http\Controllers\Admin\BroadcastController::class, 'add']);
        Route::post('management-broadcast/store', [App\Http\Controllers\Admin\BroadcastController::class, 'store']);
        Route::get('management-broadcast/edit/{id}', [App\Http\Controllers\Admin\BroadcastController::class, 'edit']);
        Route::get('management-broadcast/delete/{id}', [App\Http\Controllers\Admin\BroadcastController::class, 'hapus']);
        Route::post('management-broadcast/update/{id}', [App\Http\Controllers\Admin\BroadcastController::class, 'update']);

        Route::get('management-knowledge-sharing', [App\Http\Controllers\Admin\ManagementKnowledgeSharingController::class, 'getIndex']);
        Route::get('management-knowledge-sharing/add', [App\Http\Controllers\Admin\ManagementKnowledgeSharingController::class, 'add']);
        Route::post('management-knowledge-sharing/store', [App\Http\Controllers\Admin\ManagementKnowledgeSharingController::class, 'store']);
        Route::get('management-knowledge-sharing/edit/{id}', [App\Http\Controllers\Admin\ManagementKnowledgeSharingController::class, 'edit']);
        Route::get('management-knowledge-sharing/delete/{id}', [App\Http\Controllers\Admin\ManagementKnowledgeSharingController::class, 'hapus']);
        Route::post('management-knowledge-sharing/update/{id}', [App\Http\Controllers\Admin\ManagementKnowledgeSharingController::class, 'update']);

        Route::get('management-library', [App\Http\Controllers\Admin\ManagementLibraryController::class, 'getIndex']);
        Route::get('management-library/add', [App\Http\Controllers\Admin\ManagementLibraryController::class, 'add']);
        Route::post('management-library/store', [App\Http\Controllers\Admin\ManagementLibraryController::class, 'store']);
        Route::get('management-library/edit/{id}', [App\Http\Controllers\Admin\ManagementLibraryController::class, 'edit']);
        Route::get('management-library/delete/{id}', [App\Http\Controllers\Admin\ManagementLibraryController::class, 'hapus']);
        Route::post('management-library/update/{id}', [App\Http\Controllers\Admin\ManagementLibraryController::class, 'update']);

        Route::get('menu/get-list', [App\Http\Controllers\Admin\ManagementMenuController::class, 'index']);
        Route::get('menu/get-all', [App\Http\Controllers\Admin\ManagementMenuController::class, 'getAll']);
        Route::post('menu', [App\Http\Controllers\Admin\ManagementMenuController::class, 'store']);
        Route::put('menu/{id}', [App\Http\Controllers\Admin\ManagementMenuController::class, 'update']);
        Route::get('menu-delete/{id}', [App\Http\Controllers\Admin\ManagementMenuController::class, 'hapus']);
        Route::get('menu/{id}', [App\Http\Controllers\Admin\ManagementMenuController::class, 'getRow']);

        //permission
        Route::get('permission/get-list', [App\Http\Controllers\Admin\ManagementPermissionController::class, 'index']);
        Route::post('permission', [App\Http\Controllers\Admin\ManagementPermissionController::class, 'store']);
        Route::put('permission/{id}', [App\Http\Controllers\Admin\ManagementPermissionController::class, 'update']);
        Route::get('permission-delete/{id}', [App\Http\Controllers\Admin\ManagementPermissionController::class, 'hapus']);
        Route::get('permission/{id}', [App\Http\Controllers\Admin\ManagementPermissionController::class, 'getRow']);
        //role & setting modul
        Route::get('role/get-list', [App\Http\Controllers\Admin\ManagementRoleController::class, 'index']);
        Route::post('role', [App\Http\Controllers\Admin\ManagementRoleController::class, 'store']);
        Route::put('role/{id}', [App\Http\Controllers\Admin\ManagementRoleController::class, 'update']);
        Route::get('role-delete/{id}', [App\Http\Controllers\Admin\ManagementRoleController::class, 'hapus']);
        Route::get('role/{id}', [App\Http\Controllers\Admin\ManagementRoleController::class, 'getRow']);
        Route::get('role-modul/{idrole}', [App\Http\Controllers\Admin\ManagementRoleController::class, 'getRoleModul']);
        Route::post('role-modul/{idrole}', [App\Http\Controllers\Admin\ManagementRoleController::class, 'storeRoleModul']);
    });

    Route::group(['prefix' => 'laravel-filemanager'], function () {
        \UniSharp\LaravelFilemanager\Lfm::routes();
    });

    // Route::get('/{any}',[App\Http\Controllers\API\AuthController::class, 'index']);
});

//vue control
// Route::get('/{any}/{sub}',[App\Http\Controllers\API\AuthController::class, 'index']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
