<?php

namespace App\Http\Controllers;

use app\Helpers\ldap_connection;
use App\Models\Broadcast;
use App\Models\Calendar;
use App\Models\Menu;
use App\Models\News;
use App\Models\User;
use App\Models\UserProfile;
use App\Services\KnowledgeSharingServices;
use App\Models\Directory;
use App\Models\GeneralParams;
use App\Models\OtpUser;
use App\Models\UserTokenExpo;
use App\Notifications\ActivateNotification;
use App\Services\CalendarServices;
use App\Services\ExpoService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Jenssegers\Agent\Agent;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $serviceKnowledgeSharing;
    public function __construct(KnowledgeSharingServices $services)
    {
        $this->middleware('web');
        $this->serviceKnowledgeSharing = $services;
    }

    public function testNofiticationExpo()
    {
        $channelName = 'news';
        $recipient = 'ExponentPushToken[EmVt8LLhAhk2QRyZq1Qno0]';
        $title = 'Hallo ada ' . $channelName . ' terbaru!';
        $body = 'Ayo, Cek Sekarang.';

        $data = json_encode(array('event' => 'knowledges-sharing/detail/fh89i7dd9X092521'));
        // You can quickly bootup an expo instance
        $expo = new ExpoService();
        $expo->sendPushNotification($recipient, $title, $body, $data, 'fh89i7dd9X092521');
    }

    public function dataDashboard()
    {
        $empNews = News::where('category', 'like', '%news%')->where('active', 1)->limit(8)->get();
        $empMedia = News::where('category', 'like', '%media%')->where('active', 1)->whereRaw('banner_path is not null')->limit(8)->get();
        $empInfo = News::where('category', 'like', '%info%')->where('active', 1)->limit(8)->get();
        $campaign = News::where('category', 'like', '%campaign%')->where('active', 1)->limit(8)->get();

        return response()->json(['news' => $empNews, 'media' => $empMedia, 'info' => $empInfo, 'campaign' => $campaign]);
    }

    public function loginMobile()
    {
        $data['banner'] = Broadcast::where('type', 'like', '%login-slider%')
            ->where('active', 1)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('auth.login-mobile', $data);
    }

    public function login()
    {
        if (Auth::check()) {
            if (!session()->has('url.intended')) {
                session(['url.intended' => env('APP_DOMAIN')]);
            }
        }
        //set params otp
        $otp = GeneralParams::getArray('setting-otp');
        $data['otp'] = empty($otp) ? null : $otp;
        $data['banner'] = Broadcast::where('type', 'like', '%login-slider%')
            ->where('active', 1)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('auth.login', $data);
    }

    public function checkLogin(Request $request)
    {
        //cek environment
        if (env('APP_ENV') != 'local') { //use ldap
            $ldap = new ldap_connection();
            $userlogin = str_contains($request->email, '@');
            if (!$userlogin) {
                $userlogin = $request->email . '@emp-one.com';
            } else {
                $userlogin = $request->email;
            }
            $filter = "(|(mail=" . $userlogin . ")(userprincipalname=" . $userlogin . ")(samaccountname=" . $request->email . "))";
            $check = $ldap->search($filter, $userlogin, $request->password);
            // $check = $parse;
            if (!empty($check)) {
                //1. update data user and user profile database
                $username = str_replace('"', '', $check['samaccountname']);
                $checkExist = User::where('email', $username . '@emp-one.com')->first();
                if (empty($checkExist)) {
                    $create = new User();
                    $create->id = generate_id();
                    $idUser = $create->id;
                    $create->name = str_replace('"', '', $check['displayname']);
                    $create->email = str_replace('"', '', $username) . '@emp-one.com';
                    $create->password = bcrypt($request->password);
                    $create->active = 1;
                    $create->save();
                    //cek role assign role
                    User::userAssignRole($create->id);
                    //save profile
                    $profile = new UserProfile();
                    $profile->created_at = now();
                    $profile->id = generate_id();
                } else {
                    $profile = UserProfile::where('user_id', $checkExist->id)->first();
                    if (empty($profile)) {
                        $profile = new UserProfile();
                        $profile->id = generate_id();
                    }
                    $idUser = $checkExist->id;
                }
                $profile->user_id = $idUser;
                $profile->profile_detail = json_encode($check);
                $profile->created_by = $idUser;
                $profile->updated_at = now();
                $profile->updated_by = $idUser;
                $profile->save();

                if (isset($request->_expotoken) && !empty($request->_expotoken)) {
                    //check user token expo table
                    $cek = UserTokenExpo::where('expo_token', $request->_expotoken)->first();
                    if (empty($cek)) {
                        $token = new UserTokenExpo();
                        $token->id = generate_id();
                        $token->user_id = $idUser;
                        $token->expo_token = $request->_expotoken;
                        $token->created_at = now();
                        $token->updated_at = now();
                        $token->save();
                    }
                }

                $agent = new Agent();
                $mobile = $agent->isMobile();
                //2. registrasi auth
                $regisAuth = User::find($idUser);
                //update user is loggedin mobile
                $updateMobile = $regisAuth;
                //update user is loggedin mobile
                $updateMobile->is_loggedin_mobile = $mobile ? 1 : 0;
                $updateMobile->save();

                $token = $regisAuth->createToken('auth_token')->plainTextToken;
                $prof = UserProfile::where('user_id', $idUser)->first();
                $regisAuth->token = $token;
                $regisAuth->loggedin = 1;
                $regisAuth->profile = $prof;
                Auth::login($regisAuth); // isloggedin
                Session::put('user_profile', json_decode($regisAuth->profile->profile_detail, 1));

                //3. upsert to directories extension
                Directory::upsertExtension($check['displayname'], $check);
                //4. fitur otp check
                //check expired user otp
                $sendOtp = false;
                $checkOtp = OtpUser::where('user_id', $idUser)->latest()->first();
                if(empty($checkOtp)){
                    $sendOtp = true;
                }else{
                    //check if last device is different : mobile, device_name, device_platform, ip_address
                    if($checkOtp->is_mobile != $mobile || $checkOtp->device_name != $agent->device() || $checkOtp->device_platform != $agent->platform() || $checkOtp->ip_address != $request->getClientIp(true) ){
                        $sendOtp = true;
                    }
                    //check if expired date is less than now
                    $expired = Carbon::parse($checkOtp->expired_date);
                    $now = Carbon::now();
                    if($expired->lessThan($now)){
                        $sendOtp = true;
                    }else{
                        if($checkOtp->status == 'send'){
                            $sendOtp = true;
                        }
                    }
                }
                //check user phone on user profile
                $regisAuth->phone = $profile ? $profile->phone : '';
                $regisAuth->profile = $profile ? json_decode($profile->profile_detail, 1) : '';
                $regisAuth->sendOtp = $sendOtp;
                $regisAuth->email = !empty($profile->user_email) ? $profile->user_email : json_decode($profile->profile_detail, 1)['mail'];

                return response()->json($regisAuth);
            } else {
                return response()
                    ->json(['message' => 'Periksa Kembali Akun Anda!', 'state' => 'failed'], 401);
            }
        } //end LDAP

        //menggunakan env local database
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator);
        }
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()
                ->json(['message' => 'Periksa Kembali Akun Anda!', 'state' => 'failed'], 401);
        }
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'active' => 1])) {
            $user = User::where('email', $request['email'])->firstOrFail();
            //row user profile
            $profile = UserProfile::where('user_id', $user->id)->first();
            //check is mobile
            $agent = new Agent();
            $mobile = $agent->isMobile();
            //update user is loggedin mobile
            $updateMobile = $user;
            $updateMobile->is_loggedin_mobile = $mobile ? 1 : 0;
            $updateMobile->save();

            if (isset($request->_expotoken) && !empty($request->_expotoken)) {
                //check user token expo table
                $cek = UserTokenExpo::where('expo_token', $request->_expotoken)->first();
                if (empty($cek)) {
                    $token = new UserTokenExpo();
                    $token->id = generate_id();
                    $token->user_id = $user->id;
                    $token->expo_token = $request->_expotoken;
                    $token->created_at = now();
                    $token->updated_at = now();
                    $token->save();
                }
            }
            //check expired user otp
            $sendOtp = false;
            $checkOtp = OtpUser::where('user_id', $user->id)->latest()->first();
            if(empty($checkOtp)){
                $sendOtp = true;
            }else{
                //check if last device is different : mobile, device_name, device_platform, ip_address
                if($checkOtp->is_mobile != $mobile || $checkOtp->device_name != $agent->device() || $checkOtp->device_platform != $agent->platform() || $checkOtp->ip_address != $request->getClientIp(true) ){
                    $sendOtp = true;
                }
                //check if expired date is less than now
                $expired = Carbon::parse($checkOtp->expired_date);
                $now = Carbon::now();
                if($expired->lessThan($now)){
                    $sendOtp = true;
                }else{
                    if($checkOtp->status == 'send'){
                        $sendOtp = true;
                    }
                }
            }
            $token = $user->createToken('auth_token')->plainTextToken;
            $user->token = $token;
            $user->loggedin = 1;
            $user->phone = !empty($profile->phone) ? $profile->phone : json_decode($profile->profile_detail, 1)['telephonenumber'];
            $user->profile = $profile ? json_decode($profile->profile_detail, 1) : '';
            $user->sendOtp = $sendOtp;
            $user->email = !empty($profile->user_email) ? $profile->user_email : json_decode($profile->profile_detail, 1)['mail'];

            Auth::login($user); // isloggedin
            //cek role assign role
            User::userAssignRole($user->id);
            return response()->json($user);
        }
    }

    public function checkLoginMobile(Request $request)
    {
        //cek environment
        if (env('APP_ENV') != 'local') { //use ldap
            $ldap = new ldap_connection();
            $userlogin = str_contains($request->email, '@');
            if (!$userlogin) {
                $userlogin = $request->email . '@emp-one.com';
            } else {
                $userlogin = $request->email;
            }
            $filter = "(|(mail=" . $userlogin . ")(userprincipalname=" . $userlogin . ")(samaccountname=" . $request->email . "))";
            $check = $ldap->search($filter, $userlogin, $request->password);
            // $check = $parse;
            if (!empty($check)) {
                //1. update data user and user profile database
                $username = str_replace('"', '', $check['samaccountname']);
                $checkExist = User::where('email', $username . '@emp-one.com')->first();
                if (empty($checkExist)) {
                    $create = new User();
                    $create->id = generate_id();
                    $idUser = $create->id;
                    $create->name = str_replace('"', '', $check['displayname']);
                    $create->email = str_replace('"', '', $username) . '@emp-one.com';
                    $create->password = bcrypt($request->password);
                    $create->active = 1;
                    $create->save();
                    //cek role assign role
                    User::userAssignRole($create->id);
                    //save profile
                    $profile = new UserProfile();
                    $profile->created_at = now();
                    $profile->id = generate_id();
                } else {
                    $profile = UserProfile::where('user_id', $checkExist->id)->first();
                    if (empty($profile)) {
                        $profile = new UserProfile();
                        $profile->id = generate_id();
                    }
                    $idUser = $checkExist->id;
                }
                $profile->user_id = $idUser;
                $profile->profile_detail = json_encode($check);
                $profile->created_by = $idUser;
                $profile->updated_at = now();
                $profile->updated_by = $idUser;
                $profile->save();

                if (isset($request->_expotoken) && !empty($request->_expotoken)) {
                    //check user token expo table
                    $cek = UserTokenExpo::where('expo_token', $request->_expotoken)->first();
                    if (empty($cek)) {
                        $token = new UserTokenExpo();
                        $token->id = generate_id();
                        $token->user_id = $idUser;
                        $token->expo_token = $request->_expotoken;
                        $token->created_at = now();
                        $token->updated_at = now();
                        $token->save();
                    }
                }

                //2. registrasi auth
                $regisAuth = User::find($idUser);
                //update user is loggedin mobile
                $updateMobile = $regisAuth;
                $updateMobile->is_loggedin_mobile = 1;
                $updateMobile->save();

                $token = $regisAuth->createToken('auth_token')->plainTextToken;
                $regisAuth->token = $token;
                $regisAuth->loggedin = 1;
                $regisAuth->profile = UserProfile::where('user_id', $idUser)->first();
                Auth::login($regisAuth); // isloggedin
                Session::put('user_profile', json_decode($regisAuth->profile->profile_detail, 1));

                //3. upsert to directories extension
                Directory::upsertExtension($check['displayname'], $check);

                return response()->json($regisAuth);
            } else {
                return response()
                    ->json(['message' => 'Periksa Kembali Akun Anda!', 'state' => 'failed'], 401);
            }
        }
        //menggunakan env local database
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator);
        }
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()
                ->json(['message' => 'Periksa Kembali Akun Anda!', 'state' => 'failed'], 401);
        }
        $token = $request->token;
        $user = User::where('expo_token', $token)->where('is_loggedin_mobile', 1)->first();

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'active' => 1])) {
            $user = User::where('email', $request['email'])->firstOrFail();
            //update user is loggedin mobile
            $updateMobile = $user;
            $updateMobile->is_loggedin_mobile = 1;
            $updateMobile->save();

            if (isset($request->_expotoken) && !empty($request->_expotoken)) {
                //check user token expo table
                $cek = UserTokenExpo::where('expo_token', $request->_expotoken)->first();
                if (empty($cek)) {
                    $token = new UserTokenExpo();
                    $token->id = generate_id();
                    $token->user_id = $user->id;
                    $token->expo_token = $request->_expotoken;
                    $token->created_at = now();
                    $token->updated_at = now();
                    $token->save();
                }
            }

            $token = $user->createToken('auth_token')->plainTextToken;
            $user->token = $token;
            $user->loggedin = 1;

            Auth::login($user); // isloggedin
            //cek role assign role
            User::userAssignRole($user->id);
            return response()->json($user);
        }
    }

    public function index(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/login?extend='.session()->get('url.intended'));
        }

        // if (session()->has('url.intended')) {
        //     $url = session()->get('url.intended');
        //     Session::forget('url.intended');
        //     return redirect($url);
        // }
        $data['menu'] = Menu::menu();
        $request->active = 1;
        // dd(Auth::check());
        //data dashboard
        $empNews = News::where('category', 'like', '%news%')->where('active', 1)->whereRaw('banner_path is not null')->orderBy('created_at', 'desc')->limit(4)->get();
        $empMedia = News::where('category', 'like', '%media%')->where('active', 1)->whereRaw('banner_path is not null')->orderBy('created_at', 'desc')->limit(4)->get();
        $empInfo = News::where('category', 'like', '%info%')->where('active', 1)->orderBy('created_at', 'desc')->limit(4)->get();
        $campaign = News::where('category', 'like', '%campaign%')->where('active', 1)->whereRaw('banner_path is not null')->orderBy('created_at', 'desc')->limit(4)->get();
        $data['news'] = $empNews;
        $data['media'] = $empMedia;
        $data['info'] = $empInfo;
        $data['campaign'] = $campaign;

        $requestCalendar = $request;
        $requestCalendar->active = 1;
        $requestCalendar->nodelete = 1;
        $requestCalendar->year = date('Y');
        $requestCalendar->orderBy = "asc";
        $requestCalendar->comeNear = true;
        $calendar = new CalendarServices();
        $dataCalendar = $calendar->getAllWithFilter($requestCalendar, 1, 1);
        // dd($dataCalendar);
        $data['dataEvent'] = $dataCalendar;
        //knowledge sharing
        $data['message'] = Broadcast::where('type', 'like', '%homepage-message%')
            ->where('active', 1)
            ->orderBy('created_at', 'desc')
            ->get();

        $data['knowledgeSharing'] = $this->serviceKnowledgeSharing->getAllWithFilter($request, 1);

        return view('dashboard.home-dashboard', $data);
    }

    public function cekLogin(Request $request)
    {
        if (Auth::check()) {
            return response()->json(['loggedIn' => true, 'message' => 'Login Aktif', 'dataUser' => Auth::user()]);
        } else {
            return response()->json(['loggedIn' => false, 'message' => 'Login Tidak Aktif', 'dataUser' => []]);
        }
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function profile(Request $request)
    {
        $data['menu'] = Menu::menu();
        $data['user'] = Auth::user();
        $label = [
            'Display Name' => 'displayname', 'Given Name' => 'givenname', 'Description' => 'description',
            'Telp Number' => 'telephonenumber', 'Department' => 'department', 'Company' => 'company', 'Divisi' => 'division',
            'SamAccount' => 'samaccountname', 'Email' => 'mail', 'Phone Office' => 'physicaldeliveryofficename', 'Principal' => 'userprincipalname',
            'Ext' => 'extensionattribute15', 'Created At Account' => 'created_at', 'Updated At Account' => 'updated_at'
        ];
        $data['label'] = $label;
        $profile = UserProfile::where('user_id', $data['user']->id)->first();
        if (empty($profile)) {
            $data['profile'] = new UserProfile();
            $data['profileDetail'] = [];
            $data['nomor_wa'] = '';
            $data['email'] = '';
            $data['photo'] = '';
        } else {
            $data['profile'] = json_decode($profile->profile_detail, 1);
            $data['profileDetail'] = json_decode($profile->profile_detail, 1);
            $data['profileDetail']['created_at'] = tanggalLdap($data['profileDetail']['whencreated']);
            $data['profileDetail']['updated_at'] = tanggalLdap($data['profileDetail']['whenchanged']);
            $phone = str_replace("+62","",$profile->phone);
            if(substr($phone, 0, 1) == '0'){
                $phone = substr($phone, 1);
            }
            $data['nomor_wa'] = $phone;
            $data['email'] = $profile->user_email;
            $data['photo'] = $profile->path_photo;
        }
        return view('dashboard.profile', $data);
    }

    public function profileUpload(Request $request)
    {
        $user = Auth::user();
        $userProfile = UserProfile::where('user_id', $user->id)->first();
        //upload File Photo
        $request->category = 'photo-profile';
        $path = uploadFile($request);
        if (!empty($path)) {
            $userProfile->path_photo = $path;
        }
        $userProfile->phone = '+62'.$request->no_wa;
        $userProfile->user_email = $request->email;
        $userProfile->save();
        return redirect('/profile')->with('success', 'Profile Berhasil Di Update');
    }

    public function privacy(){
        if (Auth::check()) {
            if (!session()->has('url.intended')) {
                session(['url.intended' => env('APP_DOMAIN')]);
            }
        }

        $data['policy'] = Broadcast::where('type', 'like', '%policy%')
            ->where('active', 1)
            ->first();
        return view('privacy', $data);
    }
}
